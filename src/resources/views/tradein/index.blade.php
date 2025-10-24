<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      車検証QR読み取り（普通車 / 軽自動車）
    </h2>
  </x-slot>

  <div class="max-w-2xl mx-auto p-4 space-y-4">
    <!-- Tabs -->
    <div class="flex gap-2">
      <button id="tab-normal" class="px-3 py-2 rounded bg-blue-600 text-white">普通車</button>
      <button id="tab-kei" class="px-3 py-2 rounded bg-gray-200">軽自動車</button>
      <span id="vehTag" class="ml-auto text-sm text-gray-600">モード: 普通車</span>
    </div>

    <!-- Reader -->
    <div id="reader" style="width: 100%; max-width: 480px;"></div>

    <!-- フォーム（普通車/軽 自体は同じUIでOK）-->
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

<!-- html5-qrcode（CDN） -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
/* =========================
   車検証QR（普通車/軽自動車）読取・統合JS（軽タブの検出強化）
   - 普通車：従来設定
   - 軽自動車：検出安定化チューニング（qrbox/fps/BarCodeDetector等）
   ========================= */

/* ===== 正規表現・共通ユーティリティ（既存のまま） ===== */
const RE = {
  yymm: /^(?:\d{4}|9999)$/,
  model: /^[A-Z0-9-]{3,20}$/,
  vin: /^[A-Z0-9-]{6,25}$/i,
  engine: /^[A-Z0-9]{2,12}$/,
  plate: /^[^\s\/]+[ \u3000]+[0-9]{2,3}[\u3041-\u3096][0-9・･\-]{1,4}$/u,
  typeClass9: /^\d{9}$/
};
function yymmToYYYYMM(yymm){ if (!yymm || yymm==='9999') return ''; const yy=+yymm.slice(0,2),mm=yymm.slice(2,4); const year=yy>=70?1900+yy:2000+yy; return `${year}-${mm}`; }
function yymmddToYYYY_MM_DD(s){ if(!/^\d{6}$/.test(s)) return ''; const yy=+s.slice(0,2),mm=s.slice(2,4),dd=s.slice(4,6); const y=yy>=70?1900+yy:2000+yy; return `${y}-${mm}-${dd}`; }
function formatTypeClass9(s){ return RE.typeClass9.test(s)?`${s.slice(0,5)}-${s.slice(5,9)}`:''; }
const $ = (id)=>document.getElementById(id);
function setField(id, v){ const el=$(id); if(el && v!=null && v!=='') el.value=v; }
function clearForm(){ ['vin','engine','model','firstReg','plate','expiry','typeClass'].forEach(id=>{ const el=$(id); if(el) el.value=''; }); }
function allFormInputsFilled(){
  const form=$('result-form'); if(!form) return false;
  const inputs=[...form.querySelectorAll('input')];
  return inputs.length>0 && inputs.every(el => (el.value||'').trim()!=='');
}
function setVehTag(txt){ const t=$('vehTag'); if(t) t.textContent='モード: '+txt; }
function logDebug(raw, parts, note=''){
  const pre=$('debug'); if(!pre) return;
  pre.textContent = `[${new Date().toLocaleTimeString()}] ${note}
RAW:
${raw}

SPLIT(${parts.length}):
${parts.map((p,i)=>`${i}: ${p}`).join('\n')}
`;
}

/* ===== Plate ===== */
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

/* ===== 普通車：QR2（VIN/ENGINE） ===== */
function pickQR2Fields(parts){
  if(parts.length===6) return { vin:(parts[3]||'').trim(), engine:(parts[4]||'').trim(), ok:true, variant:6 };
  if(parts.length===5) return { vin:(parts[2]||'').trim(), engine:(parts[3]||'').trim(), ok:true, variant:5 };
  return { vin:'', engine:'', ok:false, variant:0 };
}
function looksQR2(parts){
  const f=pickQR2Fields(parts);
  if(!f.ok) return false;
  if(parts.length===6 && !/[A-Za-z]/.test(f.vin)) return false; // 誤判定ガード
  if(!f.vin || f.vin==='-') return false;
  if(!RE.vin.test(f.vin)) return false;
  if(f.engine && f.engine!=='-' && !RE.engine.test(f.engine)) return false;
  return true;
}
function parseQR2(parts, acc){
  const f=pickQR2Fields(parts);
  if(!f.ok) return;
  if(f.vin) acc.vin ||= f.vin;
  if(f.engine && f.engine!=='-') acc.engine ||= f.engine;
  acc._qr2=true;
}

/* ===== 普通車：QR3（初度・型式） ===== */
function looksQR3(parts){
  if(parts.length<10) return false;
  const yymm=(parts[6]||'').trim(), model=(parts[7]||'').trim();
  if(!yymm || !model || yymm==='-' || model==='-') return false;
  return RE.yymm.test(yymm) && RE.model.test(model);
}
function parseQR3(parts, acc){
  acc.firstReg ||= (parts[6]||'').trim(); // YYMM or 9999
  acc.model    ||= (parts[7]||'').trim();
  acc._qr3=true;
}

/* ===== 普通車：Model-only（先頭が型式の短い配列） ===== */
function looksModelOnly(parts){
  if(parts.length<6 || parts.length>9) return false;
  const head=(parts[0]||'').trim();
  const dashCount=parts.filter(p => (p||'').trim()==='-').length;
  return RE.model.test(head) && dashCount>=2;
}
function parseModelOnly(parts, acc){
  const head=(parts[0]||'').trim();
  if(RE.model.test(head)){ acc.model ||= head; acc._modelOnly=true; }
}

/* ===== 普通車：6要素派生 ===== */
function looksExpiryBlock(parts){ return parts.length===6 && /^\d{6}$/.test((parts[3]||'').trim()); }
function parseExpiryBlock(parts, acc){ const iso=yymmddToYYYY_MM_DD((parts[3]||'').trim()); if(iso){ acc.expiry=iso; acc._expiry=true; } }
function looksFirstReg6Block(parts){ return parts.length===6 && /^\d{4}$/.test((parts[4]||'').trim()); }
function parseFirstReg6Block(parts, acc){ const yymm=(parts[4]||'').trim(); if(RE.yymm.test(yymm)){ acc.firstReg ||= yymm; acc._firstReg6=true; } }
function looksTypeClass6Block(parts){ return parts.length===6 && RE.typeClass9.test((parts[2]||'').trim()); }
function parseTypeClass6Block(parts, acc){ const raw=(parts[2]||'').trim(); const formatted=formatTypeClass9(raw); if(formatted){ acc.typeClass=formatted; acc._typeClass=true; } }

/* ===== 軽自動車：専用フック（まずは空。RAW/SPLITを見て育てる） ===== */
function looksKeiExtra(parts){ return false; }
function parseKeiExtra(parts, acc){}

/* ===== スキャナ制御 ===== */
let vehicleType = 'normal'; // 'normal' | 'kei'
const accInit = () => ({
  vin:'', engine:'', model:'', firstReg:'', plate:'', expiry:'', typeClass:'',
  _qr2:false, _qr3:false, _plate:false, _modelOnly:false, _expiry:false, _firstReg6:false, _typeClass:false
});
let acc = accInit();

let lastText = '';
let html5QrCode = null;
let currentCamId = null;

async function startCamera(){
  if(!html5QrCode) html5QrCode = new Html5Qrcode('reader', { verbose: false });

  const cams = await Html5Qrcode.getCameras();
  if(!cams?.length){ console.error('カメラが見つかりません'); return; }

  let camId = currentCamId || cams.find(c => /back|rear|environment/i.test(c.label || ''))?.id || cams[0].id;
  currentCamId = camId;

  // ★ 車種別の推奨設定
  const commonConfig = {
    fps: 8,
    rememberLastUsedCamera: true,
    aspectRatio: 1.777,                 // 16:9（AFが安定しやすい端末が多い）
    formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ],
    experimentalFeatures: { useBarCodeDetectorIfSupported: true },
    // iOS Safari の左右反転検出のため false のほうが安定する場合あり
    // disableFlip: true,
  };

  const normalCfg = { ...commonConfig, qrbox: { width: 280, height: 280 } };
  const keiCfg    = { ...commonConfig, fps: 6, qrbox: { width: 220, height: 220 } };

  // start（タブで設定を切り替え）
  await html5QrCode.start(
    camId,
    (vehicleType === 'kei' ? keiCfg : normalCfg),
    onScanSuccess,
    onScanFailure
  );

  // ズーム/トーチ UI（端末対応時のみ有効化）
  setupZoomTorchControls();
}

async function stopCamera(){
  if(html5QrCode && html5QrCode.isScanning()){ try{ await html5QrCode.stop(); }catch(e){} }
}

function onScanFailure(/* err */){
  // 失敗は数十ms単位で来るので何もしない（必要ならデバッグ）
}

function onScanSuccess(text){
  const norm=(text||'').normalize('NFKC').replace(/[／]/g,'/').trim();
  if(!norm || norm===lastText) return;
  lastText=norm;

  const parts=norm.split('/');

  // 共通：派生（満了/初度/型式類別/plate）
  if(looksExpiryBlock(parts)){ parseExpiryBlock(parts, acc); setField('expiry', acc.expiry); }
  if(looksFirstReg6Block(parts)){ parseFirstReg6Block(parts, acc); setField('firstReg', yymmToYYYYMM(acc.firstReg)); }
  if(looksTypeClass6Block(parts)){ parseTypeClass6Block(parts, acc); setField('typeClass', acc.typeClass); }
  if(looksPlate(parts)){ parsePlate(parts, acc); setField('plate', acc.plate); }

  // 型式（単独ブロック）
  if(!acc.model && looksModelOnly(parts)){ parseModelOnly(parts, acc); setField('model', acc.model); }

  // メイン（車種別）
  let accepted=false;
  if(vehicleType==='normal'){
    if(looksQR3(parts)){ parseQR3(parts, acc); accepted=true; }
    else if(looksQR2(parts)){ parseQR2(parts, acc); accepted=true; }
  }else{ // kei
    if(looksQR3(parts)){ parseQR3(parts, acc); accepted=true; }
    else if(looksQR2(parts)){ parseQR2(parts, acc); accepted=true; }
    if(!accepted && looksKeiExtra(parts)){ parseKeiExtra(parts, acc); accepted=true; }
  }

  // 画面反映（共通）
  setField('vin', acc.vin);
  setField('engine', acc.engine);
  setField('model', acc.model);
  setField('firstReg', yymmToYYYYMM(acc.firstReg));
  setField('plate', acc.plate);
  setField('expiry', acc.expiry);
  setField('typeClass', acc.typeClass);

  logDebug(norm, parts, `${accepted ? 'ACCEPTED' : 'IGNORED'} (${vehicleType})`);

  // 停止条件：フォームの全 input が非空
  if(allFormInputsFilled()){ stopCamera(); }
}

/* ===== ズーム & トーチ（対応端末のみ） ===== */
function setupZoomTorchControls(){
  const zoom = $('zoomRange');
  const torch = $('torchBtn');
  const api = html5QrCode;

  // applyVideoConstraints は端末によっては未サポート
  if(zoom){
    zoom.oninput = async (e)=>{
      const v = Number(e.target.value || 1);
      try{
        await api.applyVideoConstraints({ advanced: [{ zoom: v }] });
      }catch(_){}
    };
  }
  if(torch){
    let on=false;
    torch.onclick = async ()=>{
      on = !on;
      try{
        await api.applyVideoConstraints({ advanced: [{ torch: on }] });
        torch.textContent = on ? 'ライトOFF' : 'ライトON';
      }catch(_){
        // 非対応端末はボタン無効化
        torch.disabled = true;
      }
    };
  }
}

/* ===== 初期化＆タブ切替 ===== */
(async ()=>{
  await startCamera();

  $('tab-normal')?.addEventListener('click', async ()=>{
    if(vehicleType==='normal') return;
    vehicleType='normal'; setVehTag('普通車');
    clearForm(); acc=accInit(); lastText='';
    $('tab-normal').className='px-3 py-2 rounded bg-blue-600 text-white';
    $('tab-kei').className='px-3 py-2 rounded bg-gray-200';
    await stopCamera(); await startCamera();
  });

  $('tab-kei')?.addEventListener('click', async ()=>{
    if(vehicleType==='kei') return;
    vehicleType='kei'; setVehTag('軽自動車');
    clearForm(); acc=accInit(); lastText='';
    $('tab-normal').className='px-3 py-2 rounded bg-gray-200';
    $('tab-kei').className='px-3 py-2 rounded bg-blue-600 text-white';
    await stopCamera(); await startCamera();
  });

  // 再スキャン
  $('resumeBtn')?.addEventListener('click', async ()=>{
    lastText=''; await stopCamera(); await startCamera();
  });

  // 保存（Laravel: tradein.store 想定）
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
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body: JSON.stringify(payload)
      });
      alert(res.ok ? '保存しました' : '保存に失敗しました');
    }catch(e){
      alert('通信エラーが発生しました');
    }
  });
})();
</script>
