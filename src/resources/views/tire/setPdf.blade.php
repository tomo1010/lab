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

              <!-- 粗利を選択するセレクトボックスA -->
              <div class="mt-3">
                <label for="itemOptionA_{{ $index }}" class="form-label">粗利を選択:</label>
                <select name="items[{{ $index }}][itemOptionA]" id="itemOptionA_{{ $index }}" class="form-control" 
                        onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
                  <option value="0">選択してください</option>
                  <option value="10000">10,000円</option>
                  <option value="15000">15,000円</option>
                  <option value="20000">20,000円</option>
                </select>
              </div>

              <!-- 粗利を選択するセレクトボックスB -->
              <div class="mt-3">
                <label for="itemOptionB_{{ $index }}" class="form-label">粗利を選択:</label>
                <select name="items[{{ $index }}][itemOptionB]" id="itemOptionB_{{ $index }}" class="form-control" 
                        onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
                  <option value="0">選択してください</option>
                  <option value="1.1">×1.1</option>
                  <option value="1.2">×1.2</option>
                  <option value="1.3">×1.3</option>
                </select>
              </div>
              
              <hr>

              <!-- 工賃を入力するテキストボックスと倍率のセレクトボックス -->
              <div class="mt-3">
                <label for="wages_{{ $index }}" class="form-label">工賃を入力:</label>
                <input type="number" name="items[{{ $index }}][wages]" id="wages_{{ $index }}" class="form-control" 
                       onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})" placeholder="0">

                <label for="wagesMultiplier_{{ $index }}" class="form-label mt-2">工賃の倍率を選択:</label>
                <select name="items[{{ $index }}][wagesMultiplier]" id="wagesMultiplier_{{ $index }}" class="form-control"
                        onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
                  <option value="1">選択してください</option>
                  <option value="1">×1</option>
                  <option value="2">×2</option>
                  <option value="3">×3</option>
                  <option value="4">×4</option>
                </select>
              </div>

              <hr>

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
  function toggleAndCalculate(index, itemPrice) {
    const optionA = document.getElementById(`itemOptionA_${index}`);
    const optionB = document.getElementById(`itemOptionB_${index}`);
    const wages = parseInt(document.getElementById(`wages_${index}`).value) || 0;
    const wagesMultiplier = parseInt(document.getElementById(`wagesMultiplier_${index}`).value) || 1;

    let total = itemPrice; // 初期価格を合計のベースに設定

    // Option A が選択されている場合、その値を合計に加算
    if (optionA.value !== "0") {
      total += parseInt(optionA.value);
      optionB.disabled = true; // Option Aが選択された場合はOption Bを無効化
      optionB.classList.add('disabled-select');
    } else {
      optionB.disabled = false;
      optionB.classList.remove('disabled-select');
    }

    // Option B が選択されている場合、その倍率を適用
    if (optionB.value !== "0") {
      total = Math.floor(total * parseFloat(optionB.value)); // Option Bの倍率で計算
      optionA.disabled = true; // Option Bが選択された場合はOption Aを無効化
      optionA.classList.add('disabled-select');
    } else {
      optionA.disabled = false;
      optionA.classList.remove('disabled-select');
    }

    // 工賃に倍率を掛けて合計に加算
    const adjustedWages = wages * wagesMultiplier;
    total += adjustedWages;

    // 計算結果を表示
    document.getElementById(`totalPrice_${index}`).innerText = total;
  }
</script>

<style>
  /* 無効化されているセレクトボックスのスタイル */
  .disabled-select {
    opacity: 0.5;
    cursor: not-allowed;
  }
</style>
