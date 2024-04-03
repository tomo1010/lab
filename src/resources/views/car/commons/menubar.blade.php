<p>
  
<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    大きさ
  </button>
  <div class="dropdown-menu">
  <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'size']) }}">車体の大きさ</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tred']) }}">トレッド</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'indoorsize']) }}">室内の広さ</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'displacement']) }}">排気量</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tiresize_front']) }}">タイヤサイズ</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'turningradius']) }}">小廻り</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'gap']) }}">車体は小さく室内は広く</a>


    {{-- サイズ分岐--}}
    @if($genre == 'minivan')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_size']) }}">サイズ</a>
    @elseif($genre == 'suv')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'suv_size']) }}">サイズ</a>
    @elseif($genre == 'hatchback')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'hatchback_size']) }}">サイズ</a>
    @elseif($genre == 'wagon')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_size']) }}">サイズ</a>
    @elseif($genre == 'sedan')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sedan_size']) }}">サイズ</a>
    @elseif($genre == 'courpe')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'courpe_size']) }}">サイズ</a>
    @endif

    {{-- ジャンル別分岐--}}
    @if($genre == 'puchivan')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'puchivan_doorsize']) }}">開口部（スライドドアの大きさ）※</a>
    @endif

  </div>
</div>


<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    選ぶ楽しみ
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'name']) }}">車名</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'maker']) }}">メーカー</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'release']) }}">発売日</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'color']) }}">カラー</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'fueltank']) }}">燃料タンク容量</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'kg']) }}">kg単価</a>

    {{-- ジャンル別分岐--}}

    @if($genre == 'minivan')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形※</a>
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_slidedoor']) }}">スライドドア※</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_3rd']) }}">３列目※</a>
    @elseif($genre == 'suv')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'suv_style']) }}">形※</a>
    @elseif($genre == 'hatchback')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'compact_style']) }}">形※</a>
    @elseif($genre == 'sedan')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'drive']) }}">駆動方式※</a>
    @elseif($genre == 'courpe')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'drive']) }}">駆動方式※</a>
    @endif

  </div>
</div>

<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    使い勝手
  </button>
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

    {{-- ジャンル別分岐--}}

    @if($genre == 'minivan')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_slidedoor']) }}">スライドドア※</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_3rd']) }}">３列目※</a>
    @elseif($genre == 'puchivan')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'puchivan_doorsize']) }}">開口部（スライドドアの大きさ）※</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数※</a>
    @elseif($genre == 'compact')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'compact_style']) }}">形※</a>
    @elseif($genre == 'sedan')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sedan_size']) }}">サイズ※</a>
    @elseif($genre == 'wagon')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_size']) }}">サイズ※</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_luggage']) }}">荷室サイズ※</a>
    @elseif($genre == 'courpe')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'courpe_size']) }}">サイズ※</a>
    @endif

  </div>
</div>

<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    パワー
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'weight']) }}">重さ</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'displacement']) }}">排気量</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ps']) }}">馬力</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'torque']) }}">トルク</a>
  </div>
</div>

<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    絶対条件
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'name']) }}">車名</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'maker']) }}">メーカー</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'price']) }}">価格</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'size']) }}">車体の大きさ</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'groundclearance']) }}">乗り降りの高さ</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'cruising']) }}">航続距離</a>

    {{-- ジャンル別分岐--}}
    @if($genre == 'minivan')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形※</a>
    @elseif($genre == 'puchivan')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'puchivan_doorsize']) }}">開口部（スライドドアの大きさ）※</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数※</a>
    @elseif($genre == 'suv')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'suv_style']) }}">形※</a>
    @elseif($genre == 'compact')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'compact_style']) }}">形※</a>
    @elseif($genre == 'wagon')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_luggage']) }}">荷室サイズ※</a>
    @elseif($genre == 'courpe')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'wagon_size']) }}">サイズ※</a>
    @endif


  </div>
</div>

<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    流行り
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'release']) }}">発売日※</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数※</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'color']) }}">カラー※</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'WLTC']) }}">燃費※</a>

    {{-- ジャンル別分岐--}}
    @if($genre == 'minivan')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形※</a>
    @elseif($genre == 'compact')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'compact_style']) }}">形※</a>
    @elseif($genre == 'sedan')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'sedan_size']) }}">サイズ※</a>
    @endif

  </div>
</div>

<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    維持費
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'price']) }}">価格</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jtax']) }}">重量税</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'WLTC']) }}">燃費</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tax']) }}">自動車税</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tiresize_front']) }}">タイヤサイズ</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'overhead']) }}">車検諸費用</a>
    @if($genre == 'puchivan')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険※</a>
    @elseif($genre == 'suv')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険※</a>
    @elseif($genre == 'courpe')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険※</a>
    @endif
  </div>
</div>

<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    お金
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'price']) }}">価格</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jtax']) }}">重量税</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'tax']) }}">自動車税</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'kg']) }}">kg単価</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'overhead']) }}">車検諸費用</a>
    @if($genre == 'puchivan')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険※</a>
    @elseif($genre == 'suv')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険※</a>
    @elseif($genre == 'courpe')
    {{-- 仕切り線 --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'jibai']) }}">自賠責保険※</a>
    @endif
  </div>
</div>

</p>