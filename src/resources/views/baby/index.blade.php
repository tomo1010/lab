@extends('baby.layouts.app')

@section('content')

{{--検索BOX--}}
<form class="input-group col-md-5" action="{{ route('baby.result')}}" method="GET"> 
  <input type="search" name="keyword" class="form-control input-group-prepend" placeholder="キーワード"></input>
  <span class="input-group-btn input-group-append">
    <input type="submit" class="btn btn-primary"  value="検索">
  </span>
</form>

@include('baby.commons.menu')

<div class="container">
  <div class="row">

    @foreach ($items as $item)

      <div class="col-xl-4">
          <a href="{{ $item['itemUrl'] }}" class="thumbnail">
            <img src="{{ $item['mediumImageUrls'][0]['imageUrl'] }}" align="left" hspace="20" vspace="20">
            {{ $item['itemPrice'] }}円</br>
            {{ $item['reviewCount'] }}件
          </a>
      </div>

    @endforeach

  </div>
</div>

@endsection