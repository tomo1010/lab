@extends('baby.layouts.app')

@section('content')


<div class="container">
  <div class="row">
  <form action="{{ route('tire.setPdf') }}" method="POST">
  @csrf
  <div class="row">
    @foreach ($items as $item)
      <div class="col-12 col-sm-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm">
          <a href="{{ $item['itemUrl'] }}" class="text-decoration-none">
            <img class="card-img-top" src="{{ $item['mediumImageUrls'][0]['imageUrl'] }}" alt="Product Image">
          </a>
          <div class="card-body">
            <!-- チェックボックスを追加 -->
            <input type="checkbox" name="itemCodes[]" value="{{ $item['itemCode'] }}" class="limit-checkbox">
            <p class="h5 text-danger font-weight-bold">{{ $item['itemPrice'] }}円</p>
            <div class="d-flex align-items-center mt-2 text-secondary">
              <i class="far fa-comments fa-lg"></i>
              <span class="ml-2">{{ $item['reviewCount'] }}件</span>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- 送信ボタン -->
  <button type="submit" class="btn btn-primary mt-3">設定画面へ</button>
</form>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.limit-checkbox');
    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        const checkedBoxes = document.querySelectorAll('.limit-checkbox:checked');
        if (checkedBoxes.length > 3) {
          this.checked = false;
          alert('3つまでしか選択できません。');
        }
      });
    });
  });
</script>

  </div>
</div>








@endsection
