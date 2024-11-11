
<form action="{{ route('tire.indexPdf') }}" method="POST">
    <!-- 送信ボタン -->
    <button type="submit">検索結果へ</button>
    @csrf
        <label for="sizeA">サイズを選択:</label>
        <select name="sizeA" id="sizeA">
          <option value="0">選択してください</option>
          <option value="195/">195</option>
          <option value="200/">200</option>
          <option value="205/">205</option>
        </select>

        <label for="sizeB">サイズを選択:</label>
        <select name="sizeB" id="sizeB">
          <option value="0">選択してください</option>
          <option value="55/">55</option>
          <option value="65/">65</option>
          <option value="70/">70</option>
        </select>

        <label for="sizeC">サイズを選択:</label>
        <select name="sizeC" id="sizeC">
          <option value="0">選択してください</option>
          <option value="R14">14</option>
          <option value="R15">15</option>
          <option value="R16">16</option>
        </select>

</form>


<div>
  <form action="{{ route('tire.setPdf') }}" method="POST">
    <!-- 送信ボタン -->
    <button type="submit">設定画面へ</button>

    @csrf
    <div>
      @foreach ($items as $item)
        <div>
          <div>
            <a href="{{ $item['itemUrl'] }}">
              <img src="{{ $item['mediumImageUrls'][0]['imageUrl'] }}" alt="Product Image">
            </a>
            <div>
              <!-- チェックボックス -->
              <input type="checkbox" name="itemCodes[]" value="{{ $item['itemCode'] }}" class="limit-checkbox">
              <p>{{ $item['itemPrice'] }}円</p>
              <div>
                <span>{{ $item['reviewCount'] }}件</span>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.limit-checkbox');
    
    // チェックボックスの制限をチェックする関数
    function updateCheckboxState() {
      const checkedBoxes = document.querySelectorAll('.limit-checkbox:checked');
      const isMaxSelected = checkedBoxes.length >= 3;

      checkboxes.forEach(checkbox => {
        if (!checkbox.checked) {
          checkbox.disabled = isMaxSelected;
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
