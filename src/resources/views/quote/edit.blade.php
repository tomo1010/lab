<div class="container">
    <h2>投稿を編集</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('quotes.update', $quote->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="content" class="form-label">投稿内容</label>
            <input type="text" name="content" id="content" class="form-control" value="{{ old('content', $quote->content) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
        <a href="{{ route('quote.index') }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
