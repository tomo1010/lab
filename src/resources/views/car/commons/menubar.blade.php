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
    <div class="dropdown-divider"></div>

    {{-- ジャンル別分岐--}}
    @if($genre == 'minivan')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_size']) }}">サイズ</a>
    @endif

    <a class="dropdown-item" href="#">Separated link</a>
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
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'kg']) }}">発kg単価</a>

    {{-- ジャンル別分岐--}}
    @if($genre == 'minivan')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_size']) }}">サイズ</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_slidedoor']) }}">スライドドア※</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_3rd']) }}">３列目※</a>
    @endif

    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">Separated link</a>
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

    {{-- ジャンル別分岐--}}
    @if($genre == 'minivan')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_slidedoor']) }}">スライドドア※</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_3rd']) }}">３列目※</a>
    @endif

    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">Separated link</a>
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
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">Separated link</a>
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

    {{-- ジャンル別分岐--}}
    @if($genre == 'minivan')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形</a>
    @endif

    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">Separated link</a>
  </div>
</div>

<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    流行り
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'release']) }}">発売日</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'ridingcapacity']) }}">乗車人数</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'color']) }}">カラー</a>
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'WLTC']) }}">燃費</a>

    {{-- ジャンル別分岐--}}
    @if($genre == 'minivan')
    <a class="dropdown-item" href="{{ route('car.spec', ['genre'=>$genre,'year'=>$year,'spec'=>'minivan_style']) }}">形</a>
    @endif

    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">Separated link</a>
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
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">Separated link</a>
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
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">Separated link</a>
  </div>
</div>

</p>