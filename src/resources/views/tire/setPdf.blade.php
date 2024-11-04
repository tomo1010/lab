@extends('baby.layouts.app')

@section('content')


<div class="container">
  <div class="row">
{{--   @foreach ($items as $item) --}}
      <div class="col-12 col-sm-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm">

        {{--<img class="card-img-top" src="{{ $item['mediumImageUrls'][0]['imageUrl'] }}" alt="Product Image">--}}

          <div class="card-body">
            <!-- フォームを追加 -->
            <form action="{{ route('tire.createPdf') }}" method="POST">
              @csrf
              <input type="hidden" name="itemName" value="{{ $itemName }}">
              <input type="hidden" name="itemPrice" value="{{ $itemPrice }}">
                {{--<input name="itemCode" type="checkbox" value="{{ $itemCode }}" >--}}
              <p class="h5 text-danger font-weight-bold">{{ $itemName }}</p>
              <div class="d-flex align-items-center mt-2 text-secondary">
                <span class="ml-2">{{ $itemPrice }}円</span>
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
