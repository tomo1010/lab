{{-- ジャンル別フッタ分岐--}}

@if(Request::is('car/minivan*'))
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#2981C0;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://minivan.about-car.net/wp-content/uploads/tcd-w/logo.png"></a>

@elseif(Request::is('car/suv*'))
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#748300;">
    <a class="navbar-brand" href="{{ route('car.genre', ['genre'=>$genre]) }}"><img src="https://about-car.net/suv/wp-content/uploads/tcd-w/logo.png"></a></br>
    
@else
    @include('car.commons.title')
@endif 


<nav class="navbar  navbar-dark bg-white">


<div class="container">
    <div class="row">
        <!-- About Us -->
        <div class="col-md-3">

                        <p><h5>大きさ</h5></p>
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'size']) }}">車体の大きさ</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tred']) }}">トレッド</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'indoorsize']) }}">室内の大きさ</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'displacement']) }}">排気量</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tiresize_front']) }}">タイヤサイズ</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'turningradius']) }}">小回り</a>｜
                            @if($genre == 'minivan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_size']) }}">サイズ</a>｜
                            @elseif($genre == 'puchivan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'puchivan_doorsize']) }}">開口部（スライドドアの大きさ）</a>｜
                            @elseif($genre == 'suv')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'suv_size']) }}">サイズ</a>｜
                            @elseif($genre == 'hatchback')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'hatchback_size']) }}">サイズ</a>｜
                            @elseif($genre == 'wagon')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_size']) }}">サイズ</a>｜
                            @elseif($genre == 'sedan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sedan_size']) }}">サイズ</a>｜
                            @elseif($genre == 'sports')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sports_size']) }}">サイズ</a>｜
                            @endif
</div>
<div class="col-md-3">
                        <p><h5>選ぶ楽しみ</h5></p>
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'name']) }}">車名</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'maker']) }}">メーカー</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'release']) }}">発売日</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'color']) }}">カラー</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'fueltank']) }}">燃料タンク容量</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'kg']) }}">kg単価</a>｜
                            @if($genre == 'minivan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形</a>｜
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_slidedoor']) }}">スライドドア</a>｜
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_3rd']) }}">３列目</a>｜
                            @elseif($genre == 'suv')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'suv_style']) }}">形</a>｜
                            @elseif($genre == 'hatchback')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'hatchback_style']) }}">形</a>｜
                            @elseif($genre == 'sedan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'drive']) }}">駆動方式</a>｜
                            @elseif($genre == 'sports')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'drive']) }}">駆動方式</a>｜
                            @endif

                            </div>
<div class="col-md-3">
                    
                        <p><h5>使い勝手</h5></p>
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wheelbase']) }}">ホイールベース</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tred']) }}">トレッド</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'indoorsize']) }}">室内の広さ</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'groundclearance']) }}">乗り降りの高さ</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'fueltank']) }}">燃料タンク容量</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'turningradius']) }}">小廻り</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'cruising']) }}">航続距離</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'gap']) }}">車体は小さく室内は広く</a>｜
                            @if($genre == 'minivan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_slidedoor']) }}">スライドドア</a>｜
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_3rd']) }}">３列目</a>｜
                            @elseif($genre == 'puchivan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'puchivan_doorsize']) }}">開口部（スライドドアの大きさ）</a>｜
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a>｜
                            @elseif($genre == 'hatchback')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'hatchback_style']) }}">形</a>｜
                            @elseif($genre == 'sedan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sedan_size']) }}">サイズ</a>｜
                            @elseif($genre == 'wagon')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_size']) }}">サイズ</a>｜
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_luggage']) }}">荷室サイズ</a>｜
                            @elseif($genre == 'sports')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sports_size']) }}">サイズ</a>｜
                            @endif

                            </div>
<div class="col-md-3">
                    
                        <p><h5>パワー</h5></p>
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'weight']) }}">重さ</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'displacement']) }}">排気量</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ps']) }}">馬力</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'torque']) }}">トルク</a>｜

                    
                            </div>
                            </div>

                            <div class="row">      
<div class="col-md-3">
                        <p><h5>絶対条件</h5></p>
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'name']) }}">車名</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'maker']) }}">メーカー</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'price']) }}">価格</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'size']) }}">車体の大きさ</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'groundclearance']) }}">乗り降りの高さ</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'cruising']) }}">航続距離</a>｜
                            @if($genre == 'minivan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形</a>｜
                            @elseif($genre == 'puchivan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'puchivan_doorsize']) }}">開口部（スライドドアの大きさ）</a>｜
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a>｜
                            @elseif($genre == 'suv')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'style']) }}">形</a>｜
                            @elseif($genre == 'hatchback')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'hatchback_style']) }}">形</a>｜
                            @elseif($genre == 'wagon')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_luggage']) }}">荷室サイズ</a>｜
                            @elseif($genre == 'sedan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sedan_size']) }}">サイズ</a>｜
                            @endif

                            </div>
<div class="col-md-3">

                        <p><h5>流行り</h5></p>
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'release']) }}">発売日</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'color']) }}">カラー</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'WLTC']) }}">燃費</a>｜
                            @if($genre == 'minivan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形</a>｜
                            @elseif($genre == 'hatchback')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'hatchback_style']) }}">形</a>｜
                            @elseif($genre == 'sedan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sedan_size']) }}">サイズ</a>｜
                            @endif

                            </div>
<div class="col-md-3">
                            
                        <p><h5>維持費</h5></p>
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'price']) }}">価格</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jtax']) }}">重量税</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'WLTC']) }}">燃費</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tax']) }}">自動車税</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tiresize_front']) }}">タイヤサイズ</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'overhead']) }}">車検諸費用</a>｜
                            @if($genre == 'puchivan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険</a>｜
                            @elseif($genre == 'suv')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険</a>｜
                            @elseif($genre == 'sports')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険</a>｜
                            @endif

                            </div>
<div class="col-md-3">

                        <p><h5>お金</h5></p>
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'price']) }}">価格</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jtax']) }}">重量税</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tax']) }}">自動車税</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'kg']) }}">kg単価</a>｜
                            <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'overhead']) }}">車検時諸費用</a>｜
                            @if($genre == 'puchivan')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険</a>｜
                            @elseif($genre == 'suv')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険</a>｜
                            @elseif($genre == 'sports')
                                <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険</a>｜
                            @endif

                            </div>
                            </div>
                            </div>

            <div class="row mt-3">
            <div class="col-md-12 text-center">
                <p>&copy; 2024 kurumayalabo.com All rights reserved.</p>
            </div>
        </div>
</nav>