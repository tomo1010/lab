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
        <input type="hidden" name="itemPrice" value="{{ $itemPrice }}">

        {{--<input name="itemCode" type="checkbox" value="{{ $itemCode }}" >--}}
        <p class="h5 text-danger font-weight-bold">{{ $itemName }}</p>

        <div class="d-flex align-items-center mt-2 text-secondary">
            <span class="ml-2">{{ $itemPrice }}円</span>
        </div>

        <!-- 合計表示 -->
        <div class="mt-3">
            <p class="h5">合計: <span id="totalPrice">{{ $sumPrice }}</span>円</p>
        </div>

        <button type="submit" class="btn btn-primary mt-2">PDFに送信</button>
    </form>
</div>

<script>
    // JavaScriptで合計を計算して表示する関数
    function calculateTotal() {
        // 元の価格を取得
        const itemPrice = parseInt({{ $itemPrice }});
        
        // 選択された粗利の値を取得
        const itemOption = document.getElementById("itemOption");
        const selectedOption = parseInt(itemOption.value);

        // 合計計算
        const total = itemPrice + selectedOption;

        // 合計を表示
        document.getElementById("totalPrice").innerText = total;
    }
</script>

        
        </div>
      </div>
      {{--@endforeach --}}
  </div>
</div>








@endsection
