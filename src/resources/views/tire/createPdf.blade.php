@extends('baby.layouts.app')

@section('content')


<div class="container">
  <div class="row">
{{--   @foreach ($items as $item) --}}
      <div class="col-12 col-sm-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm">

        {{--<img class="card-img-top" src="{{ $item['mediumImageUrls'][0]['imageUrl'] }}" alt="Product Image">--}}

        <div class="card-body">
    <form action="{{ route('tire.createPdf') }}" method="POST">
        @csrf
        <!-- セット項目 -->
        <input type="hidden" name="itemName" value="{{ $itemName }}">

        {{--<input name="itemCode" type="checkbox" value="{{ $itemCode }}" >--}}
        <p class="h5 text-danger font-weight-bold">{{ $itemName }}</p>


        <!-- 合計表示 -->
        <div class="mt-3">
            <p class="h5">合計: <span id="totalPrice">{{ $sumPrice }}</span>円</p>
        </div>

        <button type="submit" class="btn btn-primary mt-2">PDFに送信</button>
    </form>
</div>

        
        </div>
      </div>
      {{--@endforeach --}}
  </div>
</div>








@endsection
