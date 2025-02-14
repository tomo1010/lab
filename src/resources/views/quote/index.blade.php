<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            見積もり作成
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

                <!-- ログイン済みユーザーのみ表示 -->
                @auth


<!-- 投稿フォーム -->
<form id="quoteForm" action="{{ route('quotes.store') }}" method="POST" class="mb-6">
    @csrf

    <!-- アクションを指定するための hidden input -->
    <input type="hidden" id="action" name="action" value="save">

    <!-- 名前 -->
    <div class="mb-4">
        <label for="name" class="block text-gray-700 font-semibold mb-1">名前</label>
        <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-lg" required>
    </div>

    <!-- 車種 -->
    <div class="mb-4">
        <label for="car" class="block text-gray-700 font-semibold mb-1">車種</label>
        <input type="text" name="car" id="car" class="w-full px-4 py-2 border rounded-lg" required>
    </div>


        <!-- 価格 -->
        <div class="mb-4">
        <label for="price" class="block text-gray-700 font-semibold mb-1">価格</label>
        <input type="number" name="price" id="price" class="w-full px-4 py-2 border rounded-lg" required oninput="calculateTotal()">
    </div>



<!-- ポップアップウィンドウ（自動車税月割表） -->
<div class="mb-4">
    <label for="tax_2" class="block text-gray-700 font-semibold mb-1 flex items-center">
        自動車税（月割）
        <!-- ポップアップアイコンボタン -->
        <button type="button" onclick="openTaxPopup()" class="ml-2 text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V7a1 1 0 112 0v2a1 1 0 11-2 0zm0 4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"/>
            </svg>
        </button>
    </label>
    <input type="number" name="tax_2" id="tax_2" class="w-full px-4 py-2 border rounded-lg" required>
</div>

<!-- ポップアップウィンドウ（自動車税月割表） -->
<div id="taxPopup" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl overflow-auto max-h-full">
        <h2 class="text-lg font-semibold mb-4">自動車税（月割）</h2>
        <table class="w-full border-collapse">
        <thead>
    <tr>
        <th class="border px-2 py-1">排気量</th>
        <th class="border px-2 py-1" data-month="4">4月</th>
        <th class="border px-2 py-1" data-month="5">5月</th>
        <th class="border px-2 py-1" data-month="6">6月</th>
        <th class="border px-2 py-1" data-month="7">7月</th>
        <th class="border px-2 py-1" data-month="8">8月</th>
        <th class="border px-2 py-1" data-month="9">9月</th>
        <th class="border px-2 py-1" data-month="10">10月</th>
        <th class="border px-2 py-1" data-month="11">11月</th>
        <th class="border px-2 py-1" data-month="12">12月</th>
        <th class="border px-2 py-1" data-month="1">1月</th>
        <th class="border px-2 py-1" data-month="2">2月</th>
    </tr>
</thead>
            <tbody>
                <!-- 例: 661〜1000ccの行 -->
                <tr>
                    <td class="border px-2 py-1">661〜1000</td>
                    <td class="border px-2 py-1"><button onclick="selectTax(22900)">22,900円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(20800)">20,800円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(18700)">18,700円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(16600)">16,600円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(14500)">14,500円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(12500)">12,500円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(10400)">10,400円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(8300)">8,300円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(6200)">6,200円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(4100)">4,100円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(2000)">2,000円</button></td>
                </tr>
                <tr>
                    <td class="border px-2 py-1">1001〜1500</td>
                    <td class="border px-2 py-1"><button onclick="selectTax(27900)">27,900円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(25400)">25,400円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(22800)">22,800円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(20300)">20,300円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(17700)">17,700円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(15200)">15,200円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(12700)">12,700円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(10100)">10,100円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(7600)">7,600円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(5000)">5,000円</button></td>
                    <td class="border px-2 py-1"><button onclick="selectTax(2500)">2,500円</button></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-full" onclick="closeTaxPopup()">閉じる</button>
    </div>
</div>




    <!-- 消費税 -->
    <div class="mb-4">
        <label for="tax_1" class="block text-gray-700 font-semibold mb-1">消費税 (10%)</label>
        <input type="number" name="tax_1" id="tax_1" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
    </div>

    <!-- 合計 -->
    <div class="mb-4">
        <label for="total" class="block text-gray-700 font-semibold mb-1">合計（税込）</label>
        <input type="number" name="total" id="total" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
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






<!-- 投稿一覧 -->
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
                @endauth

                <!-- 未ログインユーザー向けの表示 -->
                @guest
                    <p class="text-center mt-4 text-gray-700">投稿を見るにはログインしてください。</p>
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            ログイン
                        </a>
                        <a href="{{ route('register') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            新規登録
                        </a>
                    </div>
                @endguest

            </div>
        </div>
    </div>


    <script>
// 合計を計算
function calculateTotal() {
    let price = document.getElementById('price').value;
    let tax = Math.floor(price * 0.10); // 消費税10%
    let total = parseInt(price) + tax;

    document.getElementById('tax_1').value = isNaN(tax) ? 0 : tax;
    document.getElementById('total').value = isNaN(total) ? 0 : total;
}


// ポップアップウインドウ操作（自動車税）
function openTaxPopup() {
    document.getElementById('taxPopup').classList.remove('hidden');
    highlightCurrentMonth(); // ポップアップを開くときに当月をハイライト
}

function closeTaxPopup() {
    document.getElementById('taxPopup').classList.add('hidden');
}

function selectTax(amount) {
    document.getElementById('tax_2').value = amount;
    closeTaxPopup(); // クリック後ポップアップを閉じる
}

function highlightCurrentMonth() {
    // 現在の月を取得（1月 = 1, 2月 = 2, ..., 12月 = 12）
    const currentMonth = new Date().getMonth() + 1;
    
    // すべてのthのハイライトをリセット
    document.querySelectorAll('#taxPopup th[data-month]').forEach(th => {
        th.classList.remove('bg-yellow-300', 'text-black');
    });

    // 該当するthにハイライトを適用
    const currentTh = document.querySelector(`#taxPopup th[data-month="${currentMonth}"]`);
    if (currentTh) {
        currentTh.classList.add('bg-yellow-300', 'text-black');
    }
}






</script>


</x-app-layout>
