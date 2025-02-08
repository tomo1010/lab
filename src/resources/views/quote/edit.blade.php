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

                <!-- 編集フォーム -->
                <form action="{{ route('quotes.update', $quote->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-gray-700 font-semibold mb-1">名前</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $quote->name) }}" class="w-full px-4 py-2 border rounded-lg" required>
                    </div>

                    <div>
                        <label for="car" class="block text-gray-700 font-semibold mb-1">車種</label>
                        <input type="text" name="car" id="car" value="{{ old('car', $quote->car) }}" class="w-full px-4 py-2 border rounded-lg" required>
                    </div>

                    <div>
                        <label for="price" class="block text-gray-700 font-semibold mb-1">価格</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $quote->price) }}" class="w-full px-4 py-2 border rounded-lg" required oninput="calculateTotal()">
                    </div>

                    <div>
                        <label for="tax" class="block text-gray-700 font-semibold mb-1">消費税 (10%)</label>
                        <input type="number" name="tax" id="tax" value="{{ old('tax', $quote->tax) }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
                    </div>

                    <div>
                        <label for="total" class="block text-gray-700 font-semibold mb-1">合計金額</label>
                        <input type="number" name="total" id="total" value="{{ old('total', $quote->total) }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            更新
                        </button>
                        <a href="{{ route('quote.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            キャンセル
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

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

</x-app-layout>
