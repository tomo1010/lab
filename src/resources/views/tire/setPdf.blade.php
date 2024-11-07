<div class="container">
  <div class="row">
    <form action="{{ route('tire.createPdf') }}" method="POST">
      @csrf
      @foreach ($items as $index => $item)
        <div class="col-12 col-sm-6 col-lg-4 mb-4">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <!-- 商品情報の入力項目 -->
              <input type="hidden" name="items[{{ $index }}][itemName]" value="{{ $item['itemName'] }}">
              <input type="hidden" name="items[{{ $index }}][itemPrice]" value="{{ $item['itemPrice'] }}">

              <p class="h5 text-danger font-weight-bold">{{ $item['itemName'] }}</p>
              <div class="d-flex align-items-center mt-2 text-secondary">
                <span class="ml-2">{{ $item['itemPrice'] }}円</span>
              </div>

              <!-- 粗利を選択するセレクトボックス -->
              <div class="mt-3">
                <label for="itemOption_{{ $index }}" class="form-label">粗利を選択:</label>
                <select name="items[{{ $index }}][itemOption]" id="itemOption_{{ $index }}" class="form-control" 
                        onchange="calculateItemTotal({{ $index }}, {{ $item['itemPrice'] }})">
                  <option value="0">選択してください</option>
                  <option value="10000">10,000円</option>
                  <option value="15000">15,000円</option>
                  <option value="20000">20,000円</option>
                </select>
              </div>

              <!-- 商品ごとの合計表示 -->
              <div class="mt-3">
                <p class="h5">合計: <span id="totalPrice_{{ $index }}">0</span>円</p>
              </div>
            </div>
          </div>
        </div>
      @endforeach
      <button type="submit" class="btn btn-primary mt-2">PDFに送信</button>
    </form>
  </div>
</div>

<script>
  // セレクトボックスで粗利オプションが選択されたときに、合計を計算し表示する関数
  function calculateItemTotal(index, itemPrice) {
    const selectedOption = parseInt(document.getElementById(`itemOption_${index}`).value);

    // itemPriceと選択された粗利オプションの合計を計算
    const total = itemPrice + selectedOption;

    // 計算結果を対応する合計欄に表示
    document.getElementById(`totalPrice_${index}`).innerText = total;
  }
</script>
