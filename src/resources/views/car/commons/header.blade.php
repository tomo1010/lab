{{-- ジャンル別ヘッダ分岐--}}

@if(Request::is('car/minivan*'))
    @include('car.commons.subtitle')
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#2981C0;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://minivan.about-car.net/wp-content/uploads/tcd-w/logo.png"></a>

@elseif(Request::is('car/puchivan*'))
@include('car.commons.subtitle')
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#EF6C70;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/puchi/wp-content/uploads/tcd-w/logo.png"></a>

@elseif(Request::is('car/suv*'))
    @include('car.commons.subtitle')    
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#748300;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/suv/wp-content/uploads/tcd-w/logo.png"></a>

@elseif(Request::is('car/hatchback*'))
    @include('car.commons.subtitle')
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#FFAD35;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/compact/wp-content/uploads/tcd-w/logo.png"></a>

@elseif(Request::is('car/sedan*'))
    @include('car.commons.subtitle')
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#3E327B;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/sedan/wp-content/uploads/tcd-w/logo.png"></a>    

@elseif(Request::is('car/wagon*'))
    @include('car.commons.subtitle')
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#90374E;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/wagon/wp-content/uploads/tcd-w/logo.png"></a>    

@elseif(Request::is('car/sports*'))
    @include('car.commons.subtitle')
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#FE4500;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/coupe/wp-content/uploads/tcd-w/logo.png?1710994445"></a>        

@elseif(Request::is('car/kei*'))    
    @include('car.commons.subtitle')
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#E8C605;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}">軽自動車比較サイト</a>
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
                
            @unless(Request::is('car/detail*'))
                {{-- 一覧へのリンク--}}                
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">比較一覧</a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'size']) }}">車体の大きさ</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tred']) }}">トレッド</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'indoorsize']) }}">室内の広さ</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'displacement']) }}">排気量</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tiresize_front']) }}">タイヤサイズ</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'turningradius']) }}">小廻り</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'name']) }}">車名</a></li>
                        <li class="dropdown-divider"></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'maker']) }}">メーカー</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'release']) }}">発売日</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'color']) }}">カラー</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'fueltank']) }}">燃料タンク容量</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'kg']) }}">発kg単価</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wheelbase']) }}">ホイールベース</a></li>
                        <li class="dropdown-divider"></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'indoorsize']) }}">室内の広さ</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'groundclearance']) }}">乗り降りの高さ</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'weight']) }}">重さ</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ps']) }}">馬力</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'torque']) }}">トルク</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'price']) }}">価格</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'color']) }}">カラー</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'WLTC']) }}">燃費</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jtax']) }}">重量税</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tax']) }}">自動車税</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tiresize_front']) }}">タイヤサイズ</a></li>
                        <li class="dropdown-divider"></li>
                        @if($genre == 'minivan')
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_size']) }}">サイズ</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_slidedoor']) }}">スライドドア</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_3rd']) }}">３列目</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形</a></li>
                        <li class="dropdown-divider"></li>
                        @endif
                    </ul>
                </li>
            @endunless