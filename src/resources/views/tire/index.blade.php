@extends('tire.layouts.app')

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
                <!-- チェックボックス -->
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
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.limit-checkbox');
    
    // チェックボックスの制限をチェックする関数
    function updateCheckboxState() {
      const checkedBoxes = document.querySelectorAll('.limit-checkbox:checked');
      const isMaxSelected = checkedBoxes.length >= 3;

      checkboxes.forEach(checkbox => {
        // すでに選択されたものを除き、最大数に達したら無効化する
        if (!checkbox.checked) {
          checkbox.disabled = isMaxSelected;
          checkbox.classList.toggle('disabled-checkbox', isMaxSelected); // 無効時のスタイル適用
        }
      });
    }

    // チェックボックスの状態が変わった時に関数を呼び出す
    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', updateCheckboxState);
    });

    // 初回実行（ページ読み込み時）
    updateCheckboxState();
  });
</script>

<style>
  /* 無効化されているチェックボックスのスタイル */
  .disabled-checkbox {
    opacity: 0.5;
    cursor: not-allowed;
  }
</style>

@endsection
