<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      車検証QR読み取り（普通車 / 軽自動車）ZXing版（getUserMedia先行）
    </h2>
  </x-slot>

  <div class="max-w-2xl mx-auto p-4 space-y-4">
    <!-- ツールバー -->
    <div class="flex flex-wrap gap-2 items-center">
      <button id="tab-normal" class="px-3 py-2 rounded bg-blue-600 text-white">普通車</button>
      <button id="tab-kei" class="px-3 py-2 rounded bg-gray-200">軽自動車</button>
      <span id="vehTag" class="ml-auto text-sm text-gray-600">モード: 普通車</span>
    </div>

    <!-- カメラ選択 -->
    <div class="flex gap-2 items-center">
      <label class="text-sm text-gray-600">カメラ:</label>
      <select id="cameraSelect" class="border p-1 rounded min-w-[240px]"></select>
      <button id="reopen" class="px-3 py-1 bg-gray-200 rounded">再オープン</button>
    </div>

    <!-- エラー表示 -->
    <div id="camErr" class="hidden text-sm text-red-600"></div>

    <!-- ★ 明示 video（必ずサイズを持たせる） -->
    <video id="preview" autoplay playsinline muted
           style="width:100%;max-width:480px;height:270px;background:#000;border-radius:.5rem;object-fit:cover"></video>

    <!-- フォーム -->
    <form id="result-form" class="space-y-2">
      <div><label class="block text-sm">車台番号（VIN）</label>
        <input id="vin" name="vin" class="border p-2 w-full" readonly>
      </div>
      <div><label class="block text-sm">原動機型式</label>
        <input id="engine" name="engine" class="border p-2 w-full" readonly>
      </div>
      <div><label class="block text-sm">型式</label>
        <input id="model" name="model" class="border p-2 w-full" readonly>
      </div>
      <div><label class="block text-sm">初度登録年月</label>
        <input id="firstReg" name="firstReg" class="border p-2 w-full" readonly>
      </div>
      <div><label class="block text-sm">ナンバー</label>
        <input id="plate" name="plate" class="border p-2 w-full" readonly>
      </div>
      <div><label class="block text-sm">車検満了日</label>
        <input id="expiry" name="expiry" class="border p-2 w-full" readonly>
      </div>
      <div><label class="block text-sm">型式類別（5桁-4桁）</label>
        <input id="typeClass" name="typeClass" class="border p-2 w-full" readonly>
      </div>

      <div class="pt-2">
        <button type="button" id="sendBtn" class="bg-blue-600 text-white px-4 py-2 rounded">保存</button>
        <button type="button" id="resumeBtn" class="ml-2 bg-gray-200 px-4 py-2 rounded">再スキャン</button>
      </div>
    </form>

    <pre id="debug" class="p-3 bg-gray-50 text-xs overflow-auto h-40"></pre>
  </div>
</x-app-layout>

<!-- ZXing -->
<script src="https://unpkg.com/@zxing/library@0.19.2"></script>
<script src="https://unpkg.com/@zxing/browser@0.1.5"></script>

<script>
/* ====== 便利関数 ====== */
const $ = id => document.getElementById(id);
function setField(id, v){ const el=$(id); if(el && v!=null && v!=='') el.value=v; }
function clearForm(){ ['vin','engine','model','firstReg','plate','expiry','typeClass'].forEach(id=>{ const el=$(id); if(el) el.value=''; }); }
function allFormInputsFilled(){ const inputs=[...document.querySelectorAll('#result-form input')]; return inputs.length>0 && inputs.every(el => (el.value||'').trim()!==''); }
function setVehTag(txt){ const t=$('vehTag'); if(t) t.textContent='モード: '+txt; }
function showCamErr(msg){ const d=$('camErr'); if(!d) return; d.textContent=msg; d.classList.remove('hidden'); }
function hideCamErr(){ const d=$('camErr'); if(!d) return; d.classList.add('hidden'); d.textContent=''; }
function logDebug(raw, parts, note=''){ const pre=$('debug'); if(!pre) return; pre.textContent = `[${new Date().toLocaleTimeString()}] ${note}
RAW:
${raw}

SPLIT(${parts.length}):
${parts.map((p,i)=>`${i}: ${p}`).join('\n')}
`;}

/* ====== 判定/変換（これまで通り） ====== */
const RE = {
  yymm: /^(?:\d{4}|9999)$/,
  model: /^[A-Z0-9-]{3,20}$/,
  vin: /^[A-Z0-9-]{6,25}$/i,
  engine: /^[A-Z0-9]{2,12}$/,
  plate: /^[^\s\/]+[ \u3000]+[0-9]{2,3}[\u3041-\u3096][0-9・･\-]{1,4}$/u,
  typeClass9: /^\d{9}$/
};
function yymmToYYYYMM(yymm){ if(!yymm || yymm==='9999') return ''; const yy=+yymm.slice(0,2), mm=yymm.slice(2,4); const y=yy>=70?1900+yy:2000+yy; return `${y}-${mm}`; }
function yymmddToYYYY_MM_DD(s){ if(!/^\d{6}$/.test(s)) return ''; const yy=+s.slice(0,2), mm=s.slice(2,4), dd=s.slice(4,6); const y=yy>=70?1900+yy:2000+yy; return `${y}-${mm}-${dd}`; }
function formatTypeClass9(s){ return RE.typeClass9.test(s)?`${s.slice(0,5)}-${s.slice(5,9)}`:''; }

function tryExtractPlate(str){ if(!str) return ''; const s=str.normalize('NFKC').trim(); const m=s.match(/[^\s\/]+[ \u3000]+[0-9]{2,3}[\u3041-\u3096][0-9・･\-]{1,4}/u); return m?m[0]:''; }
function looksPlate(parts){
  if(parts.length===2){ const body=(parts[1]||'').trim(); if(RE.plate.test(body)||tryExtractPlate(body)) return true; }
  if(parts.length===1){ const body=(parts[0]||'').trim(); if(RE.plate.test(body)||tryExtractPlate(body)) return true; }
  if(parts.length===2){ const body=(parts[1]||'').trim(); if(tryExtractPlate(body)) return true; }
  return false;
}
function parsePlate(parts, acc){
  let cand=parts.length===2?(parts[1]||'').trim():(parts[0]||'').trim();
  let p=RE.plate.test(cand)?cand:tryExtractPlate(cand);
  if(p) p=p.replace(/^[\s・･-]+|[\s・･-]+$/g,'');
  if(p){ acc.plate ||= p; acc._plate=true; }
}
function pickQR2Fields(parts){
  if(parts.length===6) return { vin:(parts[3]||'').trim(), engine:(parts[4]||'').trim(), ok:true, variant:6 };
  if(parts.length===5) return { vin:(parts[2]||'').trim(), engine:(parts[3]||'').trim(), ok:true, variant:5 };
  return { vin:'', engine:'', ok:false, variant:0 };
}
function looksQR2(parts){
  const f=pickQR2Fields(parts);
  if(!f.ok) return false;
  if(parts.length===6 && !/[A-Za-z]/.test(f.vin)) return false; // 数字だけVINを弾く
  if(!f.vin || f.vin==='-') return false;
  if(!RE.vin.test(f.vin)) return false;
  if(f.engine && f.engine!=='-' && !RE.engine.test(f.engine)) return false;
  return true;
}
function parseQR2(parts, acc){ const f=pickQR2Fields(parts); if(!f.ok) return; if(f.vin) acc.vin ||= f.vin; if(f.engine && f.engine!=='-') acc.engine ||= f.engine; acc._qr2=true; }
function looksQR3(parts){ if(parts.length<10) return false; const yymm=(parts[6]||'').trim(), model=(parts[7]||'').trim(); if(!yymm || !model || yymm==='-' || model==='-') return false; return RE.yymm.test(yymm)&&RE.model.test(model); }
function parseQR3(parts, acc){ acc.firstReg ||= (parts[6]||'').trim(); acc.model ||= (parts[7]||'').trim(); acc._qr3=true; }
function looksModelOnly(parts){ if(parts.length<6 || parts.length>9) return false; const head=(parts[0]||'').trim(); const dashCount=parts.filter(p => (p||'').trim()==='-').length; return RE.model.test(head)&&dashCount>=2; }
function parseModelOnly(parts, acc){ const head=(parts[0]||'').trim(); if(RE.model.test(head)){ acc.model ||= head; acc._modelOnly=true; } }
function looksExpiryBlock(parts){ return parts.length===6 && /^\d{6}$/.test((parts[3]||'').trim()); }
function parseExpiryBlock(parts, acc){ const iso=yymmddToYYYY_MM_DD((parts[3]||'').trim()); if(iso){ acc.expiry=iso; acc._expiry=true; } }
function looksFirstReg6Block(parts){ return parts.length===6 && /^\d{4}$/.test((parts[4]||'').trim()); }
function parseFirstReg6Block(parts, acc){ const yymm=(parts[4]||'').trim(); if(RE.yymm.test(yymm)){ acc.firstReg ||= yymm; acc._firstReg6=true; } }
function looksTypeClass6Block(parts){ return parts.length===6 && RE.typeClass9.test((parts[2]||'').trim()); }
function parseTypeClass6Block(parts, acc){ const raw=(parts[2]||'').trim(); const f=formatTypeClass9(raw); if(f){ acc.typeClass=f; acc._typeClass=true; } }
function looksKeiExtra(parts){ return false; }
function parseKeiExtra(parts, acc){}

/* ====== ZXing：getUserMedia 先行 → 同じ video を連続デコード ====== */
let vehicleType='normal';
const accInit = ()=>({ vin:'', engine:'', model:'', firstReg:'', plate:'', expiry:'', typeClass:'',
  _qr2:false, _qr3:false, _plate:false, _modelOnly:false, _expiry:false, _typeClass:false });
let acc = accInit();

let currentDeviceId = null;
let stream = null;
let codeReader = null;
let lastText = '';

async function listCameras(){
  // 権限を先に要求（iOS Safari 対策 / ラベル取得のため）
  try { await navigator.mediaDevices.getUserMedia({ video: true }); } catch(e) {}
  const devices = await ZXingBrowser.BrowserCodeReader.listVideoInputDevices();
  return devices;
}

async function openCamera(deviceId){
  const video = $('preview');
  // 既存ストリーム停止
  if (stream) {
    stream.getTracks().forEach(t => { try{t.stop();}catch(_){}}); stream=null;
  }
  try {
    stream = await navigator.mediaDevices.getUserMedia({
      video: { deviceId: deviceId ? { exact: deviceId } : undefined, width:{ideal:1280}, height:{ideal:720}, facingMode:'environment' },
      audio: false
    });
    video.srcObject = stream;
    await video.play();
    hideCamErr();
  } catch(e) {
    showCamErr('カメラ起動に失敗：' + (e?.name || e?.message || e));
  }
}

async function startDecodeLoop(){
  // 既存デコード停止
  if (codeReader && codeReader.stopAsyncDecode) { try{ await codeReader.stopAsyncDecode(); }catch(_){} }
  codeReader = new ZXingBrowser.BrowserMultiFormatReader(undefined, { delayBetweenScanAttempts: 70 });
  // Hints（QRのみ + TRY_HARDER）
  const hints = new Map();
  hints.set(ZXing.DecodeHintType.TRY_HARDER, true);
  hints.set(ZXing.DecodeHintType.POSSIBLE_FORMATS, [ZXing.BarcodeFormat.QR_CODE]);
  codeReader.reader.setHints(hints);

  const video = $('preview');
  // 同じ video から連続デコード
  await codeReader.decodeFromVideoElementContinuously(video, (result, err) => {
    if (result) {
      const text = (result.getText() || '').normalize('NFKC').replace(/[／]/g,'/').trim();
      if (!text || text === lastText) return;
      lastText = text;
      onDecodedCommon(text);
    }
    // err は連続で来るので通常は無視（必要なら種類別にログ）
  });
}

async function populateCameraSelect(){
  const sel = $('cameraSelect');
  sel.innerHTML = '';
  const devices = await listCameras();
  if (!devices.length) {
    showCamErr('カメラが見つかりません（HTTPSまたは権限をご確認ください）');
    return;
  }
  // 背面優先
  const back = devices.find(d => /back|rear|environment/i.test(d.label || ''));
  currentDeviceId = back?.deviceId || devices[0].deviceId;

  for (const d of devices) {
    const opt = document.createElement('option');
    opt.value = d.deviceId;
    opt.textContent = d.label || `Camera ${sel.length+1}`;
    if (d.deviceId === currentDeviceId) opt.selected = true;
    sel.appendChild(opt);
  }
}

async function startScanner(){
  await populateCameraSelect();
  await openCamera(currentDeviceId);
  await startDecodeLoop();
}

function stopScanner(){
  if (codeReader && codeReader.stopAsyncDecode) { try{ codeReader.stopAsyncDecode(); }catch(_){} }
  codeReader = null;
  if (stream) { stream.getTracks().forEach(t => { try{t.stop();}catch(_){}}); stream=null; }
  lastText = '';
}

/* ====== デコード成功時（共通） ====== */
function onDecodedCommon(text){
  const norm = text;
  const parts = norm.split('/');

  if (looksExpiryBlock(parts))   { parseExpiryBlock(parts, acc);    setField('expiry', acc.expiry); }
  if (looksFirstReg6Block(parts)){ parseFirstReg6Block(parts, acc); setField('firstReg', yymmToYYYYMM(acc.firstReg)); }
  if (looksTypeClass6Block(parts)){parseTypeClass6Block(parts, acc);setField('typeClass', acc.typeClass); }
  if (looksPlate(parts))         { parsePlate(parts, acc);          setField('plate', acc.plate); }
  if (!acc.model && looksModelOnly(parts)) { parseModelOnly(parts, acc); setField('model', acc.model); }

  let accepted=false;
  if (looksQR3(parts)) { parseQR3(parts, acc); accepted=true; }
  else if (looksQR2(parts)) { parseQR2(parts, acc); accepted=true; }
  if (!accepted && vehicleType==='kei' && looksKeiExtra(parts)) { parseKeiExtra(parts, acc); accepted=true; }

  setField('vin', acc.vin);
  setField('engine', acc.engine);
  setField('model', acc.model);
  setField('firstReg', yymmToYYYYMM(acc.firstReg));
  setField('plate', acc.plate);
  setField('expiry', acc.expiry);
  setField('typeClass', acc.typeClass);

  logDebug(norm, parts, `${accepted ? 'ACCEPTED' : 'IGNORED'} (${vehicleType})`);
  if (allFormInputsFilled()) { stopScanner(); }
}

/* ====== 初期化とイベント ====== */
(async ()=>{
  await startScanner();

  $('cameraSelect')?.addEventListener('change', async (e)=>{
    currentDeviceId = e.target.value;
    stopScanner();
    await openCamera(currentDeviceId);
    await startDecodeLoop();
  });
  $('reopen')?.addEventListener('click', async ()=>{
    stopScanner();
    await startScanner();
  });

  $('tab-normal')?.addEventListener('click', async ()=>{
    if (vehicleType==='normal') return;
    vehicleType='normal'; setVehTag('普通車');
    clearForm(); acc=accInit();
    $('tab-normal').className='px-3 py-2 rounded bg-blue-600 text-white';
    $('tab-kei').className='px-3 py-2 rounded bg-gray-200';
    stopScanner(); await startScanner();
  });
  $('tab-kei')?.addEventListener('click', async ()=>{
    if (vehicleType==='kei') return;
    vehicleType='kei'; setVehTag('軽自動車');
    clearForm(); acc=accInit();
    $('tab-normal').className='px-3 py-2 rounded bg-gray-200';
    $('tab-kei').className='px-3 py-2 rounded bg-blue-600 text-white';
    stopScanner(); await startScanner();
  });

  $('resumeBtn')?.addEventListener('click', async ()=>{
    stopScanner(); await startScanner();
  });

  $('sendBtn')?.addEventListener('click', async ()=>{
    const payload = {
      vin: $('vin')?.value || '',
      engine: $('engine')?.value || '',
      model: $('model')?.value || '',
      first_reg: $('firstReg')?.value || '',
      plate: $('plate')?.value || '',
      expiry: $('expiry')?.value || '',
      type_class: $('typeClass')?.value || '',
      vehicle_type: vehicleType
    };
    try{
      const res = await fetch("{{ route('tradein.store') }}", {
        method:'POST',
        headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
        body: JSON.stringify(payload)
      });
      alert(res.ok ? '保存しました' : '保存に失敗しました');
    }catch(e){
      alert('通信エラーが発生しました');
    }
  });
})();
</script>
