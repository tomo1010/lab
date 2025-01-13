<div>
    {{$keyword}}
    <form action="{{ route('tirecalc.createPdf') }}" method="POST">
        @csrf

        <!-- $keyword を送信するための隠しフィールド -->
        <input type="hidden" name="keyword" value="{{ $keyword }}">

        <h3>商品１</h3>
        <div>
            <label for="cost1">商品１の原価を入力:</label>
            <input type="number" name="cost1" id="cost1" placeholder="0" onchange="updateCalculation()">
            <label for="cost1Multiplier">倍率を選択:</label>
            <select name="cost1Multiplier" id="cost1Multiplier" onchange="updateCalculation()">
                <option value="1">×1</option>
                <option value="2">×2</option>
                <option value="3">×3</option>
                <option value="4">×4</option>
            </select>
        </div>

        <div>
            <h4>商品１計算結果</h4>
            <p>商品代金: <span id="profitTotal1">0</span> 円</p>
            <p>工賃合計: <span id="wagesTotal1">0</span> 円</p>
            <p>税抜合計: <span id="Total1">0</span> 円</p>
            <p>税込合計: <span id="TotalWithTax1">0</span> 円</p>
        </div>

        <h3>商品２</h3>
        <div>
            <label for="cost2">商品２の原価を入力:</label>
            <input type="number" name="cost2" id="cost2" placeholder="0" onchange="updateCalculation()">
            <label for="cost2Multiplier">倍率を選択:</label>
            <select name="cost2Multiplier" id="cost2Multiplier" onchange="updateCalculation()">
                <option value="1">×1</option>
                <option value="2">×2</option>
                <option value="3">×3</option>
                <option value="4">×4</option>
            </select>
        </div>

        <div>
            <h4>商品２計算結果</h4>
            <p>商品代金: <span id="profitTotal2">0</span> 円</p>
            <p>工賃合計: <span id="wagesTotal2">0</span> 円</p>
            <p>税抜合計: <span id="Total2">0</span> 円</p>
            <p>税込合計: <span id="TotalWithTax2">0</span> 円</p>
        </div>

        <h3>商品３</h3>
        <div>
            <label for="cost3">商品３の原価を入力:</label>
            <input type="number" name="cost3" id="cost3" placeholder="0" onchange="updateCalculation()">
            <label for="cost3Multiplier">倍率を選択:</label>
            <select name="cost3Multiplier" id="cost3Multiplier" onchange="updateCalculation()">
                <option value="1">×1</option>
                <option value="2">×2</option>
                <option value="3">×3</option>
                <option value="4">×4</option>
            </select>
        </div>

        <div>
            <h4>商品３計算結果</h4>
            <p>商品代金: <span id="profitTotal3">0</span> 円</p>
            <p>工賃合計: <span id="wagesTotal3">0</span> 円</p>
            <p>税抜合計: <span id="Total3">0</span> 円</p>
            <p>税込合計: <span id="TotalWithTax3">0</span> 円</p>
        </div>

    </div>

    <hr>
    <h3>粗利設定</h3>
    <div>
        <label for="profitOptionA">粗利A:</label>
        <select name="profitOptionA" id="profitOptionA" onchange="updateCalculation()">
            <option value="0">選択してください</option>
            <option value="5000">5,000円</option>
            <option value="10000">10,000円</option>
            <option value="15000">15,000円</option>
            <option value="20000">20,000円</option>
        </select>
    </div>

    <div>
        <label for="profitOptionB">粗利B:</label>
        <select name="profitOptionB" id="profitOptionB" onchange="updateCalculation()">
            <option value="0">選択してください</option>
            <option value="1.1">×1.1</option>
            <option value="1.2">×1.2</option>
            <option value="1.3">×1.3</option>
            <option value="1.4">×1.4</option>
            <option value="1.5">×1.5</option>
        </select>
    </div>

    <h3>工賃その他設定</h3>
    <!-- 工賃入力項目 -->
    <div>
        <label for="set1">組替えバランス工賃を入力:</label>
        <input type="number" name="set1" id="set1" placeholder="0" onchange="updateCalculation()">
        <label for="set1Multiplier">倍率を選択:</label>
        <select name="set1Multiplier" id="set1Multiplier" onchange="updateCalculation()">
            <option value="1">×1</option>
            <option value="2">×2</option>
            <option value="3">×3</option>
            <option value="4">×4</option>
        </select>
    </div>

    <div>
        <label for="set2">脱着工賃を入力:</label>
        <input type="number" name="set2" id="set2" placeholder="0" onchange="updateCalculation()">
        <label for="set2Multiplier">倍率を選択:</label>
        <select name="set2Multiplier" id="set2Multiplier" onchange="updateCalculation()">
            <option value="1">×1</option>
            <option value="2">×2</option>
            <option value="3">×3</option>
            <option value="4">×4</option>
        </select>
    </div>

    <div>
        <label for="set3">廃タイヤ費用を入力:</label>
        <input type="number" name="set3" id="set3" placeholder="0" onchange="updateCalculation()">
        <label for="set3Multiplier">倍率を選択:</label>
        <select name="set3Multiplier" id="set3Multiplier" onchange="updateCalculation()">
            <option value="1">×1</option>
            <option value="2">×2</option>
            <option value="3">×3</option>
            <option value="4">×4</option>
        </select>
    </div>

    <div>
        <label for="set4">ナット代を入力:</label>
        <input type="number" name="set4" id="set4" placeholder="0" onchange="updateCalculation()">
        <label for="set4Multiplier">倍率を選択:</label>
        <select name="set4Multiplier" id="set4Multiplier" onchange="updateCalculation()">
            <option value="1">×1</option>
            <option value="2">×2</option>
            <option value="3">×3</option>
            <option value="4">×4</option>
        </select>
    </div>

    <div>
        <label for="set5">バルブ代を入力:</label>
        <input type="number" name="set5" id="set5" placeholder="0" onchange="updateCalculation()">
        <label for="set5Multiplier">倍率を選択:</label>
        <select name="set5Multiplier" id="set5Multiplier" onchange="updateCalculation()">
            <option value="1">×1</option>
            <option value="2">×2</option>
            <option value="3">×3</option>
            <option value="4">×4</option>
        </select>
    </div>

    <div>
        <label for="set6">袋代を入力:</label>
        <input type="number" name="set6" id="set6" placeholder="0" onchange="updateCalculation()">
        <label for="set6Multiplier">倍率を選択:</label>
        <select name="set6Multiplier" id="set6Multiplier" onchange="updateCalculation()">
            <option value="1">×1</option>
            <option value="2">×2</option>
            <option value="3">×3</option>
            <option value="4">×4</option>
        </select>
    </div>

    <div>
        <label for="set7">その他入力:</label>
        <input type="number" name="set7" id="set7" placeholder="0" onchange="updateCalculation()">
        <label for="set7Multiplier">倍率を選択:</label>
        <select name="set7Multiplier" id="set7Multiplier" onchange="updateCalculation()">
            <option value="1">×1</option>
            <option value="2">×2</option>
            <option value="3">×3</option>
            <option value="4">×4</option>
        </select>
    </div>

    <div>
        <input type="checkbox" id="saveToCookie" onchange="saveSettingsToCookie()"> クッキーに保存
    </div>

    <button type="submit">PDFに送信</button>
    </form>
</div>

<script>
function updateCalculation() {
    calculateProduct(1);
    calculateProduct(2);
    calculateProduct(3);
}

function calculateProduct(productNumber) {
    const cost = parseInt(document.getElementById(`cost${productNumber}`).value) || 0;
    const costMultiplier = parseInt(document.getElementById(`cost${productNumber}Multiplier`).value) || 1;
    const profitA = parseInt(document.getElementById('profitOptionA')?.value) || 0;
    const profitBMultiplier = parseFloat(document.getElementById('profitOptionB')?.value) || 1;

    const wagesTotal = calculateWagesTotal();
    const adjustedCost = cost * costMultiplier;

    const profitTotal = Math.floor((adjustedCost + profitA) * profitBMultiplier);
    const total = profitTotal + wagesTotal;
    const totalWithTax = Math.floor(total * 1.1);

    document.getElementById(`profitTotal${productNumber}`).innerText = profitTotal.toLocaleString();
    document.getElementById(`wagesTotal${productNumber}`).innerText = wagesTotal.toLocaleString();
    document.getElementById(`Total${productNumber}`).innerText = total.toLocaleString();
    document.getElementById(`TotalWithTax${productNumber}`).innerText = totalWithTax.toLocaleString();
}

function calculateWagesTotal() {
    const sets = [1, 2, 3, 4, 5, 6, 7].map((set) => {
        const value = parseInt(document.getElementById(`set${set}`)?.value) || 0;
        const multiplier = parseInt(document.getElementById(`set${set}Multiplier`)?.value) || 1;
        return value * multiplier;
    });

    return sets.reduce((acc, curr) => acc + curr, 0);
}


// 工賃設定をクッキーに保存する関数
function saveSettingsToCookie() {
    const isChecked = document.getElementById('saveToCookie').checked;
    if (isChecked) {
        const settings = {};

        for (let i = 1; i <= 7; i++) {
            const value = parseInt(document.getElementById(`set${i}`).value) || 0;
            const multiplier = parseInt(document.getElementById(`set${i}Multiplier`).value) || 1;
            settings[`set${i}`] = { value, multiplier };
        }

        document.cookie = `wageSettings=${JSON.stringify(settings)}; path=/; max-age=31536000;`;
        alert('工賃設定がクッキーに保存されました。');
    } else {
        document.cookie = `wageSettings=; path=/; max-age=0;`;
        alert('クッキーが削除されました。');
    }
}

// クッキーから工賃設定を読み込む関数
function loadSettingsFromCookie() {
    const cookies = document.cookie.split('; ').reduce((acc, curr) => {
        const [key, value] = curr.split('=');
        acc[key] = value;
        return acc;
    }, {});

    if (cookies.wageSettings) {
        const settings = JSON.parse(cookies.wageSettings);
        for (let i = 1; i <= 7; i++) {
            if (settings[`set${i}`]) {
                document.getElementById(`set${i}`).value = settings[`set${i}`].value || 0;
                document.getElementById(`set${i}Multiplier`).value = settings[`set${i}`].multiplier || 1;
            }
        }
        alert('クッキーから工賃設定を読み込みました。');
    }
}

// ページ読み込み時にクッキーから設定を読み込む
window.onload = loadSettingsFromCookie;

</script>
