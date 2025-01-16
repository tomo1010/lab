<div>
    {{$keyword}}
    <form action="{{ route('tirecalc.createPdf') }}" method="POST">
        @csrf

        <!-- $keyword を送信するための隠しフィールド -->
        <input type="hidden" name="keyword" value="{{ $keyword }}">

        <!-- 隠しフィールド（送信用） -->
        <input type="hidden" name="productData[1][profitTotal]" id="hiddenProfitTotal1">
        <input type="hidden" name="productData[1][wagesTotal]" id="hiddenWagesTotal1">
        <input type="hidden" name="productData[1][taxExcludedTotal]" id="hiddenTotal1">
        <input type="hidden" name="productData[1][taxIncludedTotal]" id="hiddenTotalWithTax1">
        <input type="hidden" name="productData[2][profitTotal]" id="hiddenProfitTotal2">
        <input type="hidden" name="productData[2][wagesTotal]" id="hiddenWagesTotal2">
        <input type="hidden" name="productData[2][taxExcludedTotal]" id="hiddenTotal2">
        <input type="hidden" name="productData[2][taxIncludedTotal]" id="hiddenTotalWithTax2">
        <input type="hidden" name="productData[3][profitTotal]" id="hiddenProfitTotal3">
        <input type="hidden" name="productData[3][wagesTotal]" id="hiddenWagesTotal3">
        <input type="hidden" name="productData[3][taxExcludedTotal]" id="hiddenTotal3">
        <input type="hidden" name="productData[3][taxIncludedTotal]" id="hiddenTotalWithTax3">

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
    <hr>

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
<hr>
    <h3>印刷設定</h3>
    <div>
        商品１：
        <select name="maker1" id="maker1">
            <option value="" {{ request('maker1') == '' ? 'selected' : '' }}>メーカー選択</option>
            <option value="ブリヂストン" {{ request('maker1') == 'ブリヂストン' ? 'selected' : '' }}>ブリヂストン</option>
            <option value="ダンロップ" {{ request('maker1') == 'ダンロップ' ? 'selected' : '' }}>ダンロップ</option>
            <option value="トーヨータイヤ" {{ request('maker1') == 'トーヨータイヤ' ? 'selected' : '' }}>トーヨータイヤ</option>
            <option value="ピレリ" {{ request('maker1') == 'ピレリ' ? 'selected' : '' }}>ピレリ</option>
            <option value="ヨコハマ" {{ request('maker1') == 'ヨコハマ' ? 'selected' : '' }}>ヨコハマ</option>
            <option value="グッドイヤー" {{ request('maker1') == 'グッドイヤー' ? 'selected' : '' }}>グッドイヤー</option>
            <option value="ミシュラン" {{ request('maker1') == 'ミシュラン' ? 'selected' : '' }}>ミシュラン</option>
        </select><br>
        商品２：
        <select name="maker2" id="maker2">
            <option value="" {{ request('maker2') == '' ? 'selected' : '' }}>メーカー選択</option>
            <option value="ブリヂストン" {{ request('maker2') == 'ブリヂストン' ? 'selected' : '' }}>ブリヂストン</option>
            <option value="ダンロップ" {{ request('maker2') == 'ダンロップ' ? 'selected' : '' }}>ダンロップ</option>
            <option value="トーヨータイヤ" {{ request('maker2') == 'トーヨータイヤ' ? 'selected' : '' }}>トーヨータイヤ</option>
            <option value="ピレリ" {{ request('maker2') == 'ピレリ' ? 'selected' : '' }}>ピレリ</option>
            <option value="ヨコハマ" {{ request('maker2') == 'ヨコハマ' ? 'selected' : '' }}>ヨコハマ</option>
            <option value="グッドイヤー" {{ request('maker2') == 'グッドイヤー' ? 'selected' : '' }}>グッドイヤー</option>
            <option value="ミシュラン" {{ request('maker2') == 'ミシュラン' ? 'selected' : '' }}>ミシュラン</option>
        </select><br>
        商品３：
        <select name="maker3" id="maker3">
            <option value="" {{ request('maker3') == '' ? 'selected' : '' }}>メーカー選択</option>
            <option value="ブリヂストン" {{ request('maker3') == 'ブリヂストン' ? 'selected' : '' }}>ブリヂストン</option>
            <option value="ダンロップ" {{ request('maker3') == 'ダンロップ' ? 'selected' : '' }}>ダンロップ</option>
            <option value="トーヨータイヤ" {{ request('maker3') == 'トーヨータイヤ' ? 'selected' : '' }}>トーヨータイヤ</option>
            <option value="ピレリ" {{ request('maker3') == 'ピレリ' ? 'selected' : '' }}>ピレリ</option>
            <option value="ヨコハマ" {{ request('maker3') == 'ヨコハマ' ? 'selected' : '' }}>ヨコハマ</option>
            <option value="グッドイヤー" {{ request('maker3') == 'グッドイヤー' ? 'selected' : '' }}>グッドイヤー</option>
            <option value="ミシュラン" {{ request('maker3') == 'ミシュラン' ? 'selected' : '' }}>ミシュラン</option>
        </select>
    </div>

    <div>
        <label for="sizeFree">汎用サイズを選択:</label>
        <select name="sizeFree" id="sizeFree" onchange="toggleSizeFields()">
        <option value="0" {{ request('sizeFree') == '0' ? 'selected' : '' }}>汎用サイズ</option>

        <!-- 軽自動車 -->
        <option value="155/65R14" {{ request('sizeFree') == '155/65R14' ? 'selected' : '' }}>155/65R14</option>
        <option value="165/55R15" {{ request('sizeFree') == '165/55R15' ? 'selected' : '' }}>165/55R15</option>
        <option value="145/80R13" {{ request('sizeFree') == '145/80R13' ? 'selected' : '' }}>145/80R13</option>
        <option value="155/55R14" {{ request('sizeFree') == '155/55R14' ? 'selected' : '' }}>155/55R14</option>

        <!-- コンパクトカー -->
        <option value="175/65R15" {{ request('sizeFree') == '175/65R15' ? 'selected' : '' }}>175/65R15</option>
        <option value="185/60R15" {{ request('sizeFree') == '185/60R15' ? 'selected' : '' }}>185/60R15</option>
        <option value="185/55R16" {{ request('sizeFree') == '185/55R16' ? 'selected' : '' }}>185/55R16</option>
        <option value="195/65R15" {{ request('sizeFree') == '195/65R15' ? 'selected' : '' }}>195/65R15</option>

        <!-- セダン -->
        <option value="205/60R16" {{ request('sizeFree') == '205/60R16' ? 'selected' : '' }}>205/60R16</option>
        <option value="215/55R17" {{ request('sizeFree') == '215/55R17' ? 'selected' : '' }}>215/55R17</option>
        <option value="225/45R18" {{ request('sizeFree') == '225/45R18' ? 'selected' : '' }}>225/45R18</option>
        <option value="215/50R17" {{ request('sizeFree') == '215/50R17' ? 'selected' : '' }}>215/50R17</option>

        <!-- ミニバン -->
        <option value="195/65R15" {{ request('sizeFree') == '195/65R15' ? 'selected' : '' }}>195/65R15</option>
        <option value="205/60R16" {{ request('sizeFree') == '205/60R16' ? 'selected' : '' }}>205/60R16</option>
        <option value="215/60R16" {{ request('sizeFree') == '215/60R16' ? 'selected' : '' }}>215/60R16</option>
        <option value="225/55R17" {{ request('sizeFree') == '225/55R17' ? 'selected' : '' }}>225/55R17</option>

        <!-- SUV -->
        <option value="215/65R16" {{ request('sizeFree') == '215/65R16' ? 'selected' : '' }}>215/65R16</option>
        <option value="225/60R17" {{ request('sizeFree') == '225/60R17' ? 'selected' : '' }}>225/60R17</option>
        <option value="235/55R18" {{ request('sizeFree') == '235/55R18' ? 'selected' : '' }}>235/55R18</option>
        <option value="245/45R20" {{ request('sizeFree') == '245/45R20' ? 'selected' : '' }}>245/45R20</option>

        <!-- スポーツカー -->
        <option value="225/45R17" {{ request('sizeFree') == '225/45R17' ? 'selected' : '' }}>225/45R17</option>
        <option value="235/40R18" {{ request('sizeFree') == '235/40R18' ? 'selected' : '' }}>235/40R18</option>
        <option value="245/40R18" {{ request('sizeFree') == '245/40R18' ? 'selected' : '' }}>245/40R18</option>
        <option value="255/35R19" {{ request('sizeFree') == '255/35R19' ? 'selected' : '' }}>255/35R19</option>

        <!-- 商用車 -->
        <option value="195/80R15" {{ request('sizeFree') == '195/80R15' ? 'selected' : '' }}>195/80R15</option>
        <option value="185/75R15" {{ request('sizeFree') == '185/75R15' ? 'selected' : '' }}>185/75R15</option>
        <option value="175/80R14" {{ request('sizeFree') == '175/80R14' ? 'selected' : '' }}>175/80R14</option>
        <option value="205/70R15" {{ request('sizeFree') == '205/70R15' ? 'selected' : '' }}>205/70R15</option>
        </select>

        <label for="sizeKeyword">サイズを入力:</label>
        <input type="text" name="sizeKeyword" id="sizeKeyword" value="{{ request('sizeKeyword') }}" oninput="toggleSizeFields()">
    </div>
        <input type="radio" name="selectTire" value="夏タイヤ" {{ request('selectTire') == '夏タイヤ' ? 'checked' : '' }}>夏タイヤのみ
        <input type="radio" name="selectTire" value="夏タイヤAWセット" {{ request('selectTire') == '夏タイヤセット' ? 'checked' : '' }}>夏タイヤ AWセット
        <br>
        <input type="radio" name="selectTire" value="冬タイヤ" {{ request('selectTire') == '冬タイヤ' ? 'checked' : '' }}>冬タイヤのみ
        <input type="radio" name="selectTire" value="冬タイヤAWセット" {{ request('selectTire') == '冬タイヤセット' ? 'checked' : '' }}>冬タイヤ AWセット
        <br>
        <input type="radio" name="selectTire" value="オールシーズンタイヤ" {{ request('selectTire') == 'オールシーズンタイヤ' ? 'checked' : '' }}>オールシーズンタイヤのみ
        <input type="radio" name="selectTire" value="オールシーズンタイヤAWセット" {{ request('selectTire') == 'オールシーズンタイヤセット' ? 'checked' : '' }}>オールシーズンタイヤ AWセット
        <br>
        <button type="submit">PDFに送信</button>
    </form>
</div>

<script>
function updateCalculation() {
    calculateProduct(1);
    calculateProduct(2);
    calculateProduct(3);
    prepareFormData(); // 計算結果を隠しフィールドに設定

}

function calculateProduct(productNumber) {
    const cost = parseInt(document.getElementById(`cost${productNumber}`).value) || 0;
    const costMultiplier = parseInt(document.getElementById(`cost${productNumber}Multiplier`).value) || 1;
    const profitA = parseInt(document.getElementById('profitOptionA')?.value) || 0;
    const profitBMultiplier = parseFloat(document.getElementById('profitOptionB')?.value) || 1;

    // 原価が0の場合は計算せずに終了
    if (cost === 0) {
        document.getElementById(`profitTotal${productNumber}`).innerText = '0';
        document.getElementById(`wagesTotal${productNumber}`).innerText = '0';
        document.getElementById(`Total${productNumber}`).innerText = '0';
        document.getElementById(`TotalWithTax${productNumber}`).innerText = '0';
        return; // ここで終了
    }

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


function prepareFormData() {
    for (let i = 1; i <= 3; i++) {
        const profitTotal = document.getElementById(`profitTotal${i}`).innerText.replace(/,/g, '');
        const hiddenProfitTotal = document.getElementById(`hiddenProfitTotal${i}`);
        const hiddenWagesTotal = document.getElementById(`hiddenWagesTotal${i}`);
        const hiddenTotal = document.getElementById(`hiddenTotal${i}`);
        const hiddenTotalWithTax = document.getElementById(`hiddenTotalWithTax${i}`);

        if (profitTotal > 0) {
            // profitTotalが0より大きい場合、値を設定
            hiddenProfitTotal.value = profitTotal;
            hiddenWagesTotal.value = document.getElementById(`wagesTotal${i}`).innerText.replace(/,/g, '');
            hiddenTotal.value = document.getElementById(`Total${i}`).innerText.replace(/,/g, '');
            hiddenTotalWithTax.value = document.getElementById(`TotalWithTax${i}`).innerText.replace(/,/g, '');

            // name属性を再設定（必要に応じて）
            hiddenProfitTotal.setAttribute('name', `productData[${i}][profitTotal]`);
            hiddenWagesTotal.setAttribute('name', `productData[${i}][wagesTotal]`);
            hiddenTotal.setAttribute('name', `productData[${i}][taxExcludedTotal]`);
            hiddenTotalWithTax.setAttribute('name', `productData[${i}][taxIncludedTotal]`);
        } else {
            // profitTotalが0の場合、name属性を削除して送信しない
            hiddenProfitTotal.removeAttribute('name');
            hiddenWagesTotal.removeAttribute('name');
            hiddenTotal.removeAttribute('name');
            hiddenTotalWithTax.removeAttribute('name');
        }
    }
}

// フォーム送信時にprepareFormDataを呼び出す
document.querySelector('form').addEventListener('submit', (event) => {
    prepareFormData();
});



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

function prepareFormData() {
    for (let i = 1; i <= 3; i++) {
        document.getElementById(`hiddenProfitTotal${i}`).value = document.getElementById(`profitTotal${i}`).innerText.replace(/,/g, '');
        document.getElementById(`hiddenWagesTotal${i}`).value = document.getElementById(`wagesTotal${i}`).innerText.replace(/,/g, '');
        document.getElementById(`hiddenTotal${i}`).value = document.getElementById(`Total${i}`).innerText.replace(/,/g, '');
        document.getElementById(`hiddenTotalWithTax${i}`).value = document.getElementById(`TotalWithTax${i}`).innerText.replace(/,/g, '');
    }
}

</script>
