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
        <label for="price" class="block text-gray-700 font-semibold mb-1">価格（税抜）</label>
        <input type="number" name="price" id="price" class="w-full px-4 py-2 border rounded-lg" required oninput="calculateTotal()">
    </div>

    <!-- 消費税 -->
    <div class="mb-4">
        <label for="tax" class="block text-gray-700 font-semibold mb-1">消費税 (10%)</label>
        <input type="number" name="tax" id="tax" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
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


<!-- 価格入力時に自動計算するJavaScript -->
<script>
function calculateTotal() {
    let price = document.getElementById('price').value;
    let tax = Math.floor(price * 0.10); // 消費税10%
    let total = parseInt(price) + tax;

    document.getElementById('tax').value = isNaN(tax) ? 0 : tax;
    document.getElementById('total').value = isNaN(total) ? 0 : total;
}
</script>


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
</x-app-layout>
