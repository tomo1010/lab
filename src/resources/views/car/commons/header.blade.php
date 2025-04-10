{{-- ジャンル別ヘッダ分岐--}}

@php
$genreStyles = [
'minivan' => ['#2981C0', 'https://minivan.about-car.net/wp-content/uploads/tcd-w/logo.png'],
'puchivan' => ['#EF6C70', 'https://about-car.net/puchi/wp-content/uploads/tcd-w/logo.png'],
'suv' => ['#748300', 'https://about-car.net/suv/wp-content/uploads/tcd-w/logo.png'],
'hatchback' => ['#FFAD35', 'https://about-car.net/compact/wp-content/uploads/tcd-w/logo.png'],
'sedan' => ['#3E327B', 'https://about-car.net/sedan/wp-content/uploads/tcd-w/logo.png'],
'wagon' => ['#90374E', 'https://about-car.net/wagon/wp-content/uploads/tcd-w/logo.png'],
'sports' => ['#FE4500', 'https://about-car.net/coupe/wp-content/uploads/tcd-w/logo.png?1710994445'],
'kei' => ['#E8C605', null], // ロゴなし
];

$safeGenre = $genre ?? '';
$bgColor = $genreStyles[$safeGenre][0] ?? '#f5f5f5';
$logoUrl = $genreStyles[$safeGenre][1] ?? null;
@endphp

@if(array_key_exists($safeGenre, $genreStyles))
@include('car.commons.subtitle')
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


        @empty($genre)

        @else
        @unless(Request::is('car/detail*'))
        {{-- 一覧へのリンク--}}

        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">大きさ</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'size']) }}">車体の大きさ</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tred']) }}">トレッド</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'indoorsize']) }}">室内の大きさ</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'displacement']) }}">排気量</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tiresize_front']) }}">タイヤサイズ</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'turningradius']) }}">小回り</a>
                @if($genre == 'minivan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_size']) }}">サイズ</a>
                @elseif($genre == 'puchivan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'puchivan_doorsize']) }}">開口部（スライドドアの大きさ）</a>
                @elseif($genre == 'suv')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'suv_size']) }}">サイズ</a>
                @elseif($genre == 'hatchback')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'hatchback_size']) }}">サイズ</a>
                @elseif($genre == 'wagon')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_size']) }}">サイズ</a>
                @elseif($genre == 'sedan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sedan_size']) }}">サイズ</a>
                @elseif($genre == 'sports')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sports_size']) }}">サイズ</a>
                @endif
            </div>
        </li>

        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">選ぶ楽しみ</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'name']) }}">車名</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'maker']) }}">メーカー</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'release']) }}">発売日</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'color']) }}">カラー</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'fueltank']) }}">燃料タンク容量</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'kg']) }}">kg単価</a>
                @if($genre == 'minivan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_slidedoor']) }}">スライドドア</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_3rd']) }}">３列目</a>
                @elseif($genre == 'suv')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'suv_style']) }}">形</a>
                @elseif($genre == 'hatchback')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'hatchback_style']) }}">形</a>
                @elseif($genre == 'sedan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'drive']) }}">駆動方式</a>
                @elseif($genre == 'sports')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'drive']) }}">駆動方式</a>
                @endif
            </div>
        </li>

        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">使い勝手</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wheelbase']) }}">ホイールベース</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tred']) }}">トレッド</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'indoorsize']) }}">室内の広さ</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'groundclearance']) }}">乗り降りの高さ</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'fueltank']) }}">燃料タンク容量</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'turningradius']) }}">小廻り</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'cruising']) }}">航続距離</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'gap']) }}">車体は小さく室内は広く</a>
                @if($genre == 'minivan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_slidedoor']) }}">スライドドア</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_3rd']) }}">３列目</a>
                @elseif($genre == 'puchivan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'puchivan_doorsize']) }}">開口部（スライドドアの大きさ）</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a>
                @elseif($genre == 'hatchback')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'hatchback_style']) }}">形</a>
                @elseif($genre == 'sedan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sedan_size']) }}">サイズ</a>
                @elseif($genre == 'wagon')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_size']) }}">サイズ</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_luggage']) }}">荷室サイズ</a>
                @elseif($genre == 'sports')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sports_size']) }}">サイズ</a>
                @endif
            </div>
        </li>

        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">パワー</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'weight']) }}">重さ</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'displacement']) }}">排気量</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ps']) }}">馬力</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'torque']) }}">トルク</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">絶対条件</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'name']) }}">車名</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'maker']) }}">メーカー</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'price']) }}">価格</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'size']) }}">車体の大きさ</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'groundclearance']) }}">乗り降りの高さ</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'cruising']) }}">航続距離</a>
                @if($genre == 'minivan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形</a>
                @elseif($genre == 'puchivan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'puchivan_doorsize']) }}">開口部（スライドドアの大きさ）</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a>
                @elseif($genre == 'suv')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'style']) }}">形</a>
                @elseif($genre == 'hatchback')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'hatchback_style']) }}">形</a>
                @elseif($genre == 'wagon')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_luggage']) }}">荷室サイズ</a>
                @elseif($genre == 'sedan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sedan_size']) }}">サイズ</a>
                @endif
            </div>
        </li>

        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">流行り</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'release']) }}">発売日</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'color']) }}">カラー</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'WLTC']) }}">燃費</a>
                @if($genre == 'minivan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形</a>
                @elseif($genre == 'hatchback')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'hatchback_style']) }}">形</a>
                @elseif($genre == 'sedan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sedan_size']) }}">サイズ</a>
                @endif
            </div>
        </li>

        <li class="nav-item dropdown">
            <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">維持費</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'price']) }}">価格</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jtax']) }}">重量税</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'WLTC']) }}">燃費</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tax']) }}">自動車税</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tiresize_front']) }}">タイヤサイズ</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'overhead']) }}">車検諸費用</a>
                @if($genre == 'puchivan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険</a>
                @elseif($genre == 'suv')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険</a>
                @elseif($genre == 'sports')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険</a>
                @endif
            </div>
        </li>
        <li class="nav-item dropdown">
            <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">お金</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'price']) }}">価格</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jtax']) }}">重量税</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tax']) }}">自動車税</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'kg']) }}">kg単価</a>
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'overhead']) }}">車検時諸費用</a>
                @if($genre == 'puchivan')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険</a>
                @elseif($genre == 'suv')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険</a>
                @elseif($genre == 'sports')
                <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険</a>
                @endif
            </div>
        </li>


        @endunless

        @endempty