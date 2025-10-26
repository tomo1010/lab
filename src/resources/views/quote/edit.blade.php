<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            クイック見積もり（編集）
        </h2>
    </x-slot>

    <div class="text-xs text-gray-500"></div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- 成功・エラーメッセージ --}}
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

                {{-- PDFポップアップ等 --}}
                @include('quote.popup.tax_1')
                @include('quote.popup.tax_2')
                @include('quote.popup.tax_3')
                @include('quote.popup.tax_item')
                @include('quote.popup.option_item')

                {{-- 編集フォーム --}}
                <form id="quoteForm" action="{{ route('quote.update', ['quote' => $quote->id]) }}" method="POST" class="mb-6">
                    @csrf
                    @method('PUT')

                    {{-- ========== 車両情報 ========== --}}
                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">車両情報</h3>
                    <div class="mb-4 bg-blue-100 p-6 rounded-lg">

                        <div class="mb-4">
                            <label for="car" class="block text-gray-700 font-semibold mb-1">車名</label>
                            <input type="text" name="car" id="car"
                                class="w-full px-4 py-2 border rounded-lg"
                                value="{{ old('car', $quote->car) }}">
                        </div>

                        <div class="mb-4">
                            <label for="grade" class="block text-gray-700 font-semibold mb-1">グレード</label>
                            <input type="text" name="grade" id="grade"
                                class="w-full px-4 py-2 border rounded-lg"
                                value="{{ old('grade', $quote->grade) }}">
                        </div>

                        <div class="mb-4">
                            <label for="color" class="block text-gray-700 font-semibold mb-1">色</label>
                            <input type="text" name="color" id="color"
                                class="w-full px-4 py-2 border rounded-lg"
                                value="{{ old('color', $quote->color) }}">
                        </div>

                        <div class="mb-4 flex space-x-8">
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-semibold mb-1">ミッション</label>
                                <div class="flex items-center">
                                    <input type="radio" name="transmission" id="transmission_at" value="AT" class="mr-2"
                                        {{ old('transmission', $quote->transmission) === 'AT' ? 'checked' : '' }}>
                                    <label for="transmission_at" class="mr-4">AT</label>

                                    <input type="radio" name="transmission" id="transmission_mt" value="MT" class="mr-2"
                                        {{ old('transmission', $quote->transmission) === 'MT' ? 'checked' : '' }}>
                                    <label for="transmission_mt">MT</label>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-semibold mb-1">駆動</label>
                                <div class="flex items-center">
                                    <input type="radio" name="drive" id="drive_2wd" value="2WD" class="mr-2"
                                        {{ old('drive', $quote->drive) === '2WD' ? 'checked' : '' }}>
                                    <label for="drive_2wd" class="mr-4">2WD</label>

                                    <input type="radio" name="drive" id="drive_4wd" value="4WD" class="mr-2"
                                        {{ old('drive', $quote->drive) === '4WD' ? 'checked' : '' }}>
                                    <label for="drive_4wd">4WD</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center justify-between">
                                <label for="year" class="block text-gray-700 font-semibold mb-1">年式</label>
                                <span id="year_age" class="text-gray-700 font-medium text-sm mb-1"></span>
                            </div>
                            <select name="year" id="year" class="w-full px-4 py-2 border rounded-lg">
                                @php
                                $currentYear = now()->year;
                                $endYear = 1989;
                                $eraNames = [2019 => '令和', 1989 => '平成'];
                                $selectedYear = old('year', $quote->year);
                                @endphp
                                <option value=""></option>
                                @for ($year = $currentYear; $year >= $endYear; $year--)
                                @php
                                $era = '昭和'; $eraYear = $year;
                                foreach ($eraNames as $eraStart => $eraName) {
                                if ($year >= $eraStart) {
                                $era = $eraName; $eraYear = $year - $eraStart + 1; break;
                                }
                                }
                                @endphp
                                <option value="{{ $year }}" {{ (string)$selectedYear === (string)$year ? 'selected' : '' }}>
                                    {{ $year }}（{{ $era }}{{ $eraYear }}年）
                                </option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center justify-between">
                                <label for="mileage" class="block text-gray-700 font-semibold mb-1">走行距離</label>
                                <span id="mileage_converted" class="text-gray-700 font-medium text-sm mb-1"></span>
                            </div>
                            <input type="text" name="mileage" id="mileage"
                                class="w-full px-4 py-2 border rounded-lg"
                                inputmode="numeric" pattern="\d*"
                                value="{{ old('mileage', $quote->mileage) }}">
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center justify-between">
                                <label class="text-gray-700 font-semibold mb-1">車検日</label>
                                <span id="inspection_result" class="text-gray-700 font-medium text-sm mb-1"></span>
                            </div>
                            @php
                            $inspectionYear = null;
                            $inspectionMonth = null;
                            if (old('inspection_year') !== null || old('inspection_month') !== null) {
                            $inspectionYear = old('inspection_year');
                            $inspectionMonth = old('inspection_month');
                            } elseif (!empty($quote->inspection) && str_contains($quote->inspection, '-')) {
                            [$inspectionYear, $inspectionMonth] = explode('-', $quote->inspection);
                            }
                            $inspectionYear = $inspectionYear ?: '';
                            $inspectionMonth = $inspectionMonth ?: '';
                            $reiwaStart = 2019; $startYear = now()->year; $endYear = $startYear + 3;
                            @endphp
                            <div class="flex space-x-2 items-center">
                                <select name="inspection_year" id="inspection_year" class="w-1/2 px-4 py-2 border rounded-lg">
                                    <option value=""></option>
                                    <option value="2年付" {{ $inspectionYear === '2年付' ? 'selected' : '' }}>2年付</option>
                                    <option value="3年付" {{ $inspectionYear === '3年付' ? 'selected' : '' }}>3年付</option>
                                    @for ($y = $startYear; $y <= $endYear; $y++)
                                        @php $reiwa=$y - $reiwaStart + 1; @endphp
                                        <option value="{{ $y }}" {{ (string)$inspectionYear === (string)$y ? 'selected' : '' }}>
                                        {{ $y }}（令和{{ $reiwa }}年）
                                        </option>
                                        @endfor
                                </select>

                                <select name="inspection_month" id="inspection_month" class="w-1/2 px-4 py-2 border rounded-lg">
                                    <option value=""></option>
                                    @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ (string)$inspectionMonth === (string)$m ? 'selected' : '' }}>
                                        {{ $m }}月
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- ========== 車両価格 ========== --}}
                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">車両価格</h3>
                    <div class="mb-4 bg-yellow-100 p-6 rounded-lg">
                        <div class="mb-4">
                            <div class="flex items-center justify-between">
                                <label for="price" class="text-gray-700 font-semibold mb-1">価格</label>
                                <span id="price_converted" class="text-gray-700 font-medium text-sm mb-1"></span>
                            </div>
                            <div class="flex items-center">
                                <input type="number" name="price" id="price"
                                    class="w-full px-4 py-2 border rounded-lg"
                                    inputmode="numeric" pattern="\d*"
                                    value="{{ old('price', $quote->price) }}"
                                    oninput="updatePriceDisplay(); recalcAll();">
                            </div>
                        </div>
                    </div>

                    {{-- ========== 諸費用 ========== --}}
                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">
                        諸費用（税金・保険料 / 販売諸費用）
                    </h3>

                    {{-- 税金・保険料 --}}
                    <div class="mb-4 bg-purple-100 p-6 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-lg font-semibold text-gray-800">税金・保険料など</div>
                        </div>

                        <div id="charges-tax-rows"></div>
                        <button type="button" class="text-blue-600 hover:underline underline-offset-2 hover:text-blue-700"
                            onclick="addChargeRow('tax')">＋ 追加</button>
                        <button type="button" class="text-blue-600 hover:underline underline-offset-2 hover:text-blue-700"
                            onclick="removeChargeRow('tax')">− 削除</button>

                        <div class="mt-4 text-right">
                            <span class="text-gray-700 font-semibold">
                                小計：<span id="charges_tax_total_display" class="text-gray-800 font-bold">0円</span>
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
                        <button type="button" class="text-blue-600 hover:underline underline-offset-2 hover:text-blue-700"
                            onclick="addChargeRow('fee')">＋ 追加</button>
                        <button type="button" class="text-blue-600 hover:underline underline-offset-2 hover:text-blue-700"
                            onclick="removeChargeRow('fee')">− 削除</button>

                        <div class="mt-4 text-right">
                            <span class="text-gray-700 font-semibold">
                                小計：<span id="charges_fee_total_display" class="text-gray-800 font-bold">0円</span>
                            </span>
                            <input type="hidden" id="charges_fee_total" name="charges_fee_total" value="0">
                        </div>
                    </div>

                    {{-- 諸費用 合計 --}}
                    <div class="mb-4 bg-purple-100 p-6 rounded-lg text-right">
                        <label class="text-gray-700 font-semibold">
                            諸費用 合計：<span id="charges_total_display" class="text-gray-800 font-bold">0円</span>
                        </label>
                        <input type="hidden" id="charges_total" name="charges_total" value="0">
                    </div>

                    {{-- ========== オプション ========== --}}
                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">オプション</h3>
                    <div class="mb-4 bg-blue-200 p-6 rounded-lg">
                        <div id="options-rows"></div>

                        <div class="mt-3">
                            <button type="button" class="text-blue-600 hover:underline underline-offset-2 hover:text-blue-700"
                                onclick="addOptionRow()">＋ 追加</button>
                            <button type="button" class="text-blue-600 hover:underline underline-offset-2 hover:text-blue-700"
                                onclick="removeOptionRow()">− 削除</button>
                        </div>

                        <div class="mt-6 text-right">
                            <span class="text-gray-700 font-semibold">
                                小計：<span id="option_total_display" class="text-gray-800 font-bold">0円</span>
                            </span>
                            <input type="hidden" id="option_total" name="option_total" value="0">
                        </div>
                    </div>

                    {{-- ========== お支払い ========== --}}
                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">お支払い</h3>

                    <div class="mb-4">
                        <label for="total" class="block text-gray-700 font-semibold mb-1">合計</label>
                        <input type="number" name="total" id="total"
                            class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-right" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="trade_price" class="block text-gray-700 font-semibold mb-1">下取り価格</label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="trade_price" id="trade_price"
                                inputmode="numeric" pattern="\d*"
                                class="w-full px-4 py-2 border rounded-lg"
                                value="{{ old('trade_price', $quote->trade_price) }}"
                                oninput="recalcPayment()">

                            <button type="button"
                                class="shrink-0 px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700"
                                title="お支払い総額の1万円未満を下取りへ"
                                onclick="fillTradeRemainder()">
                                <i class="fa-solid fa-sliders"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="discount" class="block text-gray-700 font-semibold mb-1">値引き</label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="discount" id="discount"
                                inputmode="numeric" pattern="\d*"
                                class="w-full px-4 py-2 border rounded-lg"
                                value="{{ old('discount', $quote->discount) }}"
                                oninput="recalcPayment()">

                            <button type="button"
                                class="shrink-0 px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700"
                                title="お支払い総額の1万円未満を値引きへ"
                                onclick="fillDiscountRemainder()">
                                <i class="fa-solid fa-sliders"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="payment" class="block text-gray-700 font-semibold mb-1">お支払い総額</label>
                        <input type="number" name="payment" id="payment"
                            class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-right" readonly>
                    </div>

                    {{-- ========== その他 ========== --}}
                    <h3 class="mt-6 text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">その他</h3>
                    <div class="mb-4 bg-gray-200 p-6 rounded-lg">
                        <label for="message" class="block text-gray-700 font-semibold mb-1">備考</label>
                        <input type="text" name="message" id="message"
                            class="w-full px-4 py-2 border rounded-lg"
                            value="{{ old('message', $quote->message) }}">

                        <label for="memo" class="mt-4 block text-gray-700 font-semibold mb-1">メモ</label>
                        <input type="text" name="memo" id="memo"
                            class="w-full px-4 py-2 border rounded-lg"
                            placeholder="社内メモ（PDFには印字されません）"
                            value="{{ old('memo', $quote->memo) }}">
                    </div>

                    {{-- ========== ボタン群（PDF / 更新） ========== --}}
                    <div class="flex justify-center gap-4 mt-6">
                        <button
                            type="button"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"
                            onclick="submitPdfFromEdit()">
                            PDF生成
                        </button>

                            {{-- コピー --}}
                            <div x-data="taxCalculator()">
                                <button type="button"
                                    class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700"
                                    @click="copyToClipboard">
                                    コピー
                                </button>
                            </div>

                        <button
                            type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                            更新
                        </button>
                    </div>
                </form>
            </div>


            <!-- ログインユーザの制限処理 -->
            @auth
            @php
            $limit = auth()->user()->limit(); // モデルに定義（例：100 or 5）
            $quoteCount = auth()->user()->quotes()->count();
            $isOverLimit = $quoteCount >= $limit;
            @endphp
            @endauth
            
            <!-- データ保存一覧 -->
            @auth
            <x-save-list :items="$quotes" itemName="quote" :is-over-limit="$isOverLimit" routePrefix="quote" />
            @endauth

        </div>
    </div>



    @php
    $taxRows = $quote->charges
    ->where('kind', 'tax')
    ->values()
    ->map(function ($c) {
    return [
    'name' => $c->name,
    'amount' => $c->amount,
    'tax_treatment' => $c->tax_treatment,
    'tax_rate' => $c->tax_rate,
    ];
    })
    ->all();

    $feeRows = $quote->charges
    ->where('kind', 'fee')
    ->values()
    ->map(function ($c) {
    return [
    'name' => $c->name,
    'amount' => $c->amount,
    'tax_treatment' => $c->tax_treatment,
    'tax_rate' => $c->tax_rate,
    ];
    })
    ->all();

    $optionRows = $quote->options
    ->values()
    ->map(function ($o) {
    return [
    'name' => $o->name,
    'amount' => $o->amount,
    'option_type' => $o->option_type,
    'tax_treatment' => $o->tax_treatment,
    'tax_rate' => $o->tax_rate,
    ];
    })
    ->all();
    @endphp




    {{-- ====== JS（index.blade.php と同等。初期化だけ既存レコードに合わせる） ====== --}}
    <script>
        // 万円表示
        function updatePriceDisplay() {
            const priceInput = document.getElementById('price');
            const convertedDisplay = document.getElementById('price_converted');
            const value = parseFloat(priceInput.value);
            convertedDisplay.textContent = !isNaN(value) ? `${(value / 10000).toFixed(1).replace(/\.0$/, '')}万円` : '';
        }

        // 年落ち表示
        function updateYearAge() {
          const element = document.getElementById('year');
          const display = document.getElementById('year_age');
          if (!element || !display) return;

          const value = parseInt(element.value, 10);
          if (isNaN(value)) {
            display.textContent = ''; return;
          }

          const current = new Date().getFullYear();
          const age = current - value;
          display.textContent = age > 0 ? `${age}年落ち` : '';
        }

        // 走行距離を万単位表示（1000km未満は非表示）
        function updateMileageDisplay() {
          const element = document.getElementById('mileage');
          const display = document.getElementById('mileage_converted');
          if (!element || !display) return;

          const value = parseFloat(element.value);
          if (isNaN(value) || value < 1000) {
            display.textContent = ''; return;
          }

          const calcValue = value / 10000; // 万km
          display.textContent = Number.isInteger(calcValue)
            ? `${calcValue.toFixed(0)}万km`
            : `${calcValue.toFixed(1).replace(/\.0$/, '')}万km`;
        }

        // 車検の残月表示
        function calculateMonths() {
          const y = document.getElementById('inspection_year')?.value;
          const m = document.getElementById('inspection_month')?.value;
          const span = document.getElementById('inspection_result');
          const selectedYear = y ? parseInt(y) : null;
          const selectedMonth = m ? parseInt(m) : null;
          if (selectedYear && selectedMonth) {
            const today = new Date();
            const d = new Date(selectedYear, selectedMonth - 1, 1);
            const diff = (d.getFullYear() - today.getFullYear()) * 12 + (d.getMonth() - today.getMonth());
            span.textContent = diff >= 0 ? `残り${diff}ヶ月` : '過去の日付';
          } else {
            span.textContent = '';
          }
        }

        // アイコン定義
        const taxIcons = [{
                id: 'tax_1',
                label: '自動車税',
                type: 'popup'
            },
            {
                id: 'tax_2',
                label: '重量税',
                type: 'popup'
            },
            {
                id: 'tax_3',
                label: '自賠責保険',
                type: 'popup'
            },
            {
                id: 'tax_4',
                label: '環境性能割',
                type: 'link',
                url: 'https://www.jucda.or.jp/tax/kankyouseinouwari/'
            },
            {
                id: 'tax_5',
                label: 'リサイクル費用',
                type: 'link',
                url: 'http://www.jars.gr.jp/gus/exju0010.html?date=20250324'
            },
        ];

        function esc(v) {
            return String(v)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;')
                .replace(/>/g, '&gt;').replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function getChargeIconHtml(kind, index) {
            if (kind === 'tax' && index < taxIcons.length) {
                const icon = taxIcons[index];
                if (icon.type === 'popup') {
                    return `
<button type="button" onclick="openTaxPopup('${icon.id}')" class="text-gray-500 hover:text-gray-700" title="${esc(icon.label)}">
  <i class="fas fa-info-circle"></i>
</button>`;
                }
                if (icon.type === 'link') {
                    return `
<a href="${esc(icon.url)}" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-gray-700" title="${esc(icon.label)}">
  <i class="fa-solid fa-square-arrow-up-right"></i>
</a>`;
                }
            }
            return `
<button type="button" onclick="openTaxItemPopup('${kind}', ${index})" class="text-gray-500 hover:text-gray-700" title="候補から選ぶ">
  <i class="fas fa-solid fa-file"></i>
</button>`;
        }

        function chargeRowTemplate(kind, index, nameValue = '', amountValue = '') {
            const safeAmount = (amountValue === null || amountValue === undefined) ? '' : String(amountValue);
            const iconHtml = getChargeIconHtml(kind, index);

            return `
<div class="grid grid-cols-12 gap-2 items-center mb-2 charge-row" data-kind="${kind}" data-index="${index}">
  <div class="col-span-7">
    <input type="text" name="charges[${kind}][${index}][name]" class="w-full px-3 py-2 border rounded" placeholder="項目" value="${nameValue == null ? '' : esc(nameValue)}">
    <input type="hidden" name="charges[${kind}][${index}][kind]" value="${kind}">
    <input type="hidden" name="charges[${kind}][${index}][tax_treatment]" value="taxable">
  </div>
  <div class="col-span-4">
    <input type="number" name="charges[${kind}][${index}][amount]" class="charge-amount w-full px-3 py-2 border rounded text-right" inputmode="numeric" pattern="\\d*" placeholder="0" value="${esc(safeAmount)}">
  </div>
  <div class="col-span-1 flex justify-end">
    ${iconHtml}
  </div>
</div>`;
        }

        function addChargeRow(kind, nameValue = '', amountValue = '') {
            const container = document.getElementById(kind === 'tax' ? 'charges-tax-rows' : 'charges-fee-rows');
            const nextIndex = container.querySelectorAll('.charge-row').length;
            container.insertAdjacentHTML('beforeend', chargeRowTemplate(kind, nextIndex, nameValue, amountValue));
            recalcAll();
        }

        function removeChargeRow(kind) {
            const container = document.getElementById(kind === 'tax' ? 'charges-tax-rows' : 'charges-fee-rows');
            const rows = container.querySelectorAll('.charge-row');
            if (rows.length > 0) {
                rows[rows.length - 1].remove();
                reindexChargeRows(kind);
                recalcAll();
            }
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

            document.querySelectorAll('#charges-tax-rows .charge-amount').forEach(el => {
                const v = parseFloat(el.value);
                if (!isNaN(v)) taxSum += v;
            });
            const taxHidden = document.querySelector('#charges_tax_total');
            if (taxHidden) taxHidden.value = taxSum || 0;
            const taxDisplay = document.querySelector('#charges_tax_total_display');
            if (taxDisplay) taxDisplay.textContent = (taxSum || 0).toLocaleString() + '円';

            document.querySelectorAll('#charges-fee-rows .charge-amount').forEach(el => {
                const v = parseFloat(el.value);
                if (!isNaN(v)) feeSum += v;
            });
            const feeHidden = document.querySelector('#charges_fee_total');
            if (feeHidden) feeHidden.value = feeSum || 0;
            const feeDisplay = document.querySelector('#charges_fee_total_display');
            if (feeDisplay) feeDisplay.textContent = (feeSum || 0).toLocaleString() + '円';

            const total = (taxSum || 0) + (feeSum || 0);
            const totalHidden = document.querySelector('#charges_total');
            if (totalHidden) totalHidden.value = total;
            const totalDisplay = document.querySelector('#charges_total_display');
            if (totalDisplay) totalDisplay.textContent = total.toLocaleString() + '円';

            return total;
        }

        // ====== オプション ======
        function optionRowTemplate(index, nameValue = '', amountValue = '') {
            return `
<div class="grid grid-cols-12 gap-2 items-center mb-2 option-row" data-index="${index}">
  <div class="col-span-7">
    <input type="text" name="options[${index}][name]" class="w-full px-3 py-2 border rounded" placeholder="項目" value="${nameValue ?? ''}">
    <input type="hidden" name="options[${index}][option_type]" value="aftermarket">
    <input type="hidden" name="options[${index}][tax_treatment]" value="taxable">
  </div>
  <div class="col-span-4">
    <input type="number" name="options[${index}][amount]" class="option-amount w-full px-3 py-2 border rounded text-right" inputmode="numeric" pattern="\\d*" placeholder="0" value="${amountValue ?? ''}">
  </div>
  <div class="col-span-1 flex justify-end">
    <button type="button" onclick="openOptionItemPopup(${index})" class="text-gray-500 hover:text-gray-700" title="候補から選ぶ">
      <i class="fas fa-solid fa-file"></i>
    </button>
  </div>
</div>`;
        }

        function addOptionRow(nameValue = '', amountValue = '') {
            const container = document.getElementById('options-rows');
            const nextIndex = container.querySelectorAll('.option-row').length;
            container.insertAdjacentHTML('beforeend', optionRowTemplate(nextIndex, nameValue, amountValue));
            recalcAll();
        }

        function removeOptionRow() {
            const container = document.getElementById('options-rows');
            const rows = container.querySelectorAll('.option-row');
            if (rows.length > 0) {
                rows[rows.length - 1].remove();
                reindexOptionRows();
                recalcAll();
            }
        }

        function reindexOptionRows() {
            document.querySelectorAll('#options-rows .option-row').forEach((row, idx) => {
                row.dataset.index = idx;
                row.querySelectorAll('input[name]').forEach(input => {
                    input.name = input.name.replace(/options\[\d+]/, `options[${idx}]`);
                });
            });
        }

        function calcOptionTotal() {
            const inputs = document.querySelectorAll('.option-amount');
            let sum = 0;
            inputs.forEach(el => {
                const v = parseFloat(el.value);
                if (!isNaN(v)) sum += v;
            });
            const hidden = document.getElementById('option_total');
            if (hidden) hidden.value = sum || 0;
            const display = document.getElementById('option_total_display');
            if (display) display.textContent = (sum || 0).toLocaleString() + '円';
            return sum || 0;
        }

        // ====== 合計計算 ======
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
            updateYearAge();
            updateMileageDisplay();
            calculateMonths();
            recalcPayment();
        }

        // ====== 端数処理 ======
        function fillTradeRemainder() {
            recalcAll();
            const paymentEl = document.getElementById('payment');
            const tradeEl = document.getElementById('trade_price');
            if (!paymentEl || !tradeEl) return;
            const currentPayment = parseInt(paymentEl.value, 10) || 0;
            const remainder = currentPayment % 10000;
            tradeEl.value = remainder;
            tradeEl.dispatchEvent(new Event('input', {
                bubbles: true
            }));
        }

        function fillDiscountRemainder() {
            recalcAll();
            const paymentEl = document.getElementById('payment');
            const discountEl = document.getElementById('discount');
            if (!paymentEl || !discountEl) return;
            const currentPayment = parseInt(paymentEl.value, 10) || 0;
            const remainder = currentPayment % 10000;
            discountEl.value = remainder;
            discountEl.dispatchEvent(new Event('input', {
                bubbles: true
            }));
        }

        // ====== 初期化（編集用：既存レコード反映） ======
        document.addEventListener('DOMContentLoaded', function() {
            const taxContainer = document.getElementById('charges-tax-rows');
            const feeContainer = document.getElementById('charges-fee-rows');
            if (taxContainer?.dataset.initialized === '1') return;
            taxContainer.dataset.initialized = '1';


            document.getElementById('inspection_year')?.addEventListener('change', calculateMonths);
            document.getElementById('inspection_month')?.addEventListener('change', calculateMonths);

            document.getElementById('year')?.addEventListener('change', updateYearAge);
            document.getElementById('mileage')?.addEventListener('input', updateMileageDisplay);
            updateYearAge();
            updateMileageDisplay();

            // クリーンスタート
            taxContainer.innerHTML = '';
            feeContainer.innerHTML = '';

            // 既存の税金行を挿入（なければ1行だけ空）
            if (Array.isArray(taxRows) && taxRows.length) {
                taxRows.forEach((r, i) => addChargeRow('tax', r.name ?? '', r.amount ?? ''));
            } else {
                addChargeRow('tax');
            }

            // 既存の販売諸費用を挿入（なければ1行だけ空）
            if (Array.isArray(feeRows) && feeRows.length) {
                feeRows.forEach((r, i) => addChargeRow('fee', r.name ?? '', r.amount ?? ''));
            } else {
                addChargeRow('fee');
            }

            // 既存オプション（なければ3行空）
            const optContainer = document.getElementById('options-rows');
            optContainer.innerHTML = '';
            if (Array.isArray(optionRows) && optionRows.length) {
                optionRows.forEach((o, i) => addOptionRow(o.name ?? '', o.amount ?? ''));
            } else {
                for (let i = 0; i < 3; i++) addOptionRow();
            }

            // 入力で再計算
            taxContainer.addEventListener('input', e => {
                if (e.target.classList.contains('charge-amount')) recalcAll();
            });
            feeContainer.addEventListener('input', e => {
                if (e.target.classList.contains('charge-amount')) recalcAll();
            });
            document.getElementById('options-rows').addEventListener('input', e => {
                if (e.target.classList.contains('option-amount')) recalcAll();
            });

            // 初期計算
            recalcAll();

            // 下取り・値引きも監視
            ['trade_price', 'discount'].forEach(id => {
                document.getElementById(id)?.addEventListener('input', recalcPayment);
            });
        });

        // ====== ポップアップ（税金・オプション） ======
        function openTaxPopup(taxType) {
            const popupId = `taxPopup${taxType.replace('tax_', '')}`;
            const el = document.getElementById(popupId);
            if (!el) return;
            el.classList.remove('hidden');
            if (taxType !== 'tax_item' && taxType !== 'option_item') {
                highlightCurrentMonth(popupId);
            }
        }

        function closeTaxPopup(taxType) {
            const popupId = `taxPopup${taxType.replace('tax_', '')}`;
            document.getElementById(popupId)?.classList.add('hidden');
        }

        function highlightCurrentMonth(popupId) {
            const currentMonth = new Date().getMonth() + 1;
            document.querySelectorAll(`#${popupId} th[data-month]`).forEach(th => th.classList.remove('bg-yellow-300', 'text-black'));
            const currentTh = document.querySelector(`#${popupId} th[data-month="${currentMonth}"]`);
            if (currentTh) currentTh.classList.add('bg-yellow-300', 'text-black');
        }

        // tax_1〜tax_5 の金額を、税金ブロックの1〜5行目の amount へ反映
        function selectTax(amount, taxType) {
            try {
                const m = String(taxType).match(/^tax_(\d)$/);
                if (!m) return;
                const rowIndex = parseInt(m[1], 10) - 1;
                const rows = document.querySelectorAll('#charges-tax-rows .charge-row');
                if (!rows || rowIndex < 0 || rowIndex >= rows.length) {
                    closeTaxPopup(taxType);
                    return;
                }
                const amountInput = rows[rowIndex].querySelector('input[name^="charges[tax]"][name$="[amount]"]');
                if (amountInput) {
                    amountInput.value = parseInt(amount, 10) || 0;
                    amountInput.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                }
                closeTaxPopup(taxType);
                if (typeof event !== 'undefined' && event.preventDefault) event.preventDefault();
            } catch {
                closeTaxPopup(taxType);
            }
        }

        // 共通ポップアップ（tax_item）: 直近クリック行を保持
        window.__taxItemTarget = null;

        function openTaxItemPopup(kind, index) {
            window.__taxItemTarget = {
                kind,
                index
            };
            openTaxPopup('tax_item');
        }

        function selectTaxItem(name) {
            try {
                const target = window.__taxItemTarget;
                if (!target) {
                    closeTaxPopup('tax_item');
                    return;
                }
                const {
                    kind,
                    index
                } = target;
                const container = document.getElementById(kind === 'tax' ? 'charges-tax-rows' : 'charges-fee-rows');
                const rows = container?.querySelectorAll('.charge-row');
                if (!rows || index < 0 || index >= rows.length) {
                    closeTaxPopup('tax_item');
                    return;
                }
                const nameInput = rows[index].querySelector(`input[name="charges[${kind}][${index}][name]"]`) ||
                    rows[index].querySelector('input[name^="charges"][name$="[name]"]');
                if (nameInput) {
                    nameInput.value = name;
                    nameInput.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                }
                closeTaxPopup('tax_item');
            } finally {
                window.__taxItemTarget = null;
            }
        }

        // オプション popup
        window.__optionItemTargetIndex = null;

        function openOptionItemPopup(index) {
            window.__optionItemTargetIndex = index;
            openTaxPopup('option_item');
        }

        function selectOptionItem(name) {
            try {
                const idx = window.__optionItemTargetIndex;
                const rows = document.querySelectorAll('#options-rows .option-row');
                if (!rows || idx == null || idx < 0 || idx >= rows.length) {
                    closeTaxPopup('option_item');
                    return;
                }
                const nameInput = rows[idx].querySelector(`input[name="options[${idx}][name]"]`) ||
                    rows[idx].querySelector('input[name^="options"][name$="[name]"]');
                if (nameInput) {
                    nameInput.value = name;
                    nameInput.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                }
                closeTaxPopup('option_item');
            } finally {
                window.__optionItemTargetIndex = null;
            }
        }

        const taxRows = @json($taxRows);
        const feeRows = @json($feeRows);
        const optionRows = @json($optionRows);
        // 以降は今のままでOK（forEach で addChargeRow / addOptionRow するところ）


        // ====== PDFボタン ======
function submitPdfFromEdit() {
  const form = document.getElementById('quoteForm');
  if (!form) return;

  const methodSpoof = form.querySelector('input[name="_method"]'); // @method('PUT') の実体
  const prevAction = form.action;
  const prevMethod = form.method;
  const prevTarget = form.getAttribute('target');

  // 一時的に _method を無効化して POST 送信にする
  if (methodSpoof) methodSpoof.disabled = true;
  form.action = "{{ route('quote.createPdf') }}";
  form.method = "POST";
  form.setAttribute('target', '_blank'); // 同じタブで良ければこの行を削除

  form.submit();

  // 元に戻す
  form.action = prevAction;
  form.method = prevMethod;
  if (prevTarget === null) {
    form.removeAttribute('target');
  } else {
    form.setAttribute('target', prevTarget);
  }
  if (methodSpoof) methodSpoof.disabled = false;
}



    </script>
    <!-- クリップボードにコピー -->
    <script>
      async function copyToClipboard() {
        // 再計算
        recalcAll();

        // 入力値取得
        const car = document.getElementById('car')?.value || '';
        const grade = document.getElementById('grade')?.value || '';
        const color = document.getElementById('color')?.value || '';
        const transmission = document.querySelector('input[name="transmission"]:checked')?.value || '';
        const drive = document.querySelector('input[name="drive"]:checked')?.value || '';
        const year = document.getElementById('year')?.selectedOptions?.[0]?.text || '';
        const mileage = document.getElementById('mileage')?.value || '';
        const inspectionYear = document.getElementById('inspection_year')?.selectedOptions?.[0]?.text || '';
        const inspectionMonth = document.getElementById('inspection_month')?.selectedOptions?.[0]?.text || '';
        const price = document.getElementById('price')?.value || '0';
        const chargesTotal = document.getElementById('charges_total')?.value || '0';
        const optionTotal = document.getElementById('option_total')?.value || '0';
        const total = document.getElementById('total')?.value || '0';
        const tradePrice = document.getElementById('trade_price')?.value || '0';
        const discount = document.getElementById('discount')?.value || '0';
        const payment = document.getElementById('payment')?.value || '0';
        const memoText = document.getElementById('message')?.value || '';

        // 金額フォーマット
        const toYen = (v) => {
          const n = parseInt(v, 10);
          return (isNaN(n) ? 0 : n).toLocaleString() + '円';
        };

        // 諸費用：税金・保険料
        const taxLines = [];
        document.querySelectorAll('#charges-tax-rows .charge-row').forEach(row => {
          const name = (row.querySelector('input[name$="[name]"]')?.value || '').trim();
          const amount = row.querySelector('input[name$="[amount]"]')?.value || '';
          // 項目・金額どちらかの入力があれば出力
          if (name || amount) {
            const label = name || '（項目名未入力）';
            const yen = toYen(amount);
            taxLines.push(`${label}　${yen}`);
          }
        });

        // 諸費用：販売諸費用
        const feeLines = [];
        document.querySelectorAll('#charges-fee-rows .charge-row').forEach(row => {
          const name = (row.querySelector('input[name$="[name]"]')?.value || '').trim();
          const amount = row.querySelector('input[name$="[amount]"]')?.value || '';
          // 項目・金額どちらかの入力があれば出力
          if (name || amount) {
            const label = name || '（項目名未入力）';
            const yen = toYen(amount);
            feeLines.push(`${label}　${yen}`);
          }
        });

        // オプション
        const optionLines = [];
        document.querySelectorAll('#options-rows .option-row').forEach(row => {
          const name = (row.querySelector('input[name$="[name]"]')?.value || '').trim();
          const amount = row.querySelector('input[name$="[amount]"]')?.value || '';
          // 項目・金額どちらかの入力があれば出力
          if (name || amount) {
            const label = name || '（項目名未入力）';
            const yen = toYen(amount);
            optionLines.push(`${label}　${yen}`);
          }
        });

        // コピー用テキスト作成
        const lines = [];

        // --- 車名・グレード・色・ミッション・駆動 ---
        // 項目名がないので入力がある場合のみ行生成
        lines.push('▼車両情報');
        lines.push('——————————————');
        lines.push(`車種：${car}`);
        lines.push(`グレード：${grade}`);
        lines.push(`カラー：${color}`);
        const td = `${transmission}${transmission && drive ? '・' : ''}${drive}`;
        lines.push(`駆動・ミッション：${td}`);
        if (lines.length) lines.push(''); // 空行差し込み

        // --- 年式・走行距離・車検日 ---
        let year_age = document.getElementById('year_age')?.innerText || '';
        year_age = year_age.replace('落ち', '目');
        // 年式コピー文言を整形
        const matchYear = year.match(/^(\d{4})（令和(\d+)年）$/);
        let yearForCopy = year;
        if (matchYear) {
          const seireki = parseInt(matchYear[1], 10); // 西暦
          const reiwa = parseInt(matchYear[2], 10);   // 令和
          yearForCopy = `${seireki} / 令和${reiwa}年`;
        }
        if (year_age !== '') {
          lines.push(`年式：${yearForCopy} (${year_age})`);
        } else {
          lines.push(`年式：${yearForCopy}`);
        }

        const mileage_converted = document.getElementById('mileage_converted')?.innerText || '';
        if (mileage_converted !== '') {
          lines.push(`走行距離：${mileage}km (${mileage_converted})`);
        } else {
          lines.push(`走行距離：${mileage}km`);
        }

        const inspection_result = document.getElementById('inspection_result')?.innerText || '';
        const yearMonth = `${inspectionYear}${inspectionMonth}`;
        // 車検日コピー文言を整形
        let yearMonthForCopy = yearMonth;
        const matchYearMonth = yearMonth.match(/（(令和\d+年)）\s*(\d+月)?/);
        if (matchYearMonth) {
          const japaneseYear = matchYearMonth[1];
          const month = matchYearMonth[2] || '';
          yearMonthForCopy =  `${japaneseYear}${month}`;
        }
        if (inspection_result !== '') {
          lines.push(`車検：${yearMonthForCopy} (${inspection_result})`.trim());
        } else {
          lines.push(`車検：${yearMonthForCopy}`.trim());
        }
        lines.push('');
        lines.push('');

        // --- 車両価格 ---
        lines.push('▼車両価格');
        lines.push('——————————————');
        lines.push(`①${toYen(price)}`);
        lines.push('');
        lines.push('');

        // --- 諸費用 ---
        lines.push('▼諸費用');
        lines.push('——————————————');
        const hasCharges = taxLines.length || feeLines.length;
        if (hasCharges) {
          if (taxLines.length) {
            lines.push(...taxLines);
          }
          if (feeLines.length) {
            lines.push(...feeLines);
          }
          lines.push(`②計：${toYen(chargesTotal)}`);
          lines.push('');
        }
        lines.push('');

        // --- オプション ---
        lines.push('▼オプション');
        lines.push('——————————————');
        const hasOptions = optionLines.length;
        lines.push(...optionLines);
        if (hasOptions) {
          lines.push(`③計：${toYen(optionTotal)}`);
          lines.push('');
        }
        lines.push('');

        // --- お支払い ---
        lines.push('▼お支払い');
        lines.push('——————————————');
        lines.push(`①+②+③合計：${toYen(total)}`);
        lines.push(`下取り価格：-${tradePrice && parseInt(tradePrice,10) !== 0 ? toYen(tradePrice) : ''}`);
        lines.push(`値引き：-${discount && parseInt(discount,10) !== 0 ? toYen(discount) : ''}`);
        lines.push('');
        lines.push(`お支払い総額：${toYen(payment)}`);
        lines.push('');
        lines.push('');

        // --- 備考 ---
        lines.push('▼備考');
        lines.push('——————————————');
        lines.push(`${memoText}`);

        // 改行差し込み
        const output = lines.join('\n');

        // クリップボードコピー
        try {
          await navigator.clipboard.writeText(output);
          alert('入力内容をクリップボードにコピーしました！');
        } catch (e) {
          alert('コピーに失敗しました');
        }
      }
    </script>
</x-app-layout>