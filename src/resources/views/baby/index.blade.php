@extends('baby.layouts.app')

@section('content')

<div class="card mb-3" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="../../babyincar.jpeg" class="img-fluid rounded-start" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">車用BabyInCarを紹介するサイト</h5>
        <p class="card-text">子供が生まれたらマイカーに必ず貼りたい"子供が乗ってます"ステッカーのポータルサイトです。</p>
        <p class="card-text"><small class="text-body-secondary">そもそもBabyInCarステッカーが生まれた理由とは?</small></p>
      </div>
    </div>
  </div>
</div>

@include('baby.commons.menu')

<div class="container">
  <div class="row">

    @foreach ($items as $item)

      <div class="col-xl-4">
          <a href="{{ $item['itemUrl'] }}" class="thumbnail">
            <img src="{{ $item['mediumImageUrls'][0]['imageUrl'] }}" align="left" hspace="20" vspace="20"></br>
            {{ $item['itemPrice'] }}円</br>
            <i class="far fa-comments fa-lg"></i>{{ $item['reviewCount'] }}件
          </a>
      </div>

    @endforeach

  </div>
</div>



{{--検索BOX--}}
<form class="input-group col-md-5" action="{{ route('baby.result')}}" method="GET"> 
  <input type="search" name="keyword" class="form-control input-group-prepend" placeholder="キーワード"></input>
  <span class="input-group-btn input-group-append">
    <input type="submit" class="btn btn-primary"  value="検索">
  </span>
</form>

@endsection