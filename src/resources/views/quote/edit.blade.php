<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            クイック見積もり編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- バリデーションエラーメッセージ -->
                @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif


                <!-- 更新フォーム (PUTメソッド)テスト -->
                <form action="{{ route('quotes.update', $quote->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')



                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">車種</h3>

                    <!-- 購入車種 -->
                    <div class="mb-4 bg-blue-100 p-6 rounded-lg">
                        <div class="mb-4">
                            <label for="car" class="block text-gray-700 font-semibold mb-1">車名</label>
                            <input type="text" name="car" id="car" value="{{ old('car', $quote->car) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="grade" class="block text-gray-700 font-semibold mb-1">グレード</label>
                            <input type="text" name="grade" id="grade" value="{{ old('grade', $quote->grade) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="color" class="block text-gray-700 font-semibold mb-1">色</label>
                            <input type="text" name="color" id="color" value="{{ old('color', $quote->color) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="mb-4 flex space-x-8">
                            <div class="w-1/2">
                                <label for="transmission" class="block text-gray-700 font-semibold mb-1">ミッション</label>
                                <div class="flex items-center">
                                    <input type="radio" name="transmission" id="transmission_at" value="AT" {{ old('transmission', $quote->transmission) == 'AT' ? 'checked' : '' }} class="mr-2">
                                    <label for="transmission_at" class="mr-4">AT</label>
                                    <input type="radio" name="transmission" id="transmission_mt" value="MT" {{ old('transmission', $quote->transmission) == 'MT' ? 'checked' : '' }} class="mr-2">
                                    <label for="transmission_mt">MT</label>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <label for="drive" class="block text-gray-700 font-semibold mb-1">駆動</label>
                                <div class="flex items-center">
                                    <input type="radio" name="drive" id="drive_2wd" value="2WD" {{ old('drive', $quote->drive) == '2WD' ? 'checked' : '' }} class="mr-2">
                                    <label for="drive_2wd" class="mr-4">2WD</label>
                                    <input type="radio" name="drive" id="drive_4wd" value="4WD" {{ old('drive', $quote->drive) == '4WD' ? 'checked' : '' }} class="mr-2">
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
                                $eraNames = [
                                2019 => '令和',
                                1989 => '平成'
                                ];
                                $selectedYear = old('year', $quote->year);
                                @endphp
                                <option value=""></option>
                                @for ($year = $currentYear; $year >= $endYear; $year--)
                                @php
                                $era = '昭和'; // 初期値
                                $eraYear = $year;
                                foreach ($eraNames as $eraStart => $eraName) {
                                if ($year >= $eraStart) {
                                $era = $eraName;
                                $eraYear = $year - $eraStart + 1;
                                break;
                                }
                                }
                                @endphp
                                <option value="{{ $year }}" {{ (int)$selectedYear === $year ? 'selected' : '' }}>
                                    {{ $year }}（{{ $era }}{{ $eraYear }}年）
                                </option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="mileage" class="block text-gray-700 font-semibold mb-1">走行距離</label>
                            <input type="text" name="mileage" id="mileage" inputmode="numeric" value="{{ old('mileage', $quote->mileage) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>


                        @php
                        $inspectionValue = old('inspection', $quote->inspection); // 例: '2025-7' or '2年付'
                        $selectedInspectionYear = null;
                        $selectedInspectionMonth = null;

                        if ($inspectionValue === '2年付' || $inspectionValue === '3年付') {
                        $selectedInspectionYear = $inspectionValue;
                        } elseif ($inspectionValue && strpos($inspectionValue, '-') !== false) {
                        [$selectedInspectionYear, $selectedInspectionMonth] = explode('-', $inspectionValue);
                        $selectedInspectionYear = (int) $selectedInspectionYear;
                        $selectedInspectionMonth = (int) $selectedInspectionMonth;
                        }
                        @endphp

                        <div class="mb-4">
                            <div class="flex items-center justify-between">
                                <label for="inspection" class="text-gray-700 font-semibold mb-1">車検日</label>
                                <span id="inspection_result" class="text-gray-700 font-medium text-sm mb-1"></span>
                            </div>

                            <div class="flex space-x-2 items-center">
                                <!-- 年の選択 -->
                                <select name="inspection_year" id="inspection_year" class="w-1/2 px-4 py-2 border rounded-lg">
                                    @php
                                    $currentYear = now()->year;
                                    $reiwaStart = 2019;
                                    $startYear = $currentYear;
                                    $endYear = $currentYear + 3;
                                    @endphp
                                    <option value=""></option>
                                    <option value="2年付" {{ old('inspection_year', $selectedInspectionYear) === '2年付' ? 'selected' : '' }}>2年付</option>
                                    <option value="3年付" {{ old('inspection_year', $selectedInspectionYear) === '3年付' ? 'selected' : '' }}>3年付</option>

                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        @php
                                        $reiwa=$year - $reiwaStart + 1;
                                        @endphp
                                        <option value="{{ $year }}" {{ (int)old('inspection_year', $selectedInspectionYear) === $year ? 'selected' : '' }}>
                                        {{ $year }}（令和{{ $reiwa }}年）
                                        </option>
                                        @endfor
                                </select>

                                <!-- 月の選択 -->
                                <select name="inspection_month" id="inspection_month" class="w-1/2 px-4 py-2 border rounded-lg">
                                    <option value=""></option>
                                    @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ (int)old('inspection_month', $selectedInspectionMonth) === $month ? 'selected' : '' }}>
                                        {{ $month }}月
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">車両価格</h3>

                    <!-- 車輌価格 -->
                    <div class="mb-4 bg-yellow-100 p-6 rounded-lg">
                        <div class="mb-4">
                            <!-- ラベルと換算結果を横並びに -->
                            <div class="flex items-center justify-between">
                                <label for="price" class="text-gray-700 font-semibold mb-1">価格</label>
                                <span id="price_converted" class="text-gray-700 font-medium text-sm mb-1"></span>
                            </div>

                            <!-- 入力と万表示 -->
                            <div class="flex items-center">
                                <input
                                    type="number"
                                    name="price"
                                    id="price"
                                    value="{{ old('price', $quote->price) }}"
                                    class="w-full px-4 py-2 border rounded-lg"
                                    inputmode="numeric" pattern="\d*"
                                    required
                                    oninput="calculateTotal(); calculatePriceDisplay();">
                            </div>
                        </div>
                    </div>



                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">諸費用</h3>

                    <!-- 税金・保険料 -->
                    <div class="mb-4 bg-purple-100 p-6 rounded-lg">
                        <div class="mb-4">
                            <label for="tax_1" class="block text-gray-700 font-semibold mb-1 flex items-center">
                                自動車税
                                <!-- ポップアップアイコンボタン -->
                                <button type="button" onclick="openTaxPopup('tax_1')" class="ml-2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </label>
                            <input
                                type="number"
                                name="tax_1"
                                id="tax_1"
                                value="{{ old('tax_1', $quote->tax_1) }}"
                                class="w-full px-4 py-2 border rounded-lg"
                                inputmode="numeric" pattern="\d*"
                                oninput="calculateOverheadTotal()">
                        </div>

                        @include('quote.popup.tax_1')

                        <div class="mb-4">
                            <label for="tax_2" class="block text-gray-700 font-semibold mb-1 flex items-center">
                                重量税
                                <!-- ポップアップアイコンボタン -->
                                <button type="button" onclick="openTaxPopup('tax_2')" class="ml-2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </label>
                            <input
                                type="number"
                                name="tax_2"
                                id="tax_2"
                                value="{{ old('tax_2', $quote->tax_2) }}"
                                class="w-full px-4 py-2 border rounded-lg"
                                inputmode="numeric" pattern="\d*"
                                oninput="calculateOverheadTotal()">
                        </div>

                        @include('quote.popup.tax_2')

                        <div class="mb-4">
                            <label for="tax_3" class="block text-gray-700 font-semibold mb-1 flex items-center">
                                自賠責保険
                                <!-- ポップアップアイコンボタン -->
                                <button type="button" onclick="openTaxPopup('tax_3')" class="ml-2 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </label>
                            <input
                                type="number"
                                name="tax_3"
                                id="tax_3"
                                value="{{ old('tax_3', $quote->tax_3) }}"
                                class="w-full px-4 py-2 border rounded-lg"
                                inputmode="numeric" pattern="\d*"
                                oninput="calculateOverheadTotal()">
                        </div>

                        @include('quote.popup.tax_3')

                        <div class="mb-4">
                            <label for="tax_4" class="block text-gray-700 font-semibold mb-1">環境性能割
                                <a href="https://www.jucda.or.jp/tax/kankyouseinouwari/"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="ml-2 text-gray-500 hover:text-gray-700">
                                    <i class="fa-solid fa-square-arrow-up-right"></i>
                                </a>
                            </label>
                            <input type="number" name="tax_4" id="tax_4" value="{{ old('tax_4', $quote->tax_4) }}" class="w-full px-4 py-2 border rounded-lg" inputmode="numeric" pattern="\d*" oninput="calculateOverheadTotal()">
                        </div>
                        <div class="mb-4">
                            <label for="tax_5" class="block text-gray-700 font-semibold mb-1">リサイクル費用
                                <a href="http://www1.jars.gr.jp/index.html"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="ml-2 text-gray-500 hover:text-gray-700">
                                    <i class="fa-solid fa-square-arrow-up-right"></i>
                                </a>
                            </label>
                            <input type="number" name="tax_5" id="tax_5" value="{{ old('tax_5', $quote->tax_5) }}" class="w-full px-4 py-2 border rounded-lg" inputmode="numeric" pattern="\d*" oninput="calculateOverheadTotal()">
                        </div>
                    </div>


                    <!-- 諸費用 -->
                    <div class="mb-4 bg-purple-100 p-6 rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="overhead_1" class="block text-gray-700 font-semibold mb-1"></label>
                                <input type="text" name="overheadName_1" id="overheadName_1" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly placeholder="登録費用">
                            </div>
                            <div class="mb-4">
                                <input type="number" name="overhead_1" id="overhead_1" inputmode="numeric" pattern="\d*" value="{{ old('overhead_1', $quote->overhead_1) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
                            </div>
                            <div class="mb-4">
                                <label for="overheadName_11" class="block text-gray-700 font-semibold mb-1"></label>
                                <input type="text" name="overheadName_11" id="overheadName_11" value="{{ old('overheadName_11', $quote->overheadName_11) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="諸費用入力">
                            </div>
                            <div class="mb-4">
                                <input type="number" name="overhead_11" id="overhead_11" inputmode="numeric" pattern="\d*" value="{{ old('overhead_11', $quote->overhead_11) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
                            </div>
                        </div>
                    </div>


                    <!-- 諸費用の合計 -->
                    <div class="mb-4 bg-purple-100 p-6 rounded-lg">
                        <div class="mb-4">
                            <label for="overhead_total" class="block text-gray-700 font-semibold mb-1">小計</label>
                            <input type="number" name="overhead_total" id="overhead_total" value="{{ old('overhead_total', $quote->overhead_total) }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly oninput="calculateTotal()">
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">オプションその他</h3>

                    <!-- オプション -->
                    <div class="mb-4 bg-blue-200 p-6 rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="optionName_1" class="block text-gray-700 font-semibold mb-1"></label>
                                <input type="text" name="optionName_1" id="optionName_1" value="{{ old('optionName_1', $quote->optionName_1) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
                            </div>
                            <div class="mb-4">
                                <input type="number" name="option_1" id="option_1" inputmode="numeric" pattern="\d*" value="{{ old('option_1', $quote->option_1) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
                            </div>
                            <div class="mb-4">
                                <label for="optionName_2" class="block text-gray-700 font-semibold mb-1"></label>
                                <input type="text" name="optionName_2" id="optionName_2" value="{{ old('optionName_2', $quote->optionName_2) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
                            </div>
                            <div class="mb-4">
                                <input type="number" name="option_2" id="option_2" inputmode="numeric" pattern="\d*" value="{{ old('option_2', $quote->option_2) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
                            </div>
                            <div class="mb-4">
                                <label for="optionName_3" class="block text-gray-700 font-semibold mb-1"></label>
                                <input type="text" name="optionName_3" id="optionName_3" value="{{ old('optionName_3', $quote->optionName_3) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
                            </div>
                            <div class="mb-4">
                                <input type="number" name="option_3" id="option_3" inputmode="numeric" pattern="\d*" value="{{ old('option_3', $quote->option_3) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
                            </div>
                            <div class="mb-4">
                                <label for="optionName_4" class="block text-gray-700 font-semibold mb-1"></label>
                                <input type="text" name="optionName_4" id="optionName_4" value="{{ old('optionName_4', $quote->optionName_4) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
                            </div>
                            <div class="mb-4">
                                <input type="number" name="option_4" id="option_4" inputmode="numeric" pattern="\d*" value="{{ old('option_4', $quote->option_4) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
                            </div>
                            <div class="mb-4">
                                <label for="optionName_5" class="block text-gray-700 font-semibold mb-1"></label>
                                <input type="text" name="optionName_5" id="optionName_5" value="{{ old('optionName_5', $quote->optionName_5) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
                            </div>
                            <div class="mb-4">
                                <input type="number" name="option_5" id="option_5" inputmode="numeric" pattern="\d*" value="{{ old('option_5', $quote->option_5) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
                            </div>

                            <!-- オプション合計 -->
                            <div class="mb-4 col-span-2">
                                <label for="option_total" class="block text-gray-700 font-semibold mb-1">小計</label>
                                <input type="number" name="option_total" id="option_total" value="{{ old('option_total', $quote->option_total) }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly oninput="calculateTotal()">
                            </div>
                        </div>
                    </div>

                    <!-- 車両コミコミ合計 -->
                    <div class="mb-4">
                        <label for="total" class="block text-gray-700 font-semibold mb-1">合計（税込）</label>
                        <input type="number" name="total" id="total" value="{{ old('total', $quote->total) }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="trade_price" class="block text-gray-700 font-semibold mb-1">下取り価格</label>
                        <input type="number" name="trade_price" id="trade_price" inputmode="numeric" pattern="\d*" value="{{ old('trade_price', $quote->trade_price) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculatePayment()">
                    </div>
                    <div class="mb-4">
                        <label for="discount" class="block text-gray-700 font-semibold mb-1">値引き</label>
                        <input type="number" name="discount" id="discount" inputmode="numeric" pattern="\d*" value="{{ old('discount', $quote->discount) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculatePayment()">
                    </div>
                    <div class="mb-4">
                        <label for="payment" class="block text-gray-700 font-semibold mb-1">お支払い総額</label>
                        <input type="number" name="payment" id="payment" value="{{ old('payment', $quote->payment) }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
                    </div>

                    <div>
                        <label for="memo" class="block text-gray-700 font-semibold mb-1">メモ</label>
                        <input type="text" name="memo" id="memo" value="{{ old('memo', $quote->memo) }}" class="w-full px-4 py-2 border rounded-lg">
                    </div>

                    <!-- ボタンエリア（更新 & キャンセル） -->
                    <div class="flex space-x-2">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            更新
                        </button>
                        <a href="{{ route('quote.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            キャンセル
                        </a>
                    </div>
                </form>

                <!--PDF生成用フォーム (POSTメソッド)-->
                <form action="{{ route('quotes.createPdf') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="car" value="{{ $quote->car }}">
                    <input type="hidden" name="grade" value="{{ $quote->grade }}">
                    <input type="hidden" name="displacement" value="{{ $quote->displacement }}">
                    <input type="hidden" name="transmission" value="{{ $quote->transmission }}">
                    <input type="hidden" name="color" value="{{ $quote->color }}">
                    <input type="hidden" name="drive" value="{{ $quote->drive }}">
                    <input type="hidden" name="year" value="{{ $quote->year }}">
                    <input type="hidden" name="mileage" value="{{ $quote->mileage }}">
                    <input type="hidden" name="inspection" value="{{ $quote->inspection }}">
                    <input type="hidden" name="price" value="{{ $quote->price }}">
                    <input type="hidden" name="tax_1" value="{{ $quote->tax_1 }}">
                    <input type="hidden" name="tax_2" value="{{ $quote->tax_2 }}">
                    <input type="hidden" name="tax_3" value="{{ $quote->tax_3 }}">
                    <input type="hidden" name="tax_4" value="{{ $quote->tax_4 }}">
                    <input type="hidden" name="tax_5" value="{{ $quote->tax_5 }}">
                    <input type="hidden" name="tax_total" value="{{ $quote->tax_total }}">
                    <input type="hidden" name="overhead_1" value="{{ $quote->overhead_1 }}">
                    <input type="hidden" name="overhead_2" value="{{ $quote->overhead_2 }}">
                    <input type="hidden" name="overhead_total" value="{{ $quote->overhead_total }}">
                    <input type="hidden" name="optionName_1" value="{{ $quote->optionName_1 }}">
                    <input type="hidden" name="option_1" value="{{ $quote->option_1 }}">
                    <input type="hidden" name="optionName_2" value="{{ $quote->optionName_2 }}">
                    <input type="hidden" name="option_2" value="{{ $quote->option_2 }}">
                    <input type="hidden" name="optionName_3" value="{{ $quote->optionName_3 }}">
                    <input type="hidden" name="option_3" value="{{ $quote->option_3 }}">
                    <input type="hidden" name="optionName_4" value="{{ $quote->optionName_4 }}">
                    <input type="hidden" name="option_4" value="{{ $quote->option_4 }}">
                    <input type="hidden" name="optionName_5" value="{{ $quote->optionName_5 }}">
                    <input type="hidden" name="option_5" value="{{ $quote->option_5 }}">
                    <input type="hidden" name="option_total" value="{{ $quote->option_total }}">
                    <input type="hidden" name="total" value="{{ $quote->total }}">
                    <input type="hidden" name="trade_price" value="{{ $quote->trade_price }}">
                    <input type="hidden" name="discount" value="{{ $quote->discount }}">
                    <input type="hidden" name="payment" value="{{ $quote->payment }}">
                    <input type="hidden" name="memo" value="{{ $quote->memo }}">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                        PDF
                    </button>
                </form>
            </div>
        </div>


        <!-- ログインユーザの制限処理 -->
        @php
        $limit = auth()->user()->limit(); // モデルに定義（例：100 or 5）
        $quoteCount = auth()->user()->quotes()->count();
        $isOverLimit = $quoteCount >= $limit;
        @endphp

        <!-- 見積もり一覧 -->
        <x-save-list :items="$quotes" itemName="quote" :is-over-limit="$isOverLimit" routePrefix="quotes" />


        <script>
            // 諸費用の合計
            function calculateOverheadTotal() {
                let tax1 = parseFloat(document.getElementById('tax_1')?.value) || 0;
                let tax2 = parseFloat(document.getElementById('tax_2')?.value) || 0;
                let tax3 = parseFloat(document.getElementById('tax_3')?.value) || 0;
                let tax4 = parseFloat(document.getElementById('tax_4')?.value) || 0;
                let tax5 = parseFloat(document.getElementById('tax_5')?.value) || 0;
                let overhead1 = parseFloat(document.getElementById('overhead_1')?.value) || 0;
                let overhead11 = parseFloat(document.getElementById('overhead_11')?.value) || 0;

                let overhead_total = tax1 + tax2 + tax3 + tax4 + tax5 + overhead1 + overhead11;
                document.getElementById('overhead_total').value = overhead_total;
            }

            // オプションの合計
            function calculateOptionTotal() {
                let option1 = parseFloat(document.getElementById('option_1')?.value) || 0;
                let option2 = parseFloat(document.getElementById('option_2')?.value) || 0;
                let option3 = parseFloat(document.getElementById('option_3')?.value) || 0;
                let option4 = parseFloat(document.getElementById('option_4')?.value) || 0;
                let option5 = parseFloat(document.getElementById('option_5')?.value) || 0;

                let option_total = option1 + option2 + option3 + option4 + option5;
                document.getElementById('option_total').value = option_total;
            }


            // 合計金額
            function calculateTotal() {
                let price = parseFloat(document.getElementById('price')?.value) || 0;
                let overhead_total = parseFloat(document.getElementById('overhead_total')?.value) || 0;
                let option_total = parseFloat(document.getElementById('option_total')?.value) || 0;

                let total = price + overhead_total + option_total;
                document.getElementById('total').value = total;

                calculateTaxOverheadTotal();
            }


            document.addEventListener("DOMContentLoaded", function() {
                let inputs = ['price', 'tax_1', 'tax_2', 'tax_3', 'tax_4', 'tax_5', 'overhead_1', 'overhead_11', 'option_1', 'option_2', 'option_3', 'option_4', 'option_5'];
                inputs.forEach(id => {
                    let element = document.getElementById(id);
                    if (element) {
                        element.addEventListener('input', function() {
                            if (id.startsWith('overhead_')) {
                                calculateOverheadTotal();
                            } else if (id.startsWith('option_')) {
                                calculateOptionTotal();
                            }

                            if (id === 'price') {
                                updatePriceDisplay(); // 金額を万円に変換
                            }

                            calculateTotal();
                        });
                    }
                });
            });


            // 支払い総額
            function calculatePayment() {
                let total = parseFloat(document.getElementById('total')?.value) || 0;
                let trade_price = parseFloat(document.getElementById('trade_price')?.value) || 0;
                let discount = parseFloat(document.getElementById('discount')?.value) || 0;

                let payment = total - trade_price - discount;
                document.getElementById('payment').value = payment;
            }

            document.addEventListener("DOMContentLoaded", function() {
                let inputs = ['price', 'tax_1', 'tax_2', 'tax_3', 'tax_4', 'tax_5', 'overhead_1', 'overhead_11', 'option_1', 'option_2', 'option_3', 'option_4', 'option_5', 'trade_price', 'discount'];
                inputs.forEach(id => {
                    let element = document.getElementById(id);
                    if (element) {
                        element.addEventListener('input', calculatePayment);
                    }
                });
            });


            ////保存・PDFボタン処理
            //function setFormAction(action) {
            //const form = document.getElementById('quoteForm');
            //if (action === 'save') {
            //    form.action = "{{ route('quotes.store') }}";
            //} else if (action === 'pdf') {
            //    form.action = "{{ route('quotes.createPdf') }}";
            //}
            //document.getElementById('action').value = action;
            //}




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

            // ポップアップから選択しても他の合計関数が動くようにする処理
            function selectTax(amount, taxType) {
                const input = document.getElementById(taxType);
                if (input) {
                    input.value = amount;

                    // `input` イベントを手動で発火させる
                    input.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));

                    // フォーム送信を防ぐ
                    if (event) {
                        event.preventDefault();
                    }
                }
                closeTaxPopup(taxType);
            }


            // 車検日から残り月数を計算
            document.addEventListener('DOMContentLoaded', function() {
                function calculateMonths() {
                    const yearSelect = document.getElementById('inspection_year');
                    const monthSelect = document.getElementById('inspection_month');
                    const resultSpan = document.getElementById('inspection_result');

                    const selectedYear = yearSelect.value ? parseInt(yearSelect.value) : null;
                    const selectedMonth = monthSelect.value ? parseInt(monthSelect.value) : null;

                    if (selectedYear && selectedMonth) {
                        const today = new Date();
                        const selectedDate = new Date(selectedYear, selectedMonth - 1, 1); // 1日基準

                        const diffInMonths = (selectedDate.getFullYear() - today.getFullYear()) * 12 +
                            (selectedDate.getMonth() - today.getMonth());

                        if (diffInMonths >= 0) {
                            resultSpan.textContent = `残り${diffInMonths}ヶ月`;
                        } else {
                            resultSpan.textContent = "過去の日付";
                        }
                    } else {
                        resultSpan.textContent = "";
                    }
                }

                document.getElementById('inspection_year').addEventListener('change', calculateMonths);
                document.getElementById('inspection_month').addEventListener('change', calculateMonths);
            });




            // 金額を万円に変換

            function updatePriceDisplay() {
                const priceInput = document.getElementById('price');
                const convertedDisplay = document.getElementById('price_converted');

                const value = parseFloat(priceInput.value);
                if (!isNaN(value)) {
                    const manYen = (value / 10000).toFixed(1).replace(/\.0$/, ''); // 少数点0は消す
                    convertedDisplay.textContent = `${manYen}万円`;
                } else {
                    convertedDisplay.textContent = '';
                }
            }
        </script>

</x-app-layout>