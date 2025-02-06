@if (count($quotes) > 0)
    <ul class="list-unstyled">
        @foreach ($quotes as $quote)
            <li class="media mb-3">
                <div class="media-body">
                    <div>
                        {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                        {!! link_to_route('users.show', $quote->user->name, ['user' => $quote->user->id]) !!}
                        <span class="text-muted">posted at {{ $quote->created_at }}</span>
                    </div>
                    <div>
                        {{-- 投稿内容 --}}
                        <p class="mb-0">{!! nl2br(e($quote->content)) !!}</p>
                    </div>
                    <div>
                        @if (Auth::id() == $quote->user_id)
                            {{-- 投稿削除ボタンのフォーム --}}
                            {!! Form::open(['route' => ['quotes.destroy', $quote->id], 'method' => 'delete']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $quotes->links() }}
@endif