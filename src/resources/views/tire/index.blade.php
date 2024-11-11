<form action="{{ route('tire.indexPdf') }}" method="POST">
    <!-- 送信ボタン -->
    <button type="submit">検索結果へ</button>
    @csrf
        <label for="sizeA">サイズを選択:</label>
        <select name="sizeA" id="sizeA" onchange="toggleSizeFields()">
          <option value="0">選択してください</option>
          <option value="195/">195</option>
          <option value="200/">200</option>
          <option value="205/">205</option>
        </select>

        <label for="sizeB">サイズを選択:</label>
        <select name="sizeB" id="sizeB" onchange="toggleSizeFields()">
          <option value="0">選択してください</option>
          <option value="55/">55</option>
          <option value="65/">65</option>
          <option value="70/">70</option>
        </select>

        <label for="sizeC">サイズを選択:</label>
        <select name="sizeC" id="sizeC" onchange="toggleSizeFields()">
          <option value="0">選択してください</option>
          <option value="R14">14</option>
          <option value="R15">15</option>
          <option value="R16">16</option>
        </select>

        <label for="sizeFree">サイズを選択:</label>
        <select name="sizeFree" id="sizeFree" onchange="toggleSizeFields()">
          <option value="0">汎用サイズ</option>
          <option value="155/65R14">155/65R14</option>
          <option value="195/65R15">195/65R15</option>
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
  function toggleSizeFields() {
    const sizeA = document.getElementById('sizeA');
    const sizeB = document.getElementById('sizeB');
    const sizeC = document.getElementById('sizeC');
    const sizeFree = document.getElementById('sizeFree');

    const isSizeSelected = sizeA.value !== "0" || sizeB.value !== "0" || sizeC.value !== "0";
    const isSizeFreeSelected = sizeFree.value !== "0";

    // sizeFreeが選択された場合はsizeA, sizeB, sizeCを無効化
    sizeA.disabled = isSizeFreeSelected;
    sizeB.disabled = isSizeFreeSelected;
    sizeC.disabled = isSizeFreeSelected;

    // sizeA, sizeB, sizeCが選択された場合はsizeFreeを無効化
    sizeFree.disabled = isSizeSelected;
  }
</script>
