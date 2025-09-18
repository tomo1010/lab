<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            クイック見積もり作成
        </h2>
    </x-slot>


    <div class="text-xs text-gray-500">
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- 成功・エラーメッセージ -->
                @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
                @endif

                <!-- 投稿フォーム -->
                <form id="quoteForm" action="{{ route('quote.store') }}" method="POST" class="mb-6">
                    @csrf

                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">車両情報</h3>

                    <!-- 購入車種 -->
                    <div class="mb-4 bg-blue-100 p-6 rounded-lg">
                        <div class="mb-4">
                            <label for="car" class="block text-gray-700 font-semibold mb-1">車名</label>
                            <input type="text" name="car" id="car" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="grade" class="block text-gray-700 font-semibold mb-1">グレード</label>
                            <input type="text" name="grade" id="grade" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="color" class="block text-gray-700 font-semibold mb-1">色</label>
                            <input type="text" name="color" id="color" class="w-full px-4 py-2 border rounded-lg">
                        </div>

                        <div class="mb-4 flex space-x-8">
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-semibold mb-1">ミッション</label>
                                <div class="flex items-center">
                                    <input type="radio" name="transmission" id="transmission_at" value="AT" class="mr-2">
                                    <label for="transmission_at" class="mr-4">AT</label>
                                    <input type="radio" name="transmission" id="transmission_mt" value="MT" class="mr-2">
                                    <label for="transmission_mt">MT</label>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-semibold mb-1">駆動</label>
                                <div class="flex items-center">
                                    <input type="radio" name="drive" id="drive_2wd" value="2WD" class="mr-2">
                                    <label for="drive_2wd" class="mr-4">2WD</label>
                                    <input type="radio" name="drive" id="drive_4wd" value="4WD" class="mr-2">
                                    <label for="drive_4wd">4WD</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="year" class="block text-gray-700 font-semibold mb-1">年式</label>
                            <select name="year" id="year" class="w-full px-4 py-2 border rounded-lg">
                                @php
                                $currentYear = now()->year;
                                $endYear = 1989;
                                $eraNames = [2019 => '令和', 1989 => '平成'];
                                @endphp
                                <option value="" selected></option>
                                @for ($year = $currentYear; $year >= $endYear; $year--)
                                @php
                                $era = '昭和';
                                $eraYear = $year;
                                foreach ($eraNames as $eraStart => $eraName) {
                                if ($year >= $eraStart) {
                                $era = $eraName;
                                $eraYear = $year - $eraStart + 1;
                                break;
                                }
                                }
                                @endphp
                                <option value="{{ $year }}">{{ $year }}（{{ $era }}{{ $eraYear }}年）</option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="mileage" class="block text-gray-700 font-semibold mb-1">走行距離</label>
                            <input type="text" name="mileage" id="mileage"
                                class="w-full px-4 py-2 border rounded-lg"
                                inputmode="numeric" pattern="\d*">
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center justify-between">
                                <label class="text-gray-700 font-semibold mb-1">車検日</label>
                                <span id="inspection_result" class="text-gray-700 font-medium text-sm mb-1"></span>
                            </div>

                            <div class="flex space-x-2 items-center">
                                <select name="inspection_year" id="inspection_year" class="w-1/2 px-4 py-2 border rounded-lg">
                                    @php
                                    $currentYear = now()->year;
                                    $reiwaStart = 2019;
                                    $startYear = $currentYear;
                                    $endYear = $currentYear + 3;
                                    @endphp
                                    <option value="" selected></option>
                                    <option value="2年付">2年付</option>
                                    <option value="3年付">3年付</option>
                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        @php $reiwa=$year - $reiwaStart + 1; @endphp
                                        <option value="{{ $year }}">{{ $year }}（令和{{ $reiwa }}年）</option>
                                        @endfor
                                </select>

                                <select name="inspection_month" id="inspection_month" class="w-1/2 px-4 py-2 border rounded-lg">
                                    <option value="" selected></option>
                                    @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}">{{ $month }}月</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">車両価格</h3>

                    <div class="mb-4 bg-yellow-100 p-6 rounded-lg">
                        <div class="mb-4">
                            <div class="flex items-center justify-between">
                                <label for="price" class="text-gray-700 font-semibold mb-1">価格</label>
                                <span id="price_converted" class="text-gray-700 font-medium text-sm mb-1"></span>
                            </div>
                            <div class="flex items-center">
                                <input
                                    type="number"
                                    name="price"
                                    id="price"
                                    class="w-full px-4 py-2 border rounded-lg"
                                    inputmode="numeric" pattern="\d*"
                                    oninput="updatePriceDisplay(); recalcAll();">
                            </div>
                        </div>
                    </div>


                    @include('quote.popup.tax_1')
                    @include('quote.popup.tax_2')
                    @include('quote.popup.tax_3')


                    {{-- ▼▼▼ ここから諸費用（quote_charges対応 / プリセット無し） ▼▼▼ --}}
                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">
                        諸費用（税金・保険料 / 販売諸費用）
                    </h3>

                    {{-- 税金・保険料 --}}
                    <div class="mb-4 bg-purple-100 p-6 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-lg font-semibold text-gray-800">税金・保険料など</div>
                        </div>

                        <div id="charges-tax-rows"></div>
                        <button type="button"
                            class="text-blue-600 hover:underline underline-offset-2 hover:text-blue-700"
                            onclick="addChargeRow('tax')">
                            ＋ 行を追加
                        </button>

                        <div class="mt-4 text-right">
                            <span class="text-gray-700 font-semibold">
                                小計：
                                <span id="charges_tax_total_display" class="text-gray-800 font-bold">0円</span>
                            </span>
                            <input type="hidden" id="charges_tax_total" name="charges_tax_total" value="0">
                        </div>


                    </div>

                    {{-- 販売諸費用 --}}
                    <div class="mb-4 bg-purple-100 p-6 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-lg font-semibold text-gray-800">販売諸費用</div>
                        </div>

                        <div id="charges-fee-rows"></div>
                        <button type="button"
                            class="text-blue-600 hover:underline underline-offset-2 hover:text-blue-700"
                            onclick="addChargeRow('fee')">
                            ＋ 行を追加
                        </button>

                        <div class="mt-4 text-right">
                            <span class="text-gray-700 font-semibold">
                                小計：
                                <span id="charges_fee_total_display" class="text-gray-800 font-bold">0円</span>
                            </span>
                            <input type="hidden" id="charges_fee_total" name="charges_fee_total" value="0">
                        </div>

                    </div>

                    {{-- 諸費用 合計（税金・保険料 + 販売諸費用） --}}
                    <div class="mb-4 bg-purple-100 p-6 rounded-lg text-right">
                        <label class="text-gray-700 font-semibold">
                            諸費用 合計：
                            <span id="charges_total_display" class="text-gray-800 font-bold">0円</span>
                        </label>
                        <input type="hidden" id="charges_total" name="charges_total" value="0">
                    </div>


                    {{-- ▲▲▲ 諸費用ここまで ▲▲▲ --}}





                    {{-- ▼▼▼ ここからオプション（行の増減つき / 種別フォームなし） ▼▼▼ --}}
                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">オプション</h3>

                    <div class="mb-4 bg-blue-200 p-6 rounded-lg">
                        <div id="options-rows"></div>

                        <div class="mt-3">
                            <button type="button"
                                class="text-blue-600 hover:underline underline-offset-2 hover:text-blue-700"
                                onclick="addOptionRow()">
                                ＋ 行を追加
                            </button>
                        </div>

                        <div class="mt-6 text-right">
                            <span class="text-gray-700 font-semibold">
                                オプション 小計：
                                <span id="option_total_display" class="text-gray-800 font-bold">0円</span>
                            </span>
                            <input type="hidden" id="option_total" name="option_total" value="0">
                        </div>

                    </div>
                    {{-- ▲▲▲ オプション終わり ▲▲▲ --}}

                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">お支払い</h3>
                    <!-- 車両コミコミ合計（= 本体価格 + オプション小計） -->
                    <div class="mb-4">
                        <label for="total" class="block text-gray-700 font-semibold mb-1">合計（税込）</label>
                        <input type="number" name="total" id="total" class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-right" readonly>
                    </div>

                    <!-- 下取り -->
                    <div class="mb-4">
                        <label for="trade_price" class="block text-gray-700 font-semibold mb-1">下取り価格</label>
                        <input type="number" name="trade_price" id="trade_price" inputmode="numeric" pattern="\d*"
                            class="w-full px-4 py-2 border rounded-lg"
                            oninput="recalcPayment()">
                    </div>

                    <!-- 値引き -->
                    <div class="mb-4">
                        <label for="discount" class="block text-gray-700 font-semibold mb-1">値引き</label>
                        <input type="number" name="discount" id="discount" inputmode="numeric" pattern="\d*"
                            class="w-full px-4 py-2 border rounded-lg"
                            oninput="recalcPayment()">
                    </div>

                    <!-- お支払い総額 -->
                    <div class="mb-4">
                        <label for="payment" class="block text-gray-700 font-semibold mb-1">お支払い総額</label>
                        <input type="number" name="payment" id="payment"
                            class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-right" readonly>
                    </div>

                    <!--メモ -->
                    <div class="mb-4">
                        <label for="memo" class="block text-gray-700 font-semibold mb-1">メモ</label>
                        <input type="text" name="memo" id="memo" class="w-full px-4 py-2 border rounded-lg">
                    </div>

                    <!-- ログインユーザの制限処理 -->
                    @auth
                    @php
                    $limit = auth()->user()->limit();
                    $quoteCount = auth()->user()->quotes()->count();
                    $isOverLimit = $quoteCount >= $limit;
                    @endphp

                    <div class="flex space-x-2">
                        <x-save-limit-modal :is-over-limit="$isOverLimit" />
                        @endauth

                        <!-- PDFボタン -->
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600"
                            onclick="document.getElementById('quoteForm').action='{{ route('quote.createPdf') }}';">
                            PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- データ保存一覧 -->
        @auth
        <x-save-list :items="$quotes" itemName="quote" :is-over-limit="$isOverLimit" routePrefix="quote" />
        @endauth
    </div>



    <script>
        // ------- 金額を万円表示（本体） -------
        function updatePriceDisplay() {
            const priceInput = document.getElementById('price');
            const convertedDisplay = document.getElementById('price_converted');
            const value = parseFloat(priceInput.value);
            convertedDisplay.textContent = !isNaN(value) ?
                `${(value / 10000).toFixed(1).replace(/\.0$/, '')}万円` :
                '';
        }

        // ------- 諸費用行テンプレ -------
        // 税金・保険料アイコン用の固定リスト
        const taxIcons = [{
                id: 'tax_1',
                label: '自動車税'
            },
            {
                id: 'tax_2',
                label: '重量税'
            },
            {
                id: 'tax_3',
                label: '自賠責保険'
            },
            {
                id: 'tax_4',
                label: '環境性能割'
            },
            {
                id: 'tax_5',
                label: 'リサイクル費用'
            },
        ];

        // 行テンプレート生成
        function chargeRowTemplate(kind, index, nameValue = '', amountValue = '') {
            const hasTaxIcon = (kind === 'tax' && index < taxIcons.length);
            const taxMeta = hasTaxIcon ? taxIcons[index] : null;

            const iconHtml = hasTaxIcon ? `
    <button type="button"
            onclick="openTaxPopup('${taxMeta.id}')"
            class="ml-2 text-gray-500 hover:text-gray-700"
            title="${taxMeta.label}">
      <i class="fas fa-info-circle"></i>
    </button>
  ` : '';

            const amountIdAttr = hasTaxIcon ? `id="${taxMeta.id}"` : '';

            return `
    <div class="grid grid-cols-12 gap-2 items-center mb-2 charge-row"
         data-kind="${kind}" data-index="${index}">
      <div class="col-span-9 flex items-center gap-2">
        <input type="text"
               name="charges[${kind}][${index}][name]"
               class="w-full px-3 py-2 border rounded"
               placeholder="例）自賠責保険 / 登録費用 など"
               value="${nameValue ?? ''}">
        <input type="hidden" name="charges[${kind}][${index}][kind]" value="${kind}">
        <input type="hidden" name="charges[${kind}][${index}][tax_treatment]" value="taxable">
        ${iconHtml}
      </div>
      <div class="col-span-3 flex items-center gap-2">
        <input type="number"
               ${amountIdAttr}
               name="charges[${kind}][${index}][amount]"
               class="charge-amount w-full px-3 py-2 border rounded text-right"
               inputmode="numeric" pattern="\\d*"
               placeholder="0"
               value="${amountValue ?? ''}">
        <button type="button"
                class="shrink-0 px-2 py-2 bg-gray-200 rounded hover:bg-gray-300"
                title="行を削除"
                onclick="removeChargeRow(this)">−</button>
      </div>
    </div>`;
        }


        function addChargeRow(kind, nameValue = '', amountValue = '') {
            const container = document.getElementById(kind === 'tax' ? 'charges-tax-rows' : 'charges-fee-rows');
            const nextIndex = container.querySelectorAll('.charge-row').length;
            container.insertAdjacentHTML('beforeend', chargeRowTemplate(kind, nextIndex, nameValue, amountValue));
            recalcAll();
        }

        function removeChargeRow(btn) {
            const row = btn.closest('.charge-row');
            if (!row) return;
            const kind = row.dataset.kind;
            row.remove();
            reindexChargeRows(kind);
            recalcAll();
        }

        function reindexChargeRows(kind) {
            const container = document.getElementById(kind === 'tax' ? 'charges-tax-rows' : 'charges-fee-rows');
            container.querySelectorAll('.charge-row').forEach((row, idx) => {
                row.dataset.index = idx;
                row.querySelectorAll('input[name]').forEach(input => {
                    input.name = input.name.replace(new RegExp(`charges\\[${kind}\\]\\[\\d+\\]`), `charges[${kind}][${idx}]`);
                });
            });
        }

        function calcChargesTotal() {
            let taxSum = 0,
                feeSum = 0;

            // === 税金・保険料 小計 ===
            document.querySelectorAll('#charges-tax-rows .charge-amount').forEach(el => {
                const v = parseFloat(el.value);
                if (!isNaN(v)) taxSum += v;
            });

            // hidden に保存
            const taxHidden = document.querySelector('#charges_tax_total');
            if (taxHidden) taxHidden.value = taxSum || 0;

            // 表示テキスト更新
            const taxDisplay = document.querySelector('#charges_tax_total_display');
            if (taxDisplay) {
                taxDisplay.textContent = (taxSum || 0).toLocaleString() + '円';
            }

            // === 販売諸費用 小計 ===
            document.querySelectorAll('#charges-fee-rows .charge-amount').forEach(el => {
                const v = parseFloat(el.value);
                if (!isNaN(v)) feeSum += v;
            });

            // hidden に保存
            const feeHidden = document.querySelector('#charges_fee_total');
            if (feeHidden) feeHidden.value = feeSum || 0;

            // 表示テキスト更新
            const feeDisplay = document.querySelector('#charges_fee_total_display');
            if (feeDisplay) {
                feeDisplay.textContent = (feeSum || 0).toLocaleString() + '円';
            }

            // === 諸費用 合計 ===
            const total = (taxSum || 0) + (feeSum || 0);

            // hidden に保存
            const totalHidden = document.querySelector('#charges_total');
            if (totalHidden) totalHidden.value = total;

            // 表示テキスト更新
            const totalDisplay = document.querySelector('#charges_total_display');
            if (totalDisplay) {
                totalDisplay.textContent = total.toLocaleString() + '円';
            }

            return total;
        }


        // ------- オプション行 -------
        function optionRowTemplate(index, nameValue = '', unitPriceValue = '') {
            return `
      <div class="grid grid-cols-12 gap-2 items-center mb-2 option-row" data-index="${index}">
        <div class="col-span-9 flex items-center gap-2">
          <input type="text"
                 name="options[${index}][name]"
                 class="w-full px-3 py-2 border rounded"
                 placeholder="例）フロアマット / ナビ / ドラレコ"
                 value="${nameValue ?? ''}">
          <input type="hidden" name="options[${index}][option_type]" value="aftermarket">
          <input type="hidden" name="options[${index}][tax_treatment]" value="taxable">
        </div>
        <div class="col-span-3 flex items-center gap-2">
          <input type="number"
                 name="options[${index}][unit_price]"
                 class="option-unit-price w-full px-3 py-2 border rounded text-right"
                 inputmode="numeric" pattern="\\d*"
                 placeholder="0"
                 value="${unitPriceValue ?? ''}">
          <button type="button"
                  class="shrink-0 px-2 py-2 bg-gray-200 rounded hover:bg-gray-300"
                  title="行を削除"
                  onclick="removeOptionRow(this)">
            −
          </button>
        </div>
      </div>`;
        }

        function addOptionRow(nameValue = '', unitPriceValue = '') {
            const container = document.getElementById('options-rows');
            const nextIndex = container.querySelectorAll('.option-row').length;
            container.insertAdjacentHTML('beforeend', optionRowTemplate(nextIndex, nameValue, unitPriceValue));
            recalcAll();
        }

        function removeOptionRow(btn) {
            const row = btn.closest('.option-row');
            if (!row) return;
            row.remove();
            reindexOptionRows();
            recalcAll();
        }

        function reindexOptionRows() {
            document.querySelectorAll('#options-rows .option-row').forEach((row, idx) => {
                row.dataset.index = idx;
                row.querySelectorAll('input[name]').forEach(input => {
                    input.name = input.name.replace(/options\[\d+]/, `options[${idx}]`);
                });
            });
        }

        // オプション小計
        function calcOptionTotal() {
            const unitInputs = document.querySelectorAll('.option-unit-price');
            let sum = 0;
            unitInputs.forEach(el => {
                const v = parseFloat(el.value);
                if (!isNaN(v)) sum += v;
            });

            // hidden に保存
            const hidden = document.getElementById('option_total');
            if (hidden) hidden.value = sum || 0;

            // テキスト表示更新
            const display = document.getElementById('option_total_display');
            if (display) {
                display.textContent = (sum || 0).toLocaleString() + '円';
            }

            return sum || 0;
        }

        // ------- 合計計算 -------
        function recalcTotal() {
            const price = parseFloat(document.getElementById('price')?.value) || 0;
            const optionTotal = calcOptionTotal();
            const chargesTotal = calcChargesTotal();
            const total = price + optionTotal + chargesTotal;
            document.getElementById('total').value = total;
            return total;
        }

        function recalcPayment() {
            const total = recalcTotal();
            const trade_price = parseFloat(document.getElementById('trade_price')?.value) || 0;
            const discount = parseFloat(document.getElementById('discount')?.value) || 0;
            document.getElementById('payment').value = total - trade_price - discount;
        }

        function recalcAll() {
            updatePriceDisplay();
            recalcPayment();
        }

        // ======= 初期化（単一） =======
        document.addEventListener('DOMContentLoaded', function() {
            const taxContainer = document.getElementById('charges-tax-rows');
            const feeContainer = document.getElementById('charges-fee-rows');

            // すでに初期化済みなら何もしない（レイアウトの重複読込対策）
            if (taxContainer?.dataset.initialized === '1') return;
            taxContainer.dataset.initialized = '1';

            // イベント（車検）
            function calculateMonths() {
                const yearSelect = document.getElementById('inspection_year');
                const monthSelect = document.getElementById('inspection_month');
                const resultSpan = document.getElementById('inspection_result');
                const selectedYear = yearSelect?.value ? parseInt(yearSelect.value) : null;
                const selectedMonth = monthSelect?.value ? parseInt(monthSelect.value) : null;
                if (selectedYear && selectedMonth) {
                    const today = new Date();
                    const selectedDate = new Date(selectedYear, selectedMonth - 1, 1);
                    const diffInMonths = (selectedDate.getFullYear() - today.getFullYear()) * 12 +
                        (selectedDate.getMonth() - today.getMonth());
                    resultSpan.textContent = diffInMonths >= 0 ? `残り${diffInMonths}ヶ月` : '過去の日付';
                } else {
                    resultSpan.textContent = '';
                }
            }
            document.getElementById('inspection_year')?.addEventListener('change', calculateMonths);
            document.getElementById('inspection_month')?.addEventListener('change', calculateMonths);

            // プリセット取得（Bladeから）※配列で来る前提
            const taxPresets = @json($taxPresets ?? []);
            const feePresets = @json($feePresets ?? []);

            // クリーンスタート
            taxContainer.innerHTML = '';
            feeContainer.innerHTML = '';

            // プリセットを差し込み
            if (Array.isArray(taxPresets)) {
                taxPresets.forEach(p => addChargeRow('tax', p.name ?? '', parseInt(p.default_amount ?? 0) || 0));
            }
            if (Array.isArray(feePresets)) {
                feePresets.forEach(p => addChargeRow('fee', p.name ?? '', parseInt(p.default_amount ?? 0) || 0));
            }

            // 必ず「後に」空フォーム3行を追加（要件）
            for (let i = 0; i < 3; i++) addChargeRow('tax');
            for (let i = 0; i < 3; i++) addChargeRow('fee');

            // オプションは空3行
            for (let i = 0; i < 3; i++) addOptionRow();

            // 入力委任（再計算）
            taxContainer.addEventListener('input', e => {
                if (e.target.classList.contains('charge-amount')) recalcAll();
            });
            feeContainer.addEventListener('input', e => {
                if (e.target.classList.contains('charge-amount')) recalcAll();
            });
            document.getElementById('options-rows').addEventListener('input', e => {
                if (e.target.classList.contains('option-unit-price')) recalcAll();
            });

            // 初期計算
            recalcAll();

            // 下取り・値引きも監視
            ['trade_price', 'discount'].forEach(id => {
                document.getElementById(id)?.addEventListener('input', recalcPayment);
            });
        });



        // ポップアップウインドウ操作（税金）
        function openTaxPopup(taxType) {
            const popupId = `taxPopup${taxType.replace('tax_', '')}`;
            document.getElementById(popupId).classList.remove('hidden');
            highlightCurrentMonth(popupId); // ポップアップを開くときに当月をハイライト    
        }

        function closeTaxPopup(taxType) {
            const popupId = `taxPopup${taxType.replace('tax_', '')}`;
            document.getElementById(popupId).classList.add('hidden');
        }

        function selectTax(amount, taxType) {
            const inputId = taxType;
            document.getElementById(inputId).value = amount;
            closeTaxPopup(taxType); // クリック後ポップアップを閉じる
        }


        // 現在の月をハイライト
        function highlightCurrentMonth(popupId) {
            // 現在の月を取得（1月 = 1, 2月 = 2, ..., 12月 = 12）
            const currentMonth = new Date().getMonth() + 1;

            // すべてのthのハイライトをリセット
            document.querySelectorAll(`#${popupId} th[data-month]`).forEach(th => {
                th.classList.remove('bg-yellow-300', 'text-black');
            });

            // 該当するthにハイライトを適用
            const currentTh = document.querySelector(`#${popupId} th[data-month="${currentMonth}"]`);
            if (currentTh) {
                currentTh.classList.add('bg-yellow-300', 'text-black');
            }

        }

        // ポップアップ内の税金選択
        function selectTax(amount, taxType) {
            const input = document.getElementById(taxType); // 例: 'tax_1'
            if (!input) {
                console.warn('selectTax target not found:', taxType);
                closeTaxPopup(taxType);
                return;
            }
            input.value = amount;

            // 即時に小計/合計を更新させる
            input.dispatchEvent(new Event('input', {
                bubbles: true
            }));

            closeTaxPopup(taxType);
        }
    </script>


</x-app-layout>