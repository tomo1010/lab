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
          <h2>粗利設定</h2>
          <div>
            <label for="itemOptionA_{{ $index }}">粗利を選択:</label>
            <select name="items[{{ $index }}][itemOptionA]" id="itemOptionA_{{ $index }}" onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
              <option value="0">選択してください</option>
              <option value="10000">10,000円</option>
              <option value="15000">15,000円</option>
              <option value="20000">20,000円</option>
            </select>
          </div>

          <div>
            <label for="itemOptionB_{{ $index }}">粗利を選択:</label>
            <select name="items[{{ $index }}][itemOptionB]" id="itemOptionB_{{ $index }}" onchange="toggleAndCalculate({{ $index }}, {{ $item['itemPrice'] }})">
              <option value="0">選択してください</option>
              <option value="1.1">×1.1</option>
              <option value="1.2">×1.2</option>
              <option value="1.3">×1.3</option>
            </select>
          </div>

          <div>
            <p>合計: <span id="totalPrice_{{ $index }}">0</span>円</p>
          </div>
          <div>
            <p>内工賃: <span id="subtotalPrice_{{ $index }}">0</span>円</p>
          </div>

          <hr>
          <h2>工賃その他設定</h2>

          <div>
            <label for="wages_{{ $index }}">工賃を入力:</label>
            <input type="number" name="items[{{ $index }}][wages]" id="wages_{{ $index }}" placeholder="0">

            <label for="wagesMultiplier_{{ $index }}">倍率を選択:</label>
            <select name="items[{{ $index }}][wagesMultiplier]" id="wagesMultiplier_{{ $index }}">
              <option value="1">×1</option>
              <option value="2">×2</option>
              <option value="3">×3</option>
              <option value="4">×4</option>
            </select>
          </div>

          <div>
            <label for="wasteTire_{{ $index }}">廃タイヤ費用を入力:</label>
            <input type="number" name="items[{{ $index }}][wasteTire]" id="wasteTire_{{ $index }}" placeholder="0">

            <label for="wasteTireMultiplier_{{ $index }}">倍率を選択:</label>
            <select name="items[{{ $index }}][wasteTireMultiplier]" id="wasteTireMultiplier_{{ $index }}">
              <option value="1">×1</option>
              <option value="2">×2</option>
              <option value="3">×3</option>
              <option value="4">×4</option>
            </select>
          </div>

          <button type="button" onclick="saveSettingsToCookie({{ $index }})">設定を保存</button>
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

    let subtotal = (wages * wagesMultiplier) + (wasteTire * wasteTireMultiplier);
    let total = itemPrice + subtotal;

    if (optionA.value !== "0") {
        total += parseInt(optionA.value);
        optionB.disabled = true;
    } else {
        optionB.disabled = false;
    }

    if (optionB.value !== "0") {
        total = Math.floor(total * parseFloat(optionB.value));
        optionA.disabled = true;
    } else {
        optionA.disabled = false;
    }

    document.getElementById(`subtotalPrice_${index}`).innerText = subtotal;
    document.getElementById(`totalPrice_${index}`).innerText = total;
}

function saveSettingsToCookie(index) {
    const wages = document.getElementById(`wages_${index}`).value;
    const wagesMultiplier = document.getElementById(`wagesMultiplier_${index}`).value;
    const wasteTire = document.getElementById(`wasteTire_${index}`).value;
    const wasteTireMultiplier = document.getElementById(`wasteTireMultiplier_${index}`).value;

    const settings = {
        wages,
        wagesMultiplier,
        wasteTire,
        wasteTireMultiplier
    };

    document.cookie = `settings=${JSON.stringify(settings)}; path=/; max-age=31536000`; // 保存期間1年
}

function loadSettingsFromCookie() {
    const cookies = document.cookie.split(';');
    const settingsCookie = cookies.find(cookie => cookie.trim().startsWith('settings='));

    if (settingsCookie) {
        const settings = JSON.parse(settingsCookie.split('=')[1]);

        document.querySelectorAll(`[id^="wages_"]`).forEach((input, index) => {
            document.getElementById(`wages_${index}`).value = settings.wages;
            document.getElementById(`wagesMultiplier_${index}`).value = settings.wagesMultiplier;
            document.getElementById(`wasteTire_${index}`).value = settings.wasteTire;
            document.getElementById(`wasteTireMultiplier_${index}`).value = settings.wasteTireMultiplier;
        });
    }
}

// ページ読み込み時にCookieから設定をロード
document.addEventListener('DOMContentLoaded', loadSettingsFromCookie);
</script>
