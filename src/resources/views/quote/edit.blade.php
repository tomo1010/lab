<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投稿を編集
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

                <!-- 更新フォーム (PUTメソッド) -->
                <form action="{{ route('quotes.update', $quote->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">お客様情報</h3>

                    <!-- ユーザ情報 -->
                    <div class="mb-4 bg-gray-100 p-6 rounded-lg">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-semibold mb-1">お客様名</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $quote->name) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="post" class="block text-gray-700 font-semibold mb-1">郵便番号</label>
                            <input type="text" name="post" id="post" value="{{ old('post', $quote->post) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="address" class="block text-gray-700 font-semibold mb-1">住所</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $quote->address) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="tell" class="block text-gray-700 font-semibold mb-1">電話番号</label>
                            <input type="text" name="tell" id="tell" value="{{ old('tell', $quote->tell) }}" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                    </div>


               <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">車両情報</h3>

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
                        <label for="displacement" class="block text-gray-700 font-semibold mb-1">排気量</label>
                        <input type="text" name="displacement" id="displacement" value="{{ old('displacement', $quote->displacement) }}" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="transmission" class="block text-gray-700 font-semibold mb-1">ミッション</label>
                        <input type="text" name="transmission" id="transmission" value="{{ old('transmission', $quote->transmission) }}" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="color" class="block text-gray-700 font-semibold mb-1">色</label>
                        <input type="text" name="color" id="color" value="{{ old('color', $quote->color) }}" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="drive" class="block text-gray-700 font-semibold mb-1">駆動</label>
                        <input type="text" name="drive" id="drive" value="{{ old('drive', $quote->drive) }}" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="year" class="block text-gray-700 font-semibold mb-1">年式</label>
                        <input type="text" name="year" id="year" value="{{ old('year', $quote->year) }}" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="mileage" class="block text-gray-700 font-semibold mb-1">走行距離</label>
                        <input type="text" name="mileage" id="mileage" value="{{ old('mileage', $quote->mileage) }}" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="inspection" class="block text-gray-700 font-semibold mb-1">車検日</label>
                        <input type="text" name="inspection" id="inspection" value="{{ old('inspection', $quote->inspection) }}" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                </div>

                <!-- 車輌価格 -->
                <div class="mb-4 bg-yellow-100 p-6 rounded-lg">
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 font-semibold mb-1">価格</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $quote->price) }}" class="w-full px-4 py-2 border rounded-lg" required oninput="calculateTotal()">
                    </div>
                </div>

                <!-- 税金・保険料 -->
                <div class="mb-4 bg-green-100 p-6 rounded-lg">
                    <div class="mb-4">
                        <label for="tax_1" class="block text-gray-700 font-semibold mb-1">自動車税</label>
                        <input type="number" name="tax_1" id="tax_1" value="{{ old('tax_1', $quote->tax_1) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculateTaxTotal()">
                    </div>
                    <div class="mb-4">
                        <label for="tax_2" class="block text-gray-700 font-semibold mb-1">重量税</label>
                        <input type="number" name="tax_2" id="tax_2" value="{{ old('tax_2', $quote->tax_2) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculateTaxTotal()">
                    </div>
                    <div class="mb-4">
                        <label for="tax_3" class="block text-gray-700 font-semibold mb-1">自賠責保険</label>
                        <input type="number" name="tax_3" id="tax_3" value="{{ old('tax_3', $quote->tax_3) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculateTaxTotal()">
                    </div>
                    <div class="mb-4">
                        <label for="tax_4" class="block text-gray-700 font-semibold mb-1">環境性能割</label>
                        <input type="number" name="tax_4" id="tax_4" value="{{ old('tax_4', $quote->tax_4) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculateTaxTotal()">
                    </div>
                    <div class="mb-4">
                        <label for="tax_5" class="block text-gray-700 font-semibold mb-1">リサイクル費用</label>
                        <input type="number" name="tax_5" id="tax_5" value="{{ old('tax_5', $quote->tax_5) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculateTaxTotal()">
                    </div>

                    <!-- 税金保険料の合計 -->
                    <div class="mb-4">
                        <label for="tax_total" class="block text-gray-700 font-semibold mb-1">小計</label>
                        <input type="number" name="tax_total" id="tax_total" value="{{ old('tax_total', $quote->tax_total) }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly oninput="calculateTotal()">
                    </div>
                </div>


                <!-- 諸費用 -->
                <div class="mb-4 bg-purple-100 p-6 rounded-lg">
                    <div class="mb-4">
                        <label for="overhead_1" class="block text-gray-700 font-semibold mb-1">登録費用</label>
                        <input type="number" name="overhead_1" id="overhead_1" value="{{ old('overhead_1', $quote->overhead_1) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
                    </div>
                    <div class="mb-4">
                        <label for="overhead_2" class="block text-gray-700 font-semibold mb-1">車庫証明</label>
                        <input type="number" name="overhead_2" id="overhead_2" value="{{ old('overhead_2', $quote->overhead_2) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
                    </div>
                    <!-- 諸費用の合計 -->
                    <div class="mb-4">
                        <label for="overhead_total" class="block text-gray-700 font-semibold mb-1">小計</label>
                        <input type="number" name="overhead_total" id="overhead_total" value="{{ old('overhead_total', $quote->overhead_total) }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly oninput="calculateTotal()">
                    </div>
                </div>


                <!-- オプション -->
                <div class="mb-4 bg-blue-200 p-6 rounded-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="optionName_1" class="block text-gray-700 font-semibold mb-1"></label>
                            <input type="text" name="optionName_1" id="optionName_1" value="{{ old('optionName_1', $quote->optionName_1) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
                        </div>
                        <div class="mb-4">
                            <input type="number" name="option_1" id="option_1" value="{{ old('option_1', $quote->option_1) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
                        </div>
                        <div class="mb-4">
                            <label for="optionName_2" class="block text-gray-700 font-semibold mb-1"></label>
                            <input type="text" name="optionName_2" id="optionName_2" value="{{ old('optionName_2', $quote->optionName_2) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
                        </div>
                        <div class="mb-4">
                            <input type="number" name="option_2" id="option_2" value="{{ old('option_2', $quote->option_2) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
                        </div>
                        <div class="mb-4">
                            <label for="optionName_3" class="block text-gray-700 font-semibold mb-1"></label>
                            <input type="text" name="optionName_3" id="optionName_3" value="{{ old('optionName_3', $quote->optionName_3) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
                        </div>
                        <div class="mb-4">
                            <input type="number" name="option_3" id="option_3" value="{{ old('option_3', $quote->option_3) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
                        </div>
                        <div class="mb-4">
                            <label for="optionName_4" class="block text-gray-700 font-semibold mb-1"></label>
                            <input type="text" name="optionName_4" id="optionName_4" value="{{ old('optionName_4', $quote->optionName_4) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
                        </div>
                        <div class="mb-4">
                            <input type="number" name="option_4" id="option_4" value="{{ old('option_4', $quote->option_4) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
                        </div>
                        <div class="mb-4">
                            <label for="optionName_5" class="block text-gray-700 font-semibold mb-1"></label>
                            <input type="text" name="optionName_5" id="optionName_5" value="{{ old('optionName_5', $quote->optionName_5) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="オプションその他">
                        </div>
                        <div class="mb-4">
                            <input type="number" name="option_5" id="option_5" value="{{ old('option_5', $quote->option_5) }}" class="w-full px-4 py-2 border rounded-lg" placeholder="価格" oninput="calculateOptionTotal()">
                        </div>

                        <!-- オプション合計 -->
                        <div class="mb-4">
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
                        <input type="number" name="trade_price" id="trade_price" value="{{ old('trade_price', $quote->trade_price) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculatePayment()">
                    </div>
                    <div class="mb-4">
                        <label for="discount" class="block text-gray-700 font-semibold mb-1">値引き</label>
                        <input type="number" name="discount" id="discount" value="{{ old('discount', $quote->discount) }}" class="w-full px-4 py-2 border rounded-lg" oninput="calculatePayment()">
                    </div>
                    <div class="mb-4">
                        <label for="payment" class="block text-gray-700 font-semibold mb-1">お支払い総額</label>
                        <input type="number" name="payment" id="payment" value="{{ old('payment', $quote->payment) }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
                    </div>

                    <!-- ボタンエリア（更新 & キャンセル） -->
                    <div class="flex space-x-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            更新
                        </button>
                        <a href="{{ route('quote.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            キャンセル
                        </a>
                    </div>
                </form>

                <!-- PDF生成用フォーム (POSTメソッド) -->
                <form action="{{ route('quotes.createPdf') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="name" value="{{ $quote->name }}">
                    <input type="hidden" name="car" value="{{ $quote->car }}">
                    <input type="hidden" name="price" value="{{ $quote->price }}">
                    <input type="hidden" name="tax" value="{{ $quote->tax }}">
                    <input type="hidden" name="total" value="{{ $quote->total }}">

                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                        PDF
                    </button>
                </form>

            </div>
        </div>
    </div>



    <!-- 投稿一覧 -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">投稿一覧</h2>

            @if(isset($quotes) && $quotes->count())
                <ul class="mt-6 space-y-4">
                    @foreach ($quotes as $quote)
                        <li class="p-4 bg-gray-100 rounded-lg flex justify-between items-center">
                            <!-- 名前・車名・更新日時 -->
                            <div>
                                <span class="text-lg font-semibold">{{ $quote->name }} {{ $quote->car }}</span>
                                <p class="text-sm text-gray-500">更新日時: {{ $quote->updated_at->format('Y-m-d H:i') }}</p>
                            </div>

                            <!-- 編集・コピー・削除ボタン（横並び） -->
                            <div class="flex space-x-2">
                                <!-- 編集 -->
                                <form action="{{ route('quotes.edit', $quote->id) }}" method="GET">
                                    <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded-lg hover:bg-yellow-500">
                                        編集
                                    </button>
                                </form>

                                <!-- コピー -->
                                <form action="{{ route('quotes.copy', $quote->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500">
                                        コピー
                                    </button>
                                </form>

                                <!-- 削除 -->
                                <form action="{{ route('quotes.destroy', $quote->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600" onclick="return confirm('本当に削除しますか？');">
                                        削除
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
                <p class="mt-6 text-gray-500">投稿はありません。</p>
            @endif
        </div>
    </div>
                


    <script>
        function calculateTaxTotal() {
            let tax1 = parseFloat(document.getElementById('tax_1')?.value) || 0;
            let tax2 = parseFloat(document.getElementById('tax_2')?.value) || 0;
            let tax3 = parseFloat(document.getElementById('tax_3')?.value) || 0;
            let tax4 = parseFloat(document.getElementById('tax_4')?.value) || 0;
            let tax5 = parseFloat(document.getElementById('tax_5')?.value) || 0;

            let tax_total = tax1 + tax2 + tax3 + tax4 + tax5;
            document.getElementById('tax_total').value = tax_total;
        }

        function calculateOptionTotal() {
            let option1 = parseFloat(document.getElementById('option_1')?.value) || 0;
            let option2 = parseFloat(document.getElementById('option_2')?.value) || 0;
            let option3 = parseFloat(document.getElementById('option_3')?.value) || 0;
            let option4 = parseFloat(document.getElementById('option_4')?.value) || 0;
            let option5 = parseFloat(document.getElementById('option_5')?.value) || 0;

            let option_total = option1 + option2 + option3 + option4 + option5;
            document.getElementById('option_total').value = option_total;
        }

        function calculateOverheadTotal() {
            let overhead1 = parseFloat(document.getElementById('overhead_1')?.value) || 0;
            let overhead2 = parseFloat(document.getElementById('overhead_2')?.value) || 0;

            let overhead_total = overhead1 + overhead2;
            document.getElementById('overhead_total').value = overhead_total;
        }

        function calculateTotal() {
            let price = parseFloat(document.getElementById('price')?.value) || 0;
            let tax_total = parseFloat(document.getElementById('tax_total')?.value) || 0;
            let overhead_total = parseFloat(document.getElementById('overhead_total')?.value) || 0;
            let option_total = parseFloat(document.getElementById('option_total')?.value) || 0;

            let total = price + tax_total + overhead_total + option_total;
            document.getElementById('total').value = total;
        }

        document.addEventListener("DOMContentLoaded", function () {
            let inputs = ['price', 'tax_1', 'tax_2', 'tax_3', 'tax_4', 'tax_5', 'overhead_1', 'overhead_2', 'option_1', 'option_2', 'option_3', 'option_4', 'option_5'];
            inputs.forEach(id => {
                let element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', function () {
                        if (id.startsWith('tax_')) {
                            calculateTaxTotal();
                        } else if (id.startsWith('overhead_')) {
                            calculateOverheadTotal();
                        } else if (id.startsWith('option_')) {
                            calculateOptionTotal();
                        }
                        calculateTotal();
                    });
                }
            });
        });


        function calculatePayment() {
            let total = parseFloat(document.getElementById('total')?.value) || 0;
            let trade_price = parseFloat(document.getElementById('trade_price')?.value) || 0;
            let discount = parseFloat(document.getElementById('discount')?.value) || 0;
            
            let payment = total - trade_price - discount;
            document.getElementById('payment').value = payment;
        }

        document.addEventListener("DOMContentLoaded", function () {
            let inputs = ['total', 'trade_price', 'discount'];
            inputs.forEach(id => {
                let element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', calculatePayment);
                }
            });
        });


    </script>

</x-app-layout>
