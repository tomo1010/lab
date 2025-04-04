<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ラベル印刷
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
                <form id="lavelForm" action="{{ route('lavels.store') }}" method="POST" class="mb-6">
                    @csrf


                    <h3 class="text-xl font-bold text-gray-800 border-b-2 border-gray-400 pb-2 mb-4">宛名</h3>

                    <!-- 宛名情報 -->
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
                    </div>


                    <!-- ボタンエリア（保存 & PDFボタンを横並び） -->
                    <div class="flex space-x-2">
                        <!-- 保存ボタン -->
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            保存
                        </button>

                        <!-- PDFボタン (保存も実行) -->
                        <form action="{{ route('labels.createPdf') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                PDF
                            </button>
                        </form>
                    </div>


                </form>


            </div>
        </div>



        <!-- ログイン済みユーザーのみ表示 -->
        <!--@auth-->
        <!-- ラベル一覧 -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">ラベル一覧</h2>
                @if(isset($lavels) && $lavels->count())
                <ul class="mt-6 space-y-4">
                    @foreach ($lavels as $lavel)
                    <li class="p-4 bg-gray-100 rounded-lg flex justify-between items-center">
                        <!-- 名前・車名・更新日時 -->
                        <div>
                            <span class="text-lg font-semibold">
                                {{ $lavel->car }} {{ $lavel->color }} {{ $displayMan }}万円
                            </span>
                            <p class="text-sm text-gray-500">更新日時: {{ $lavel->updated_at->format('Y-m-d H:i') }}</p>
                        </div>

                        <!-- 編集・コピー・削除ボタン（横並び） -->
                        <div class="flex space-x-2">
                            <!-- 編集 -->
                            <form action="{{ route('lavels.edit', $lavel->id) }}" method="GET">
                                <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded-lg hover:bg-yellow-500 flex items-center space-x-2" title="編集">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>

                            <!-- コピー -->
                            <form action="{{ route('lavels.copy', $lavel->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500 flex items-center space-x-2" title="コピー">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </form>

                            <!-- 削除 -->
                            <form action="{{ route('lavels.destroy', $lavel->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 flex items-center space-x-2" title="削除" onclick="return confirm('本当に削除しますか？');">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>

                    </li>
                    @endforeach
                </ul>



                <!-- ページネーション -->
                <div class="mt-6">
                    {{ $lavels->links() }}
                </div>
                @else
                <p class="mt-6 text-gray-500">ラベルはありません。</p>
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





</x-app-layout>