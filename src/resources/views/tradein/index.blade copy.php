<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            買取車両情報QR読み取り
        </h2>
    </x-slot>



    <div class="max-w-xl mx-auto p-4 space-y-4">
        <h1 class="text-xl font-bold">車検証QR読み取り</h1>

        <div id="reader" style="width: 100%; max-width: 420px;"></div>

        <div class="flex items-center gap-2 my-2">
            <span id="stQR2" class="px-2 py-1 rounded bg-gray-100 text-gray-600 text-xs">QR2 取得</span>
            <span id="stQR3" class="px-2 py-1 rounded bg-gray-100 text-gray-600 text-xs">QR3 取得</span>
        </div>

        <div class="flex items-center gap-2 my-3">
            <button type="button" id="btnAuto" class="px-2 py-1 rounded border" onclick="__setMode('auto')">AUTO</button>
            <button type="button" id="btnQR2" class="px-2 py-1 rounded border" onclick="__setMode('qr2')">QR2のみ</button>
            <button type="button" id="btnQR3" class="px-2 py-1 rounded border" onclick="__setMode('qr3')">QR3のみ</button>
        </div>

        <pre id="debug" class="text-xs bg-gray-50 p-2 rounded border max-h-56 overflow-auto"></pre>


        <form id="result-form" class="space-y-2">
            <div><label class="block text-sm">車台番号（VIN）</label>
                <input id="vin" name="vin" class="border p-2 w-full" readonly>
            </div>
            <div><label class="block text-sm">ナンバー</label>
                <input id="plate" name="plate" class="border p-2 w-full" readonly>
            </div>
            <div><label class="block text-sm">原動機の型式</label>
                <input id="engine" name="engine" class="border p-2 w-full" readonly>
            </div>
            <div><label class="block text-sm">型式</label>
                <input id="model" name="model" class="border p-2 w-full" readonly>
            </div>
            <div><label class="block text-sm">初度登録年月</label>
                <input id="firstReg" name="firstReg" class="border p-2 w-full" readonly>
            </div>
            <div>
                <label class="block text-sm">車検満了日</label>
                <input id="expiry" name="expiry" class="border p-2 w-full" readonly>
            </div>

            <div><label class="block text-sm">型式類別</label>
                <input id="typeClass" name="typeClass" class="border p-2 w-full" readonly>
            </div>


            <!-- 送信用（お好みで） -->
            <button type="button" id="sendBtn" class="bg-blue-600 text-white px-4 py-2 rounded">保存</button>
        </form>
    </div>

</x-app-layout>


<!-- html5-qrcode（CDN） -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    /* =========================
   車検証QR（普通車）読取 完全JS（全フォーム埋まるまで継続）
   - 取得：VIN（QR2 5/6要素型）、原動機型式（QR2 5/6要素型）
           型式（QR3 or Model-only）、初度登録(YYMM ＋ 6要素[4])
           ナンバー（Plate, ゆるめ抽出）、車検満了日(YYMMDD 6要素[3])
           型式類別（9桁→5桁-4桁）
   - 停止条件：#result-form 内の input が全て埋まったら停止
   - 必須ID: #reader / #result-form / #vin / #engine / #model / #firstReg / #plate / #expiry / #sendBtn
   - 任意ID: #typeClass, #debug, #btnAuto #btnQR2 #btnQR3, #st*
   ========================= */

    /* ===== 正規表現・ユーティリティ ===== */
    const RE = {
        yymm: /^(?:\d{4}|9999)$/,
        model: /^[A-Z0-9-]{3,20}$/,
        vin: /^[A-Z0-9-]{6,25}$/i,
        engine: /^[A-Z0-9]{2,12}$/,
        plate: /^[^\s\/]+[ \u3000]+[0-9]{2,3}[\u3041-\u3096][0-9・･\-]{1,4}$/u,
        typeClass9: /^\d{9}$/
    };

    function yymmToYYYYMM(yymm) {
        if (!yymm || yymm === '9999') return '';
        const yy = +yymm.slice(0, 2),
            mm = yymm.slice(2, 4);
        const year = yy >= 70 ? 1900 + yy : 2000 + yy;
        return `${year}-${mm}`;
    }

    function yymmddToYYYY_MM_DD(yymmdd) {
        if (!/^\d{6}$/.test(yymmdd)) return '';
        const yy = +yymmdd.slice(0, 2),
            mm = yymmdd.slice(2, 4),
            dd = yymmdd.slice(4, 6);
        const year = yy >= 70 ? 1900 + yy : 2000 + yy;
        return `${year}-${mm}-${dd}`;
    }

    function formatTypeClass9(s) {
        return RE.typeClass9.test(s) ? `${s.slice(0,5)}-${s.slice(5,9)}` : '';
    }

    function $(id) {
        return document.getElementById(id);
    }

    function setField(id, v) {
        const el = $(id);
        if (el && v != null && v !== '') el.value = v;
    }

    function setStatus(id, ok) {
        const el = $(id);
        if (!el) return;
        el.classList.toggle('bg-green-100', !!ok);
        el.classList.toggle('text-green-700', !!ok);
        el.classList.toggle('bg-gray-100', !ok);
        el.classList.toggle('text-gray-600', !ok);
    }

    function logDebug(raw, parts, note = '') {
        const pre = $('debug');
        if (!pre) return;
        pre.textContent =
            `[${new Date().toLocaleTimeString()}] ${note}
RAW:
${raw}

SPLIT(${parts.length}):
${parts.map((p,i)=>`${i}: ${p}`).join('\n')}
`;
    }

    /* ===== 「全フォーム埋まった？」判定 ===== */
    function allFormInputsFilled() {
        const form = document.getElementById('result-form'); // ← フォームID
        if (!form) return false;
        const inputs = Array.from(form.querySelectorAll('input'));
        // input が1つも無ければ false。全ての value が非空なら true
        return inputs.length > 0 && inputs.every(el => (el.value || '').trim() !== '');
    }

    /* ===== Plate（ナンバー） ===== */
    function tryExtractPlate(str) {
        if (!str) return '';
        const s = str.normalize('NFKC').trim();
        const m = s.match(/[^\s\/]+[ \u3000]+[0-9]{2,3}[\u3041-\u3096][0-9・･\-]{1,4}/u);
        return m ? m[0] : '';
    }

    function looksPlate(parts) {
        if (parts.length === 2) {
            const body = (parts[1] || '').trim();
            if (RE.plate.test(body) || tryExtractPlate(body)) return true;
        }
        if (parts.length === 1) {
            const body = (parts[0] || '').trim();
            if (RE.plate.test(body) || tryExtractPlate(body)) return true;
        }
        if (parts.length === 2) {
            const body = (parts[1] || '').trim();
            if (tryExtractPlate(body)) return true;
        }
        return false;
    }

    function parsePlate(parts, acc) {
        let cand = parts.length === 2 ? (parts[1] || '').trim() : (parts[0] || '').trim();
        let p = RE.plate.test(cand) ? cand : tryExtractPlate(cand);
        if (p) p = p.replace(/^[\s・･-]+|[\s・･-]+$/g, '');
        if (p) {
            acc.plate ||= p;
            acc._plate = true;
        }
    }

    /* ===== QR2（VIN/ENGINE・5/6要素型対応） ===== */
    function pickQR2Fields(parts) {
        // 6要素型: [3]=VIN, [4]=ENGINE
        if (parts.length === 6) {
            return {
                vin: (parts[3] || '').trim(),
                engine: (parts[4] || '').trim(),
                ok: true,
                variant: 6
            };
        }
        // 5要素型: [2]=VIN, [3]=ENGINE（例: 5/1/YH2-1001905/K24A/1）
        if (parts.length === 5) {
            return {
                vin: (parts[2] || '').trim(),
                engine: (parts[3] || '').trim(),
                ok: true,
                variant: 5
            };
        }
        return {
            vin: '',
            engine: '',
            ok: false,
            variant: 0
        };
    }

    function looksQR2(parts) {
        const f = pickQR2Fields(parts);
        if (!f.ok) return false;

        // ★誤判定ガード：6要素型QR2として採用する場合、VINに英字を含む
        if (parts.length === 6 && !/[A-Za-z]/.test(f.vin)) return false;

        if (!f.vin || f.vin === '-') return false;
        if (!RE.vin.test(f.vin)) return false;
        if (f.engine && f.engine !== '-' && !RE.engine.test(f.engine)) return false;
        return true;
    }

    function parseQR2(parts, acc) {
        const f = pickQR2Fields(parts);
        if (!f.ok) return;
        if (f.vin) acc.vin ||= f.vin;
        if (f.engine && f.engine !== '-') acc.engine ||= f.engine;
        acc._qr2 = true;
    }

    /* ===== QR3（初度・型式） ===== */
    function looksQR3(parts) {
        if (parts.length < 10) return false;
        const yymm = (parts[6] || '').trim();
        const model = (parts[7] || '').trim();
        if (!yymm || !model || yymm === '-' || model === '-') return false;
        return RE.yymm.test(yymm) && RE.model.test(model);
    }

    function parseQR3(parts, acc) {
        acc.firstReg ||= (parts[6] || '').trim(); // YYMM or 9999
        acc.model ||= (parts[7] || '').trim();
        acc._qr3 = true;
    }

    /* ===== Model-only（先頭が型式の短い配列） ===== */
    function looksModelOnly(parts) {
        if (parts.length < 6 || parts.length > 9) return false;
        const head = (parts[0] || '').trim();
        const dashCount = parts.filter(p => (p || '').trim() === '-').length;
        return RE.model.test(head) && dashCount >= 2;
    }

    function parseModelOnly(parts, acc) {
        const head = (parts[0] || '').trim();
        if (RE.model.test(head)) {
            acc.model ||= head;
            acc._modelOnly = true;
        }
    }

    /* ===== 満了日 6要素ブロック（[3]=YYMMDD） ===== */
    function looksExpiryBlock(parts) {
        if (parts.length !== 6) return false;
        const cand = (parts[3] || '').trim();
        return /^\d{6}$/.test(cand);
    }

    function parseExpiryBlock(parts, acc) {
        const iso = yymmddToYYYY_MM_DD((parts[3] || '').trim());
        if (iso) {
            acc.expiry = iso;
            acc._expiry = true;
        }
    }

    /* ===== 初度登録 6要素ブロック（[4]=YYMM） ===== */
    function looksFirstReg6Block(parts) {
        if (parts.length !== 6) return false;
        const cand = (parts[4] || '').trim();
        return /^\d{4}$/.test(cand);
    }

    function parseFirstReg6Block(parts, acc) {
        const yymm = (parts[4] || '').trim();
        if (RE.yymm.test(yymm)) {
            acc.firstReg ||= yymm;
            acc._firstReg6 = true;
        }
    }

    /* ===== 型式類別 6要素ブロック（[2]=9桁→5桁-4桁） ===== */
    function looksTypeClass6Block(parts) {
        if (parts.length !== 6) return false;
        const cand = (parts[2] || '').trim();
        return RE.typeClass9.test(cand);
    }

    function parseTypeClass6Block(parts, acc) {
        const raw = (parts[2] || '').trim();
        const formatted = formatTypeClass9(raw);
        if (formatted) {
            acc.typeClass = formatted;
            acc._typeClass = true;
        }
    }

    /* ===== メイン ===== */
    (async () => {
        const acc = {
            vin: '',
            engine: '',
            model: '',
            firstReg: '',
            plate: '',
            expiry: '',
            typeClass: '',
            _qr2: false,
            _qr3: false,
            _plate: false,
            _modelOnly: false,
            _expiry: false,
            _firstReg6: false,
            _typeClass: false
        };
        let mode = 'auto'; // 'auto' | 'qr2' | 'qr3'
        let lastText = '';

        function applyModeUI() {
            const map = {
                auto: 'btnAuto',
                qr2: 'btnQR2',
                qr3: 'btnQR3'
            };
            ['btnAuto', 'btnQR2', 'btnQR3'].forEach(id => {
                const el = $(id);
                if (!el) return;
                const active = map[mode] === id;
                el.classList.toggle('ring-2', active);
                el.classList.toggle('ring-blue-500', active);
            });
        }
        window.__setMode = (m) => {
            mode = m;
            applyModeUI();
        };

        const html5QrCode = new Html5Qrcode('reader');
        const cams = await Html5Qrcode.getCameras();
        if (!cams?.length) {
            console.error('カメラが見つかりません');
            return;
        }
        let camId = cams[0].id;
        const back = cams.find(c => /back|rear|environment/i.test(c.label || ''));
        if (back) camId = back.id;

        await html5QrCode.start(
            camId, {
                fps: 8,
                qrbox: {
                    width: 260,
                    height: 260
                }
            },
            (text) => {
                const norm = (text || '').normalize('NFKC').replace(/[／]/g, '/').trim();
                if (!norm || norm === lastText) return;
                lastText = norm;

                const parts = norm.split('/');

                // 1) 満了日（YYMMDD on [3]）
                if (looksExpiryBlock(parts)) {
                    parseExpiryBlock(parts, acc);
                    setField('expiry', acc.expiry);
                    setStatus('stExpiry', acc._expiry);
                    logDebug(norm, parts, 'ACCEPTED (expiry)');
                }

                // 2) 初度（YYMM on [4]）
                if (looksFirstReg6Block(parts)) {
                    parseFirstReg6Block(parts, acc);
                    setField('firstReg', yymmToYYYYMM(acc.firstReg));
                    logDebug(norm, parts, 'ACCEPTED (firstReg-6block)');
                }

                // 3) 型式類別（9桁 on [2] → 5桁-4桁）
                if (looksTypeClass6Block(parts)) {
                    parseTypeClass6Block(parts, acc);
                    setField('typeClass', acc.typeClass);
                    setStatus('stTypeClass', acc._typeClass);
                    logDebug(norm, parts, 'ACCEPTED (typeClass-6block)');
                }

                // 4) Plate（任意）
                if (looksPlate(parts)) {
                    parsePlate(parts, acc);
                    setField('plate', acc.plate);
                    setStatus('stPlate', acc._plate);
                    logDebug(norm, parts, 'ACCEPTED (plate)');
                }

                // 5) 先頭型式の短い配列（Model-only）
                if (!acc.model && looksModelOnly(parts)) {
                    parseModelOnly(parts, acc);
                    setField('model', acc.model);
                    logDebug(norm, parts, 'ACCEPTED (model-only)');
                }

                // 6) モードに従って QR3 / QR2
                let accepted = false;
                if (mode === 'qr2') {
                    if (looksQR2(parts)) {
                        parseQR2(parts, acc);
                        accepted = true;
                    } else {
                        logDebug(norm, parts, 'IGNORED (mode=QR2)'); /* returnしない：他の型も試す */
                    }
                } else if (mode === 'qr3') {
                    if (looksQR3(parts)) {
                        parseQR3(parts, acc);
                        accepted = true;
                    } else {
                        logDebug(norm, parts, 'IGNORED (mode=QR3)'); /* returnしない */
                    }
                } else { // auto
                    if (looksQR3(parts)) {
                        parseQR3(parts, acc);
                        accepted = true;
                    } else if (looksQR2(parts)) {
                        parseQR2(parts, acc);
                        accepted = true;
                    } else {
                        logDebug(norm, parts, 'IGNORED (auto)');
                    }
                }

                // 7) 画面反映（毎回）
                setField('plate', acc.plate);
                setField('expiry', acc.expiry);
                setField('typeClass', acc.typeClass);
                setField('vin', acc.vin);
                setField('engine', acc.engine);
                setField('model', acc.model);
                setField('firstReg', yymmToYYYYMM(acc.firstReg));
                setStatus('stQR2', acc._qr2);
                setStatus('stQR3', acc._qr3);
                logDebug(norm, parts, accepted ? 'ACCEPTED' : 'IGNORED');

                // 8) ★停止条件：#result-form の全 input が埋まったら停止
                if (allFormInputsFilled()) {
                    html5QrCode.stop().catch(() => {});
                }
            },
            () => {}
        );

        // 保存（Laravel: tradein.store 想定）
        const sendBtn = $('sendBtn');
        if (sendBtn) {
            sendBtn.addEventListener('click', async () => {
                const payload = {
                    vin: $('vin')?.value || '',
                    engine: $('engine')?.value || '',
                    model: $('model')?.value || '',
                    first_reg: $('firstReg')?.value || '',
                    plate: $('plate')?.value || '',
                    expiry: $('expiry')?.value || '',
                    type_class: $('typeClass')?.value || ''
                };
                try {
                    const res = await fetch("{{ route('tradein.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    });
                    alert(res.ok ? '保存しました' : '保存に失敗しました');
                } catch (e) {
                    alert('通信エラーが発生しました');
                }
            });
        }

        applyModeUI();
    })();
</script>