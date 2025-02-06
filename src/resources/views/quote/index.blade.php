<div class="container">
    <h2>投稿一覧</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @auth
        <form action="{{ route('quotes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="content" class="form-label">投稿内容</label>
                <input type="text" name="content" id="content" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">投稿</button>
        </form>

        @if(isset($quotes) && $quotes->count())
            <ul class="list-group mt-4">
                @foreach ($quotes as $quote)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $quote->content }}
                        <div>
                            <a href="{{ route('quotes.edit', $quote->id) }}" class="btn btn-sm btn-warning">編集</a>
                            
                            <!-- コピー機能 -->
                            <form action="{{ route('quotes.copy', $quote->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info">コピー</button>
                            </form>

                            <form action="{{ route('quotes.destroy', $quote->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('本当に削除しますか？');">削除</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-3">
                {{ $quotes->links() }}
            </div>
        @else
            <p class="mt-3">投稿はありません。</p>
        @endif
    @else
        <p class="text-center mt-4">投稿を見るにはログインしてください。</p>
        <div class="text-center">
            <a href="{{ route('login') }}" class="btn btn-primary">ログイン</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">新規登録</a>
        </div>
    @endauth
</div>
