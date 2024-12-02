@extends('baby.layouts.app')

@section('content')


<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden mb-6">
  <div class="md:flex">
    <div class="md:flex-shrink-0">
      <img class="h-full w-full object-cover md:h-full md:w-full" src="../../babyincar.jpeg" alt="BabyInCar">
    </div>
    <div class="p-6">
      <h5 class="text-2xl font-bold mb-2">Baby In Carポータル</h5>
      <p class="text-gray-700 mb-4">子供が生まれたらマイカーに必ず貼りたい"子供が乗ってます"ステッカーのポータルサイトです。</p>
      <p class="text-sm text-gray-500"><a href="https://www.saisoncard.co.jp/topic/entry/babyonboard_2306/">そもそもBabyInCarステッカーが生まれた理由とは?</a></p>
    </div>
  </div>
</div>

@include('baby.commons.menu')

<div class="container mx-auto">
  <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">

    @foreach ($items as $item)
      <div class="break-inside-avoid bg-white shadow-lg rounded-lg overflow-hidden mb-6">
        <a href="{{ $item['itemUrl'] }}" class="block">
          <img class="w-full object-cover" src="{{ $item['mediumImageUrls'][0]['imageUrl'] }}" alt="Product Image">
          <div class="p-4">
            <p class="text-lg font-semibold text-pink-600">{{ $item['itemPrice'] }}円</p>
            <div class="flex items-center mt-2 text-gray-600">
              <i class="far fa-comments fa-lg"></i>
              <span class="ml-2">{{ $item['reviewCount'] }}件</span>
            </div>
          </div>
        </a>
      </div>
    @endforeach

  </div>
</div>





{{--検索BOX--}}
<form class="mt-6 flex justify-center" action="{{ route('baby.result') }}" method="GET">
  <input type="search" name="keyword" class="w-full max-w-md px-4 py-2 border rounded-l-lg" placeholder="キーワード">
  <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-r-lg">検索</button>
</form>

@endsection
