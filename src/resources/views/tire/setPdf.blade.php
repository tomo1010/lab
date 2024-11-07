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

                <label for="wagesMultiplier_{{ $index }}" class="form-label mt-2">倍率を選択:</label>
                <select name="items[{{ $index }}][wagesMultiplier]" id="wagesMultiplier_{{ $index }}" class="form-control"
                        onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
                  <option value="1">選択してください</option>
                  <option value="1">×1</option>
                  <option value="2">×2</option>
                  <option value="3">×3</option>
                  <option value="4">×4</option>
                </select>
              </div>

              <!-- 廃棄タイヤを入力するテキストボックスと倍率のセレクトボックス -->
              <div class="mt-3">
                <label for="wasteTire_{{ $index }}" class="form-label">廃タイヤ費用を入力:</label>
                <input type="number" name="items[{{ $index }}][wasteTire]" id="wasteTire_{{ $index }}" class="form-control" 
                       onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})" placeholder="0">

                <label for="wasteTireMultiplier_{{ $index }}" class="form-label mt-2">倍率を選択:</label>
                <select name="items[{{ $index }}][wasteTireMultiplier]" id="wasteTireMultiplier_{{ $index }}" class="form-control"
                        onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
                  <option value="1">選択してください</option>
                  <option value="1">×1</option>
                  <option value="2">×2</option>
                  <option value="3">×3</option>
                  <option value="4">×4</option>
                </select>
              </div>

              <!-- ナット代を入力するテキストボックスと倍率のセレクトボックス -->
              <div class="mt-3">
                <label for="nut_{{ $index }}" class="form-label">ナット代を入力:</label>
                <input type="number" name="items[{{ $index }}][nut]" id="nut_{{ $index }}" class="form-control" 
                       onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})" placeholder="0">

                <label for="nutMultiplier_{{ $index }}" class="form-label mt-2">倍率を選択:</label>
                <select name="items[{{ $index }}][nutMultiplier]" id="nutMultiplier_{{ $index }}" class="form-control"
                        onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
                  <option value="1">選択してください</option>
                  <option value="1">×1</option>
                  <option value="2">×2</option>
                  <option value="3">×3</option>
                  <option value="4">×4</option>
                </select>
              </div>

              <!-- バルブ代を入力するテキストボックスと倍率のセレクトボックス -->
              <div class="mt-3">
                <label for="valve_{{ $index }}" class="form-label">バルブ代を入力:</label>
                <input type="number" name="items[{{ $index }}][valve]" id="valve_{{ $index }}" class="form-control" 
                       onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})" placeholder="0">

                <label for="valveMultiplier_{{ $index }}" class="form-label mt-2">倍率を選択:</label>
                <select name="items[{{ $index }}][valveMultiplier]" id="valveMultiplier_{{ $index }}" class="form-control"
                        onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
                  <option value="1">選択してください</option>
                  <option value="1">×1</option>
                  <option value="2">×2</option>
                  <option value="3">×3</option>
                  <option value="4">×4</option>
                </select>
              </div>

              <!-- 袋代を入力するテキストボックスと倍率のセレクトボックス -->
              <div class="mt-3">
                <label for="bag_{{ $index }}" class="form-label">袋代を入力:</label>
                <input type="number" name="items[{{ $index }}][bag]" id="bag_{{ $index }}" class="form-control" 
                       onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})" placeholder="0">

                <label for="bagMultiplier_{{ $index }}" class="form-label mt-2">倍率を選択:</label>
                <select name="items[{{ $index }}][bagMultiplier]" id="bagMultiplier_{{ $index }}" class="form-control"
                        onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
                  <option value="1">選択してください</option>
                  <option value="1">×1</option>
                  <option value="2">×2</option>
                  <option value="3">×3</option>
                  <option value="4">×4</option>
                </select>
              </div>
              
              <!-- その他を入力するテキストボックスと倍率のセレクトボックス -->
              <div class="mt-3">
                <label for="others_{{ $index }}" class="form-label">その他を入力:</label>
                <input type="number" name="items[{{ $index }}][others]" id="others_{{ $index }}" class="form-control" 
                       onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})" placeholder="0">

                <label for="othersMultiplier_{{ $index }}" class="form-label mt-2">倍率を選択:</label>
                <select name="items[{{ $index }}][othersMultiplier]" id="othersMultiplier_{{ $index }}" class="form-control"
                        onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
                  <option value="1">選択してください</option>
                  <option value="1">×1</option>
                  <option value="2">×2</option>
                  <option value="3">×3</option>
                  <option value="4">×4</option>
                </select>
              </div>
              
              <hr>

              <!-- 小計表示 -->
              <div class="mt-3">
                <p class="h5">小計: <span id="subtotalPrice_{{ $index }}">0</span>円</p>
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
function toggleAndCalculate(index, itemPrice) {
    const optionA = document.getElementById(`itemOptionA_${index}`);
    const optionB = document.getElementById(`itemOptionB_${index}`);
    const wages = parseInt(document.getElementById(`wages_${index}`).value) || 0;
    const wagesMultiplier = parseInt(document.getElementById(`wagesMultiplier_${index}`).value) || 1;

    // 新しく追加された項目の取得
    const wasteTire = parseInt(document.getElementById(`wasteTire_${index}`).value) || 0;
    const wasteTireMultiplier = parseInt(document.getElementById(`wasteTireMultiplier_${index}`).value) || 1;
    const nut = parseInt(document.getElementById(`nut_${index}`).value) || 0;
    const nutMultiplier = parseInt(document.getElementById(`nutMultiplier_${index}`).value) || 1;
    const valve = parseInt(document.getElementById(`valve_${index}`).value) || 0;
    const valveMultiplier = parseInt(document.getElementById(`valveMultiplier_${index}`).value) || 1;
    const bag = parseInt(document.getElementById(`bag_${index}`).value) || 0;
    const bagMultiplier = parseInt(document.getElementById(`bagMultiplier_${index}`).value) || 1;
    const others = parseInt(document.getElementById(`others_${index}`).value) || 0;
    const othersMultiplier = parseInt(document.getElementById(`othersMultiplier_${index}`).value) || 1;

    // 小計の計算
    let subtotal = (wages * wagesMultiplier) + 
                   (wasteTire * wasteTireMultiplier) + 
                   (nut * nutMultiplier) + 
                   (valve * valveMultiplier) + 
                   (bag * bagMultiplier) + 
                   (others * othersMultiplier);

    // 合計の計算
    let total = itemPrice + subtotal;

    // Option A が選択されている場合
    if (optionA.value !== "0") {
        total += parseInt(optionA.value);
        optionB.disabled = true;
        optionB.classList.add('disabled-select');
    } else {
        optionB.disabled = false;
        optionB.classList.remove('disabled-select');
    }

    // Option B が選択されている場合
    if (optionB.value !== "0") {
        total = Math.floor(total * parseFloat(optionB.value));
        optionA.disabled = true;
        optionA.classList.add('disabled-select');
    } else {
        optionA.disabled = false;
        optionA.classList.remove('disabled-select');
    }

    // 小計と合計を表示
    document.getElementById(`subtotalPrice_${index}`).innerText = subtotal;
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
