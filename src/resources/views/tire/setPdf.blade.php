<div>
  <form action="{{ route('tire.createPdf') }}" method="POST">
    @csrf
    @foreach ($items as $index => $item)
      <div>
        <div>
          <h2>選択商品</h2>
          <input type="hidden" name="items[{{ $index }}][itemName]" value="{{ $item['itemName'] }}">
          <input type="hidden" name="items[{{ $index }}][itemPrice]" id="itemPrice_{{ $index }}" value="{{ $item['itemPrice'] }}">

          <p>{{ $item['itemName'] }}</p>
          <div>
            <span>{{ $item['itemPrice'] }}円</span>
          </div>

          <hr>
          <h3>粗利設定</h3>
          <div>
            <label for="itemOptionA_{{ $index }}">粗利を選択A:</label>
            <select name="items[{{ $index }}][itemOptionA]" id="itemOptionA_{{ $index }}" onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
              <option value="0">選択してください</option>
              <option value="10000">10,000円</option>
              <option value="15000">15,000円</option>
              <option value="20000">20,000円</option>
            </select>
          </div>

          <div>
            <label for="itemOptionB_{{ $index }}">粗利を選択B:</label>
            <select name="items[{{ $index }}][itemOptionB]" id="itemOptionB_{{ $index }}" 
              onchange="updateProfitDisplay({{ $index }}, {{ $item['itemPrice'] }})">
              <option value="0">選択してください</option>
              <option value="1.1">×1.1</option>
              <option value="1.2">×1.2</option>
              <option value="1.3">×1.3</option>
            </select>
            <span id="profitDisplay_{{ $index }}"></span>
          </div>





          <div>
            <p>合計: <span id="totalPrice_{{ $index }}">0</span>円</p>
          </div>
          <div>
            <p>内工賃: <span id="subtotalPrice_{{ $index }}">0</span>円</p>
          </div>
          <div>
            <p>合計-原価: <span id="profit_{{ $index }}">0</span>円</p>
          </div>

          </div>

          <hr>
          <h3>工賃その他設定</h3>

          <div>
            <label for="wages_{{ $index }}">工賃を入力:</label>
            <input type="number" name="items[{{ $index }}][wages]" id="wages_{{ $index }}" placeholder="0" onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">

            <label for="wagesMultiplier_{{ $index }}">倍率を選択:</label>
            <select name="items[{{ $index }}][wagesMultiplier]" id="wagesMultiplier_{{ $index }}" onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
              <option value="1">×1</option>
              <option value="2">×2</option>
              <option value="3">×3</option>
              <option value="4">×4</option>
            </select>
          </div>

          <div>
            <label for="wasteTire_{{ $index }}">廃タイヤ費用を入力:</label>
            <input type="number" name="items[{{ $index }}][wasteTire]" id="wasteTire_{{ $index }}" placeholder="0" onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">

            <label for="wasteTireMultiplier_{{ $index }}">倍率を選択:</label>
            <select name="items[{{ $index }}][wasteTireMultiplier]" id="wasteTireMultiplier_{{ $index }}" onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
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
                    <option value="1">×1</option>
                    <option value="2">×2</option>
                    <option value="3">×3</option>
                    <option value="4">×4</option>
                    <option value="5">×5</option>
                    <option value="6">×6</option>
                    <option value="7">×7</option>
                    <option value="8">×8</option>
                    <option value="9">×9</option>
                    <option value="10">×10</option>
                    <option value="11">×11</option>
                    <option value="12">×12</option>
                    <option value="13">×13</option>
                    <option value="14">×14</option>
                    <option value="15">×15</option>
                    <option value="16">×16</option>
                    <option value="17">×17</option>
                    <option value="18">×18</option>
                    <option value="19">×19</option>
                    <option value="20">×20</option>
                    <option value="21">×21</option>
                    <option value="22">×22</option>
                    <option value="23">×23</option>
                    <option value="24">×24</option>
                    <option value="25">×25</option>
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
              <option value="1">×1</option>
              <option value="2">×2</option>
              <option value="3">×3</option>
              <option value="4">×4</option>
            </select>
          </div>
          
          <!-- その他を入力するテキストボックスと倍率のセレクトボックス -->
          <div class="mt-3">
            <label for="detachment_{{ $index }}" class="form-label">脱着工賃:</label>
            <input type="number" name="items[{{ $index }}][detachment]" id="detachment_{{ $index }}" class="form-control" 
                    onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})" placeholder="0">

            <label for="detachmentMultiplier_{{ $index }}" class="form-label mt-2">倍率を選択:</label>
            <select name="items[{{ $index }}][detachmentMultiplier]" id="detachmentMultiplier_{{ $index }}" class="form-control"
                    onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
              <option value="1">×1</option>
              <option value="2">×2</option>
              <option value="3">×3</option>
              <option value="4">×4</option>
            </select>
          </div>




          <!-- 同じ工賃を他の商品に適用するチェックボックス -->
          <div>
            <label for="applySameWages_{{ $index }}">同じ工賃を他の商品に適用</label>
            <input type="checkbox" id="applySameWages_{{ $index }}" onchange="applySameWagesToAll({{ $index }})">
          </div>

          <!-- Cookieに保存するチェックボックス -->
          <div>
            <label for="saveToCookie_{{ $index }}">設定をCookieに保存</label>
            <input type="checkbox" id="saveToCookie_{{ $index }}" onchange="saveSettingsToCookie({{ $index }})">
          </div>

          <hr>
        </div>
      </div>
    @endforeach

    <button type="submit">PDFに送信</button>
  </form>
</div>

<script>
function toggleAndCalculate(index, itemPrice) {
    const optionA = document.getElementById(`itemOptionA_${index}`);
    const optionB = document.getElementById(`itemOptionB_${index}`);
    const wages = parseInt(document.getElementById(`wages_${index}`).value) || 0;
    const wagesMultiplier = parseInt(document.getElementById(`wagesMultiplier_${index}`).value) || 1;
    const wasteTire = parseInt(document.getElementById(`wasteTire_${index}`).value) || 0;
    const wasteTireMultiplier = parseInt(document.getElementById(`wasteTireMultiplier_${index}`).value) || 1;
    const nut = parseInt(document.getElementById(`nut_${index}`).value) || 0;
    const nutMultiplier = parseInt(document.getElementById(`nutMultiplier_${index}`).value) || 1;
    const valve = parseInt(document.getElementById(`valve_${index}`).value) || 0;
    const valveMultiplier = parseInt(document.getElementById(`valveMultiplier_${index}`).value) || 1;
    const bag = parseInt(document.getElementById(`bag_${index}`).value) || 0;
    const bagMultiplier = parseInt(document.getElementById(`bagMultiplier_${index}`).value) || 1;
    const detachment = parseInt(document.getElementById(`detachment_${index}`).value) || 0;
    const detachmentMultiplier = parseInt(document.getElementById(`detachmentMultiplier_${index}`).value) || 1;

    // 小計を計算
    let subtotal = 
        (wages * wagesMultiplier) +
        (wasteTire * wasteTireMultiplier) +
        (nut * nutMultiplier) +
        (valve * valveMultiplier) +
        (bag * bagMultiplier) +
        (detachment * detachmentMultiplier);

    // 合計を計算
    let total = itemPrice + subtotal;

    // OptionAの処理
    if (optionA.value !== "0" && optionB.value === "0") {
        total += parseInt(optionA.value);
        optionB.disabled = true; // 選択Aが有効な場合、Bをロック
    } else {
        optionB.disabled = false; // Aが無効な場合、Bを再度有効に
    }

    // OptionBの処理
    if (optionB.value !== "0") {
        total = Math.floor(total * parseFloat(optionB.value));
        optionA.disabled = true; // 選択Bが有効な場合、Aをロック
    } else {
        optionA.disabled = false; // Bが無効な場合、Aを再度有効に
    }

    // 利益を計算
    const profit = total - itemPrice;

    // 結果を表示
    document.getElementById(`subtotalPrice_${index}`).innerText = subtotal;
    document.getElementById(`totalPrice_${index}`).innerText = total;
    document.getElementById(`profit_${index}`).innerText = profit;
}


function updateProfitDisplay(index, itemPrice) {
    const optionB = document.getElementById(`itemOptionB_${index}`);
    const profitDisplay = document.getElementById(`profitDisplay_${index}`);

    // OptionBが選択されている場合の利益を表示
    if (optionB.value !== "0") {
        const multiplier = parseFloat(optionB.value);
        const calculatedProfit = Math.floor(itemPrice * multiplier) - itemPrice;
        profitDisplay.innerText = `利益: ${calculatedProfit}円`;
        toggleAndCalculate(index, itemPrice);
    } else {
        profitDisplay.innerText = ""; // 初期化
    }
}



function applySameWagesToAll(index) {
    // 元データを取得
    const wages = document.getElementById(`wages_${index}`).value;
    const wagesMultiplier = document.getElementById(`wagesMultiplier_${index}`).value;
    const wasteTire = document.getElementById(`wasteTire_${index}`).value;
    const wasteTireMultiplier = document.getElementById(`wasteTireMultiplier_${index}`).value;
    const nut = document.getElementById(`nut_${index}`).value;
    const nutMultiplier = document.getElementById(`nutMultiplier_${index}`).value;
    const valve = document.getElementById(`valve_${index}`).value;
    const valveMultiplier = document.getElementById(`valveMultiplier_${index}`).value;
    const bag = document.getElementById(`bag_${index}`).value;
    const bagMultiplier = document.getElementById(`bagMultiplier_${index}`).value;
    const detachment = document.getElementById(`detachment_${index}`).value;
    const detachmentMultiplier = document.getElementById(`detachmentMultiplier_${index}`).value;

    // 他の項目に適用
    if (document.getElementById(`applySameWages_${index}`).checked) {
        document.querySelectorAll(`[id^="wages_"]`).forEach((input, i) => {
            if (i !== index) {
                document.getElementById(`wages_${i}`).value = wages;
                document.getElementById(`wagesMultiplier_${i}`).value = wagesMultiplier;
                document.getElementById(`wasteTire_${i}`).value = wasteTire;
                document.getElementById(`wasteTireMultiplier_${i}`).value = wasteTireMultiplier;
                document.getElementById(`nut_${i}`).value = nut;
                document.getElementById(`nutMultiplier_${i}`).value = nutMultiplier;
                document.getElementById(`valve_${i}`).value = valve;
                document.getElementById(`valveMultiplier_${i}`).value = valveMultiplier;
                document.getElementById(`bag_${i}`).value = bag;
                document.getElementById(`bagMultiplier_${i}`).value = bagMultiplier;
                document.getElementById(`detachment_${i}`).value = detachment;
                document.getElementById(`detachmentMultiplier_${i}`).value = detachmentMultiplier;
                toggleAndCalculate(i, parseInt(document.getElementById(`itemPrice_${i}`).value));
            }
        });
    }
}

function saveSettingsToCookie(index) {
    // 保存する値を取得
    const wages = document.getElementById(`wages_${index}`).value;
    const wagesMultiplier = document.getElementById(`wagesMultiplier_${index}`).value;
    const wasteTire = document.getElementById(`wasteTire_${index}`).value;
    const wasteTireMultiplier = document.getElementById(`wasteTireMultiplier_${index}`).value;
    const nut = document.getElementById(`nut_${index}`).value;
    const nutMultiplier = document.getElementById(`nutMultiplier_${index}`).value;
    const valve = document.getElementById(`valve_${index}`).value;
    const valveMultiplier = document.getElementById(`valveMultiplier_${index}`).value;
    const bag = document.getElementById(`bag_${index}`).value;
    const bagMultiplier = document.getElementById(`bagMultiplier_${index}`).value;
    const detachment = document.getElementById(`detachment_${index}`).value;
    const detachmentMultiplier = document.getElementById(`detachmentMultiplier_${index}`).value;

    // Cookieに保存
    document.cookie = `wages=${wages};path=/`;
    document.cookie = `wagesMultiplier=${wagesMultiplier};path=/`;
    document.cookie = `wasteTire=${wasteTire};path=/`;
    document.cookie = `wasteTireMultiplier=${wasteTireMultiplier};path=/`;
    document.cookie = `nut=${nut};path=/`;
    document.cookie = `nutMultiplier=${nutMultiplier};path=/`;
    document.cookie = `valve=${valve};path=/`;
    document.cookie = `valveMultiplier=${valveMultiplier};path=/`;
    document.cookie = `bag=${bag};path=/`;
    document.cookie = `bagMultiplier=${bagMultiplier};path=/`;
    document.cookie = `detachment=${detachment};path=/`;
    document.cookie = `detachmentMultiplier=${detachmentMultiplier};path=/`;

    alert('設定を保存しました！');
}

function loadSettingsFromCookie() {
    const cookies = document.cookie.split('; ').reduce((acc, cookie) => {
        const [key, value] = cookie.split('=');
        acc[key] = value;
        return acc;
    }, {});

    document.querySelectorAll(`[id^="wages_"]`).forEach((input, index) => {
        if (cookies.wages) input.value = cookies.wages;
        if (cookies.wagesMultiplier) document.getElementById(`wagesMultiplier_${index}`).value = cookies.wagesMultiplier;
        if (cookies.wasteTire) document.getElementById(`wasteTire_${index}`).value = cookies.wasteTire;
        if (cookies.wasteTireMultiplier) document.getElementById(`wasteTireMultiplier_${index}`).value = cookies.wasteTireMultiplier;
        if (cookies.nut) document.getElementById(`nut_${index}`).value = cookies.nut;
        if (cookies.nutMultiplier) document.getElementById(`nutMultiplier_${index}`).value = cookies.nutMultiplier;
        if (cookies.valve) document.getElementById(`valve_${index}`).value = cookies.valve;
        if (cookies.valveMultiplier) document.getElementById(`valveMultiplier_${index}`).value = cookies.valveMultiplier;
        if (cookies.bag) document.getElementById(`bag_${index}`).value = cookies.bag;
        if (cookies.bagMultiplier) document.getElementById(`bagMultiplier_${index}`).value = cookies.bagMultiplier;
        if (cookies.detachment) document.getElementById(`detachment_${index}`).value = cookies.detachment;
        if (cookies.detachmentMultiplier) document.getElementById(`detachmentMultiplier_${index}`).value = cookies.detachmentMultiplier;
        toggleAndCalculate(index, parseInt(document.getElementById(`itemPrice_${index}`).value));
    });
}

// ページ読み込み時に設定を反映
document.addEventListener('DOMContentLoaded', loadSettingsFromCookie);

</script>
