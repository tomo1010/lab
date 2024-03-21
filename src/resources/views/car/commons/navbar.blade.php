<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">

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
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">その他のジャンル</a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'minivan']) }}">ミニバン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'puchivan']) }}">プチバン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'suv']) }}">SUV</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'compact']) }}">コンパクトカー</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'wagon']) }}">ステーションワゴン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'seda']) }}">セダン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'courpe']) }}">クーペ</a></li>
                        <li class="dropdown-divider"></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei']) }}">軽自動車</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei']) }}">軽ハイトワゴン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei']) }}">軽スライドドア</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei']) }}">軽セダン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei']) }}">軽トラック</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei']) }}">軽バン</a></li>
                        <li class="dropdown-divider"></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'longseler']) }}">ロングセラー</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'longseler']) }}">3列シートSUV</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'longseler']) }}">新車から3年落ち</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'longseler']) }}">新車から5年落ち</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'longseler']) }}">新車から7年落ち</a></li>
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

    @include('car.commons.header')

</header>

