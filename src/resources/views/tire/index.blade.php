@extends('baby.layouts.app')

@section('content')


<div class="container">
  <div class="row">
    @foreach ($items as $item)
      <div class="col-12 col-sm-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ $item['itemUrl'] }}" class="text-decoration-none">
            <img class="card-img-top" src="{{ $item['mediumImageUrls'][0]['imageUrl'] }}" alt="Product Image">
          </a>
          <div class="card-body">
            <!-- フォームを追加 -->
            <form action="{{ route('tire.setPdf') }}" method="POST">
              @csrf
              <input type="hidden" name="itemCode" value="{{ $item['itemCode'] }}">
              <input name="itemCode" type="checkbox" value="{{ $item['itemCode'] }}" >
              <p class="h5 text-danger font-weight-bold">{{ $item['itemPrice'] }}円</p>
              <div class="d-flex align-items-center mt-2 text-secondary">
                <i class="far fa-comments fa-lg"></i>
                <span class="ml-2">{{ $item['reviewCount'] }}件</span>
              </div>
              <button type="submit" class="btn btn-primary mt-2">設定画面へ</button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>








@endsection
