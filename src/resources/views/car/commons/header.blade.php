{{-- ジャンル別ヘッダ分岐--}}

@if(Request::is('car/minivan*'))
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#2981C0;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://minivan.about-car.net/wp-content/uploads/tcd-w/logo.png"></a>

@elseif(Request::is('car/puchivan*'))
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#EF6C70;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/puchi/wp-content/uploads/tcd-w/logo.png"></a>

@elseif(Request::is('car/suv*'))
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#748300;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/suv/wp-content/uploads/tcd-w/logo.png"></a>

@elseif(Request::is('car/compact*'))
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#FFAD35;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/compact/wp-content/uploads/tcd-w/logo.png"></a>

@elseif(Request::is('car/sedan*'))
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#3E327B;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/sedan/wp-content/uploads/tcd-w/logo.png"></a>    

@elseif(Request::is('car/wagon*'))
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#90374E;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/wagon/wp-content/uploads/tcd-w/logo.png"></a>    

@elseif(Request::is('car/courpe*'))
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#FE4500;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/coupe/wp-content/uploads/tcd-w/logo.png?1710994445"></a>        

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
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">比較一覧</a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'minivan']) }}">ミニバン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'puchivan']) }}">プチバン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'suv']) }}">SUV</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'compact']) }}">コンパクトカー</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'sedan']) }}">セダン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'wagon']) }}">ステーションワゴン</a></li>
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