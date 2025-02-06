<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投稿一覧
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
                    <form action="{{ route('quotes.store') }}" method="POST" class="mb-6">
                        @csrf
                        <div class="mb-4">
                            <label for="content" class="block text-gray-700 font-semibold mb-1">投稿内容</label>
                            <input type="text" name="content" id="content" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            投稿
                        </button>
                    </form>

                    <!-- 投稿一覧 -->
                    @if(isset($quotes) && $quotes->count())
                    <ul class="mt-6 space-y-4">
                        @foreach ($quotes as $quote)
                            <li class="p-4 bg-gray-100 rounded-lg flex justify-between items-center">
                                <span>{{ $quote->content }}</span>
                                <div class="flex flex-col space-y-2 w-28">
                                    <!-- 編集 -->
                                    <form action="{{ route('quotes.edit', $quote->id) }}" method="GET">
                                        <button type="submit" class="w-full bg-yellow-400 text-white px-4 py-2 rounded-lg hover:bg-yellow-500">
                                            編集
                                        </button>
                                    </form>

                                    <!-- コピー -->
                                    <form action="{{ route('quotes.copy', $quote->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500">
                                            コピー
                                        </button>
                                    </form>

                                    <!-- 削除 -->
                                    <form action="{{ route('quotes.destroy', $quote->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600" onclick="return confirm('本当に削除しますか？');">
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
