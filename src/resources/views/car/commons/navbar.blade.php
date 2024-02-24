    {{-- ジャンル別ヘッダ分岐--}}
    @if(Request::is('car/minivan*'))
        @include('car.minivan.title')
    @elseif(Request::is('car/suv*'))
        @include('car.suv.title')
    @else
        @include('car.commons.title')
    @endif

        {{-- ハンバーガーメニュー --}}
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- メニュー項目 --}}
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                
                {{-- 一覧へのリンク--}}                
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">その他のジャンル一覧</a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item"><a href="{{ route('car.category', ['genre'=>'minivan']) }}">ミニバン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.category', ['genre'=>'suv']) }}">SUV</a></li>
                        <li class="dropdown-divider"></li>
                    </ul>
                </li>


        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                {{-- ユーザ登録ページへのリンク --}}
                <li class="nav-item"><a href="#" class="nav-link">サインアップ</a></li>
                {{-- ログインページへのリンク --}}
                <li class="nav-item"><a href="#" class="nav-link">ログイン</a></li>
            </ul>
        </div>
    </nav>
</header>