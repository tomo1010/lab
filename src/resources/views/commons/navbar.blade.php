<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        {{-- トップページへのリンク --}}
        <a class="navbar-brand" href="/">車スペック</a>

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
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">一覧</a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item"><a href="{{ route('car.minivan') }}">ミニバン</a></li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><a href="{{ route('car.suv') }}">SUV</a></li>
                            <li class="dropdown-divider"></li>
                        </ul>
                </li>


        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                {{-- ユーザ登録ページへのリンク --}}
                <li class="nav-item"><a href="#" class="nav-link">Signup</a></li>
                {{-- ログインページへのリンク --}}
                <li class="nav-item"><a href="#" class="nav-link">Login</a></li>
            </ul>
        </div>
    </nav>
</header>