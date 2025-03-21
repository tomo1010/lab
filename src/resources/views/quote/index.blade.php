<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            クイック見積もり作成
        </h2>
    </x-slot>

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
    <form id="quoteForm" action="{{ route('quotes.store') }}" method="POST" class="mb-6">
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
                <div>
                    <label for="transmission" class="block text-gray-700 font-semibold mb-1">ミッション</label>
                    <div class="flex items-center">
                        <input type="radio" name="transmission" id="transmission_at" value="AT" class="mr-2">
                        <label for="transmission_at" class="mr-4">AT</label>
                        <input type="radio" name="transmission" id="transmission_mt" value="MT" class="mr-2">
                        <label for="transmission_mt">MT</label>
                    </div>
                </div>
                <div>
                    <label for="drive" class="block text-gray-700 font-semibold mb-1">駆動</label>
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
                        $currentYear = now()->year; // 今年の西暦（例: 2025）
                        $endYear = 1989; // 平成元年
                        $eraNames = [
                            2019 => '令和',
                            1989 => '平成'
                        ];
                    @endphp
                    <option value="" selected>年式を選択</option>
                    @for ($year = $currentYear; $year >= $endYear; $year--)
                        @php
                            $era = '昭和'; // 初期値（ありえないが保険）
                            $eraYear = $year; // デフォルトはそのまま西暦

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
                <input type="text" name="mileage" id="mileage" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div class="mb-4">

            <div class="flex items-center justify-between">
                <label for="inspection" class="text-gray-700 font-semibold mb-1">車検日</label>
                <span id="inspection_result" class="text-gray-700c font-medium text-sm mb-1"></span>
            </div>

            <div class="flex space-x-2 items-center">
                <!-- 年の選択 -->
                <select name="inspection_year" id="inspection_year" class="w-1/2 px-4 py-2 border rounded-lg">
                    @php
                        $currentYear = now()->year; // 今年の西暦（例: 2025年）
                        $reiwaStart = 2019; // 令和元年の西暦
                        $startReiwa = $currentYear - $reiwaStart + 1; // 今年の令和年
                        $endReiwa = $startReiwa + 3; // 3年後まで
                    @endphp
                    <option value="" selected>年を選択</option>
                    <option value="2年付">2年付</option>
                    <option value="3年付">3年付</option>
                    @for ($reiwa = $startReiwa; $reiwa <= $endReiwa; $reiwa++)
                        <option value="令和{{ $reiwa }}年" data-year="{{ $reiwa + $reiwaStart - 1 }}">
                            令和{{ $reiwa }}年
                        </option>
                    @endfor
                </select>

                <!-- 月の選択 -->
                <select name="inspection_month" id="inspection_month" class="w-1/2 px-4 py-2 border rounded-lg">
                    <option value="" selected>月を選択</option>
                    @php
                        $months = range(1, 12); // 1月〜12月
                    @endphp
                    @foreach ($months as $month)
                        <option value="{{ $month }}">{{ $month }}月</option>
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
                            class="w-full px-4 py-2 border rounded-lg"
                            required
                            oninput="calculateTotal()"
                        >
                    </div>
                </div>
            </div>


        <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">諸費用</h3>

        <!-- 税金・保険料 -->
        <div class="mb-4 bg-purple-100 p-6 rounded-lg">

            <!-- ポップアップウィンドウ（自動車税月割表） -->
            <div class="mb-4">
                <label for="tax_1" class="block text-gray-700 font-semibold mb-1 flex items-center">
                    自動車税（月割）
                    <!-- ポップアップアイコンボタン -->
                    <button type="button" onclick="openTaxPopup('tax_1')" class="ml-2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-info-circle"></i>
                    </button>
                </label>
                <input type="number" name="tax_1" id="tax_1" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
                </div>

                @include('quote.popup.tax_1')

            <!-- ポップアップウィンドウ（重量税月割表） -->
            <div class="mb-4">
                <label for="tax_2" class="block text-gray-700 font-semibold mb-1 flex items-center">
                    重量税
                    <!-- ポップアップアイコンボタン -->
                    <button type="button" onclick="openTaxPopup('tax_2')" class="ml-2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-info-circle"></i>
                    </button>
                </label>
                <input type="number" name="tax_2" id="tax_2" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
            </div>

                @include('quote.popup.tax_2')

            <!-- ポップアップウィンドウ（自賠責月割表） -->
            <div class="mb-4">
                <label for="tax_3" class="block text-gray-700 font-semibold mb-1 flex items-center">
                    自賠責
                    <!-- ポップアップアイコンボタン -->
                    <button type="button" onclick="openTaxPopup('tax_3')" class="ml-2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-info-circle"></i>
                    </button>
                </label>
                <input type="number" name="tax_3" id="tax_3" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
            </div>

                @include('quote.popup.tax_3')

            <div class="mb-4">
                <label for="tax_4" class="block text-gray-700 font-semibold mb-1">環境性能割</label>
                <input type="number" name="tax_4" id="tax_4" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
            </div>
            <div class="mb-4">
                <label for="tax_5" class="block text-gray-700 font-semibold mb-1">リサイクル費用</label>
                <input type="number" name="tax_5" id="tax_5" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
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
                    <input type="number" name="overhead_1" id="overhead_1" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
                </div>
                <div class="mb-4">
                    <label for="overheadName_11" class="block text-gray-700 font-semibold mb-1"></label>
                    <input type="text" name="overheadName_11" id="overheadName_11" class="w-full px-4 py-2 border rounded-lg" placeholder="フリー入力">
                </div>
                <div class="mb-4">
                    <input type="number" name="overhead_11" id="overhead_11" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
                </div>
            </div>
        </div>

        <!-- 税金と諸費用の合計 -->            
        <div class="mb-4 bg-purple-100 p-6 rounded-lg">
            <div class="mb-4">
                <label for="overhead_total" class="block text-gray-700 font-semibold mb-1">小計</label>
                <input type="number" name="overhead_total" id="overhead_total" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly oninput="calculateTotal()">
            </div>
        </div>

<h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">オプションその他</h3>

<!-- オプション -->
<div class="mb-4 bg-blue-200 p-6 rounded-lg">
    <div class="grid grid-cols-2 gap-4">
        <div class="mb-4">
            <label for="optionName_1" class="block text-gray-700 font-semibold mb-1"></label>
            <input type="text" name="optionName_1" id="optionName_1" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
        </div>
        <div class="mb-4">
            <input type="number" name="option_1" id="option_1" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
        </div>
        <div class="mb-4">
            <label for="optionName_2" class="block text-gray-700 font-semibold mb-1"></label>
            <input type="text" name="optionName_2" id="optionName_2" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
        </div>
        <div class="mb-4">
            <input type="number" name="option_2" id="option_2" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
        </div>
        <div class="mb-4">
            <label for="optionName_3" class="block text-gray-700 font-semibold mb-1"></label>
            <input type="text" name="optionName_3" id="optionName_3" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
        </div>
        <div class="mb-4">
            <input type="number" name="option_3" id="option_3" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
        </div>
        <div class="mb-4">
            <label for="optionName_4" class="block text-gray-700 font-semibold mb-1"></label>
            <input type="text" name="optionName_4" id="optionName_4" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
        </div>
        <div class="mb-4">
            <input type="number" name="option_4" id="option_4" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
        </div>
        <div class="mb-4">
            <label for="optionName_5" class="block text-gray-700 font-semibold mb-1"></label>
            <input type="text" name="optionName_5" id="optionName_5" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
        </div>
        <div class="mb-4">
            <input type="number" name="option_5" id="option_5" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
        </div>

        <!-- オプション合計 -->
        <div class="mb-4">
            <label for="option_total" class="block text-gray-700 font-semibold mb-1">小計</label>
            <input type="number" name="option_total" id="option_total" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly oninput="calculateTotal()">
        </div>
    </div>
</div>




    <!-- 車両コミコミ合計 -->
    <div class="mb-4">
        <label for="total" class="block text-gray-700 font-semibold mb-1">合計（税込）</label>
        <input type="number" name="total" id="total" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
    </div>

    <!-- 下取り -->
    <div class="mb-4">
        <label for="trade_price" class="block text-gray-700 font-semibold mb-1">下取り価格</label>
        <input type="number" name="trade_price" id="trade_price" class="w-full px-4 py-2 border rounded-lg" oninput="calculatePayment()">
    </div>

    <!-- 値引き -->
    <div class="mb-4">
        <label for="discount" class="block text-gray-700 font-semibold mb-1">値引き</label>
        <input type="number" name="discount" id="discount" class="w-full px-4 py-2 border rounded-lg" oninput="calculatePayment()">
    </div>

    <!-- お支払い総額 -->
    <div class="mb-4">
        <label for="payment" class="block text-gray-700 font-semibold mb-1">お支払い総額</label>
        <input type="number" name="payment" id="payment" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
    </div>

    <!--メモ -->
    <div class="mb-4">
        <label for="memo" class="block text-gray-700 font-semibold mb-1">備考</label>
        <input type="text" name="memo" id="memo" class="w-full px-4 py-2 border rounded-lg">
    </div>


  <!-- ボタンエリア（保存 & PDFボタンを横並び） -->
  <div class="flex space-x-2">
        <!-- 保存ボタン -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
            onclick="document.getElementById('quoteForm').action='{{ route('quotes.store') }}'; document.getElementById('action').value='save';">
            保存
        </button>

        <!-- PDFボタン (保存も実行) -->
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600"
            onclick="document.getElementById('quoteForm').action='{{ route('quotes.createPdf') }}'; document.getElementById('action').value='pdf';">
            PDF
        </button>
    </div>


</form>


</div>
        </div>
    


                <!-- ログイン済みユーザーのみ表示 -->
                <!--@auth-->
<!-- 見積もり一覧 -->
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">見積もり一覧</h2>
@if(isset($quotes) && $quotes->count())
<ul class="mt-6 space-y-4">
    @foreach ($quotes as $quote)
        <li class="p-4 bg-gray-100 rounded-lg flex justify-between items-center">
            <!-- 名前・車名・更新日時 -->
            <div>
                <span class="text-lg font-semibold">{{ $quote->car }}/{{ $quote->color }} {{ $quote->payment }}円</span>
                <p class="text-sm text-gray-500">更新日時: {{ $quote->updated_at->format('Y-m-d H:i') }}</p>
            </div>

<!-- 編集・コピー・削除ボタン（横並び） -->
<div class="flex space-x-2">
    <!-- 編集 -->
    <form action="{{ route('quotes.edit', $quote->id) }}" method="GET">
        <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded-lg hover:bg-yellow-500 flex items-center space-x-2">
            <i class="fas fa-edit"></i>
        </button>
    </form>

    <!-- コピー -->
    <form action="{{ route('quotes.copy', $quote->id) }}" method="POST">
        @csrf
        <button type="submit" class="bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500 flex items-center space-x-2">
            <i class="fas fa-copy"></i>
        </button>
    </form>

    <!-- 削除 -->
    <form action="{{ route('quotes.destroy', $quote->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 flex items-center space-x-2" onclick="return confirm('本当に削除しますか？');">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>

        </li>
    @endforeach
</ul>



                        <!-- ページネーション -->
                        <div class="mt-6">
                            {{ $quotes->links() }}
                        </div>
                    @else
                        <p class="mt-6 text-gray-500">見積もりはありません。</p>
                    @endif



                @endauth

                <!-- 未ログインユーザー向けの表示 -->
                <!--@guest
                    <p class="text-center mt-4 text-gray-700">投稿を見るにはログインしてください。</p>
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            ログイン
                        </a>
                        <a href="{{ route('register') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            新規登録
                        </a>
                    </div>
                @endguest-->

            </div>
        </div>
    </div>



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


        document.addEventListener("DOMContentLoaded", function () {
            let inputs = ['price', 'tax_1', 'tax_2', 'tax_3', 'tax_4', 'tax_5', 'overhead_1', 'overhead_11', 'option_1', 'option_2', 'option_3', 'option_4', 'option_5'];
            inputs.forEach(id => {
                let element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', function () {
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
        
        document.addEventListener("DOMContentLoaded", function () {
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
        input.dispatchEvent(new Event('input', { bubbles: true }));

        // フォーム送信を防ぐ
        if (event) {
            event.preventDefault();
        }
    }
    closeTaxPopup(taxType);
}



// 車検日の計算
document.addEventListener('DOMContentLoaded', function() {
    function calculateMonths() {
        const yearSelect = document.getElementById('inspection_year');
        const monthSelect = document.getElementById('inspection_month');
        const resultSpan = document.getElementById('inspection_result');

        const selectedYearOption = yearSelect.options[yearSelect.selectedIndex];
        const selectedYear = selectedYearOption.dataset.year ? parseInt(selectedYearOption.dataset.year) : null;
        const selectedMonth = monthSelect.value ? parseInt(monthSelect.value) : null;

        if (selectedYear && selectedMonth) {
            const today = new Date();
            const selectedDate = new Date(selectedYear, selectedMonth - 1, 1); // 1日を基準にする

            const diffInMonths = (selectedDate.getFullYear() - today.getFullYear()) * 12 + (selectedDate.getMonth() - today.getMonth());

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
