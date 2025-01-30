<h1>タイヤ代の計算機・見積りサイト</h1>

<div>
    <form action="{{ route('tirecalc.createPdf') }}" method="POST">
        @csrf

        <!-- $comment を送信するための隠しフィールド -->
        <input type="hidden" name="comment" value="{{ $comment }}">

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
        <!-- 消費税 -->
        <input type="hidden" name="productData[1][tax]" id="hiddenTax1">
        <input type="hidden" name="productData[2][tax]" id="hiddenTax2">
        <input type="hidden" name="productData[3][tax]" id="hiddenTax3">



        <h2>商品１</h2>
        <div>
            <label for="cost1">原価を入力:</label>
            <input type="number" name="cost1" id="cost1" placeholder="0" onchange="updateCalculation()">
            <label for="cost1Multiplier">:</label>
            <select name="cost1Multiplier" id="cost1Multiplier" onchange="updateCalculation()">
                <option value="1">×1</option>
                <option value="2">×2</option>
                <option value="3">×3</option>
                <option value="4">×4</option>
            </select>
        </div>

        <div>
            <p>商品代金: <span id="profitTotal1">0</span> 円（粗利: <span id="grossProfit1">0</span> 円）</p>
            <p>工賃合計: <span id="wagesTotal1">0</span> 円</p>
            <p>税抜合計: <span id="Total1">0</span> 円
            <p><b>税込合計: <span id="TotalWithTax1">0</span> 円</b>（内消費税: <span id="tax1">0</span> 円）</p>
        </div>

        <h2>商品２</h2>
        <div>
            <label for="cost2">原価を入力:</label>
            <input type="number" name="cost2" id="cost2" placeholder="0" onchange="updateCalculation()">
            <label for="cost2Multiplier">:</label>
            <select name="cost2Multiplier" id="cost2Multiplier" onchange="updateCalculation()">
                <option value="1">×1</option>
                <option value="2">×2</option>
                <option value="3">×3</option>
                <option value="4">×4</option>
            </select>
        </div>

        <div>
            <p>商品代金: <span id="profitTotal2">0</span> 円（粗利: <span id="grossProfit2">0</span> 円）</p>
            <p>工賃合計: <span id="wagesTotal2">0</span> 円</p>
            <p>税抜合計: <span id="Total2">0</span> 円</p>
            <p><b>税込合計: <span id="TotalWithTax2">0</span> 円</b>（内消費税: <span id="tax2">0</span> 円）</p>
        </div>

        <h2>商品３</h2>
        <div>
            <label for="cost3">原価を入力:</label>
            <input type="number" name="cost3" id="cost3" placeholder="0" onchange="updateCalculation()">
            <label for="cost3Multiplier">:</label>
            <select name="cost3Multiplier" id="cost3Multiplier" onchange="updateCalculation()">
                <option value="1">×1</option>
                <option value="2">×2</option>
                <option value="3">×3</option>
                <option value="4">×4</option>
            </select>
        </div>

        <div>
            <p>商品代金: <span id="profitTotal3">0</span> 円（粗利: <span id="grossProfit3">0</span> 円）</p>
            <p>工賃合計: <span id="wagesTotal3">0</span> 円</p>
            <p>税抜合計: <span id="Total3">0</span> 円</p>
            <p><b>税込合計: <span id="TotalWithTax3">0</span> 円</b>（内消費税: <span id="tax3">0</span> 円）</p>
        </div>

    </div>

    <hr>
    <h2>粗利設定</h2>
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

    <h2>工賃その他設定</h2>
    <!-- 工賃入力項目 -->
    <div>
        <label for="set1">組替えバランス工賃を入力:</label>
        <input type="number" name="set1" id="set1" placeholder="0" onchange="updateCalculation()">
        <label for="set1Multiplier">:</label>
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
        <label for="set2Multiplier">:</label>
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
        <label for="set3Multiplier">:</label>
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
        <label for="set4Multiplier">:</label>
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
        <label for="set5Multiplier">:</label>
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
        <label for="set6Multiplier">:</label>
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
        <label for="set7Multiplier">:</label>
        <select name="set7Multiplier" id="set7Multiplier" onchange="updateCalculation()">
            <option value="1">×1</option>
            <option value="2">×2</option>
            <option value="3">×3</option>
            <option value="4">×4</option>
        </select>
    </div>
    <!-- 工賃の設定をクリアするボタン -->
    <div>
        <button type="button" onclick="clearWagesSettings()">工賃設定をクリア</button>
    </div>
    <div>
        <input type="checkbox" id="saveToCookie" onchange="saveSettingsToCookie()"> 設定を保存
    </div>
<hr>
    <h2>印刷設定</h2>
    <div>
        <h3>タイトル</h3>
        <input type="radio" name="selectTire" value="夏タイヤ" {{ request('selectTire') == 'summer' ? 'checked' : '' }}>夏タイヤのみ
        <input type="radio" name="selectTire" value="夏タイヤAWセット" {{ request('selectTire') == 'summerSet' ? 'checked' : '' }}>夏タイヤ AWセット
        <br>
        <input type="radio" name="selectTire" value="冬タイヤ" {{ request('selectTire') == 'studless' ? 'checked' : '' }}>冬タイヤのみ
        <input type="radio" name="selectTire" value="冬タイヤAWセット" {{ request('selectTire') == 'studlessSet' ? 'checked' : '' }}>冬タイヤ AWセット
        <br>
        <input type="radio" name="selectTire" value="オールシーズンタイヤ" {{ request('selectTire') == 'allseasen' ? 'checked' : '' }}>オールシーズンタイヤのみ
        <input type="radio" name="selectTire" value="オールシーズンタイヤAWセット" {{ request('selectTire') == 'allseasenSet' ? 'checked' : '' }}>オールシーズンタイヤ AWセット
        <br>
        <input type="radio" name="selectTire" value="AWのみ" {{ request('selectTire') == 'allseasen' ? 'checked' : '' }}>AWのみ
    </div>    

    <div>
        <h3>メーカー</h3>
        <select name="maker1" id="maker1">
            <option value="" {{ request('maker1') == '' ? 'selected' : '' }}>商品１</option>
            <option value="国産メーカー" {{ request('maker1') == '国産メーカー' ? 'selected' : '' }}>国産メーカー</option>
            <option value="輸入メーカー" {{ request('maker1') == '輸入メーカー' ? 'selected' : '' }}>輸入メーカー</option>
            <option value="アジアンタイヤ" {{ request('maker1') == 'アジアンタイヤ' ? 'selected' : '' }}>アジアンタイヤ</option>
            <option value="ブリヂストン" {{ request('maker1') == 'ブリヂストン' ? 'selected' : '' }}>ブリヂストン</option>
            <option value="ダンロップ" {{ request('maker1') == 'ダンロップ' ? 'selected' : '' }}>ダンロップ</option>
            <option value="ヨコハマ" {{ request('maker1') == 'ヨコハマ' ? 'selected' : '' }}>ヨコハマ</option>
            <option value="トーヨータイヤ" {{ request('maker1') == 'トーヨータイヤ' ? 'selected' : '' }}>トーヨータイヤ</option>
            <option value="ファルケン" {{ request('maker1') == 'ファルケン' ? 'selected' : '' }}>ファルケン</option>
            <option value="グッドイヤー" {{ request('maker1') == 'グッドイヤー' ? 'selected' : '' }}>グッドイヤー</option>
            <option value="ミシュラン" {{ request('maker1') == 'ミシュラン' ? 'selected' : '' }}>ミシュラン</option>
            <option value="ピレリ" {{ request('maker1') == 'ピレリ' ? 'selected' : '' }}>ピレリ</option>
            <option value="コンチネンタル" {{ request('maker1') == 'コンチネンタル' ? 'selected' : '' }}>コンチネンタル</option>
            <option value="ナンカン" {{ request('maker1') == 'ナンカン' ? 'selected' : '' }}>ナンカン</option>
            <option value="ハンコック" {{ request('maker1') == 'ハンコック' ? 'selected' : '' }}>ハンコック</option>
            <option value="クムホ" {{ request('maker1') == 'クムホ' ? 'selected' : '' }}>クムホ</option>
            <option value="マキシス" {{ request('maker1') == 'マキシス' ? 'selected' : '' }}>マキシス</option>
            <option value="ニットー" {{ request('maker1') == 'ニットー' ? 'selected' : '' }}>ニットー</option>
            <option value="ジーテックス" {{ request('maker1') == 'ジーテックス' ? 'selected' : '' }}>ジーテックス</option>
            <option value="トライアングル" {{ request('maker1') == 'トライアングル' ? 'selected' : '' }}>トライアングル</option>
        </select>

        <br>
        <select name="maker2" id="maker2">
            <option value="" {{ request('maker2') == '' ? 'selected' : '' }}>商品２</option>
            <option value="" {{ request('maker1') == '' ? 'selected' : '' }}>商品１</option>
            <option value="国産メーカー" {{ request('maker1') == '国産メーカー' ? 'selected' : '' }}>国産メーカー</option>
            <option value="輸入メーカー" {{ request('maker1') == '輸入メーカー' ? 'selected' : '' }}>輸入メーカー</option>
            <option value="アジアンタイヤ" {{ request('maker1') == 'アジアンタイヤ' ? 'selected' : '' }}>アジアンタイヤ</option>
            <option value="ブリヂストン" {{ request('maker1') == 'ブリヂストン' ? 'selected' : '' }}>ブリヂストン</option>
            <option value="ダンロップ" {{ request('maker1') == 'ダンロップ' ? 'selected' : '' }}>ダンロップ</option>
            <option value="ヨコハマ" {{ request('maker1') == 'ヨコハマ' ? 'selected' : '' }}>ヨコハマ</option>
            <option value="トーヨータイヤ" {{ request('maker1') == 'トーヨータイヤ' ? 'selected' : '' }}>トーヨータイヤ</option>
            <option value="ファルケン" {{ request('maker1') == 'ファルケン' ? 'selected' : '' }}>ファルケン</option>
            <option value="グッドイヤー" {{ request('maker1') == 'グッドイヤー' ? 'selected' : '' }}>グッドイヤー</option>
            <option value="ミシュラン" {{ request('maker1') == 'ミシュラン' ? 'selected' : '' }}>ミシュラン</option>
            <option value="ピレリ" {{ request('maker1') == 'ピレリ' ? 'selected' : '' }}>ピレリ</option>
            <option value="コンチネンタル" {{ request('maker1') == 'コンチネンタル' ? 'selected' : '' }}>コンチネンタル</option>
            <option value="ナンカン" {{ request('maker1') == 'ナンカン' ? 'selected' : '' }}>ナンカン</option>
            <option value="ハンコック" {{ request('maker1') == 'ハンコック' ? 'selected' : '' }}>ハンコック</option>
            <option value="クムホ" {{ request('maker1') == 'クムホ' ? 'selected' : '' }}>クムホ</option>
            <option value="マキシス" {{ request('maker1') == 'マキシス' ? 'selected' : '' }}>マキシス</option>
            <option value="ニットー" {{ request('maker1') == 'ニットー' ? 'selected' : '' }}>ニットー</option>
            <option value="ジーテックス" {{ request('maker1') == 'ジーテックス' ? 'selected' : '' }}>ジーテックス</option>
            <option value="トライアングル" {{ request('maker1') == 'トライアングル' ? 'selected' : '' }}>トライアングル</option>
        </select>
        <br>
        <select name="maker3" id="maker3">
            <option value="" {{ request('maker3') == '' ? 'selected' : '' }}>商品３</option>
            <option value="" {{ request('maker1') == '' ? 'selected' : '' }}>商品１</option>
            <option value="国産メーカー" {{ request('maker1') == '国産メーカー' ? 'selected' : '' }}>国産メーカー</option>
            <option value="輸入メーカー" {{ request('maker1') == '輸入メーカー' ? 'selected' : '' }}>輸入メーカー</option>
            <option value="アジアンタイヤ" {{ request('maker1') == 'アジアンタイヤ' ? 'selected' : '' }}>アジアンタイヤ</option>
            <option value="ブリヂストン" {{ request('maker1') == 'ブリヂストン' ? 'selected' : '' }}>ブリヂストン</option>
            <option value="ダンロップ" {{ request('maker1') == 'ダンロップ' ? 'selected' : '' }}>ダンロップ</option>
            <option value="ヨコハマ" {{ request('maker1') == 'ヨコハマ' ? 'selected' : '' }}>ヨコハマ</option>
            <option value="トーヨータイヤ" {{ request('maker1') == 'トーヨータイヤ' ? 'selected' : '' }}>トーヨータイヤ</option>
            <option value="ファルケン" {{ request('maker1') == 'ファルケン' ? 'selected' : '' }}>ファルケン</option>
            <option value="グッドイヤー" {{ request('maker1') == 'グッドイヤー' ? 'selected' : '' }}>グッドイヤー</option>
            <option value="ミシュラン" {{ request('maker1') == 'ミシュラン' ? 'selected' : '' }}>ミシュラン</option>
            <option value="ピレリ" {{ request('maker1') == 'ピレリ' ? 'selected' : '' }}>ピレリ</option>
            <option value="コンチネンタル" {{ request('maker1') == 'コンチネンタル' ? 'selected' : '' }}>コンチネンタル</option>
            <option value="ナンカン" {{ request('maker1') == 'ナンカン' ? 'selected' : '' }}>ナンカン</option>
            <option value="ハンコック" {{ request('maker1') == 'ハンコック' ? 'selected' : '' }}>ハンコック</option>
            <option value="クムホ" {{ request('maker1') == 'クムホ' ? 'selected' : '' }}>クムホ</option>
            <option value="マキシス" {{ request('maker1') == 'マキシス' ? 'selected' : '' }}>マキシス</option>
            <option value="ニットー" {{ request('maker1') == 'ニットー' ? 'selected' : '' }}>ニットー</option>
            <option value="ジーテックス" {{ request('maker1') == 'ジーテックス' ? 'selected' : '' }}>ジーテックス</option>
            <option value="トライアングル" {{ request('maker1') == 'トライアングル' ? 'selected' : '' }}>トライアングル</option>
        </select>
    </div>

    <div>
        <h3>タイヤサイズ</h3>
        <label for="sizeGeneral"></label>
        <select name="sizeGeneral" id="sizeGeneral" onchange="toggleSizeFields()">
        <option value="0" {{ request('sizeGeneral') == '0' ? 'selected' : '' }}>汎用サイズ</option>

        <!-- 軽自動車 -->
        <option value="0" {{ request('sizeGeneral') == '0' ? 'selected' : '' }}>▼軽自動車</option>
        <option value="155/65R14" {{ request('sizeGeneral') == '155/65R14' ? 'selected' : '' }}>155/65R14</option>
        <option value="165/55R15" {{ request('sizeGeneral') == '165/55R15' ? 'selected' : '' }}>165/55R15</option>
        <option value="145/80R13" {{ request('sizeGeneral') == '145/80R13' ? 'selected' : '' }}>145/80R13</option>
        <option value="155/55R14" {{ request('sizeGeneral') == '155/55R14' ? 'selected' : '' }}>155/55R14</option>

        <!-- ミニバン -->
        <option value="0" {{ request('sizeGeneral') == '0' ? 'selected' : '' }}>▼ミニバン</option>
        <option value="195/65R15" {{ request('sizeGeneral') == '195/65R15' ? 'selected' : '' }}>195/65R15</option>
        <option value="205/60R16" {{ request('sizeGeneral') == '205/60R16' ? 'selected' : '' }}>205/60R16</option>
        <option value="215/60R16" {{ request('sizeGeneral') == '215/60R16' ? 'selected' : '' }}>215/60R16</option>
        <option value="225/55R17" {{ request('sizeGeneral') == '225/55R17' ? 'selected' : '' }}>225/55R17</option>

        <!-- SUV -->
        <option value="0" {{ request('sizeGeneral') == '0' ? 'selected' : '' }}>▼SUV</option>
        <option value="215/65R16" {{ request('sizeGeneral') == '215/65R16' ? 'selected' : '' }}>215/65R16</option>
        <option value="225/60R17" {{ request('sizeGeneral') == '225/60R17' ? 'selected' : '' }}>225/60R17</option>
        <option value="235/55R18" {{ request('sizeGeneral') == '235/55R18' ? 'selected' : '' }}>235/55R18</option>
        <option value="245/45R20" {{ request('sizeGeneral') == '245/45R20' ? 'selected' : '' }}>245/45R20</option>

        <!-- コンパクトカー -->
        <option value="0" {{ request('sizeGeneral') == '0' ? 'selected' : '' }}>▼コンパクトカー</option>
        <option value="175/65R15" {{ request('sizeGeneral') == '175/65R15' ? 'selected' : '' }}>175/65R15</option>
        <option value="185/60R15" {{ request('sizeGeneral') == '185/60R15' ? 'selected' : '' }}>185/60R15</option>
        <option value="185/55R16" {{ request('sizeGeneral') == '185/55R16' ? 'selected' : '' }}>185/55R16</option>
        <option value="195/65R15" {{ request('sizeGeneral') == '195/65R15' ? 'selected' : '' }}>195/65R15</option>

        <!-- セダン -->
        <option value="0" {{ request('sizeGeneral') == '0' ? 'selected' : '' }}>▼セダン</option>
        <option value="205/60R16" {{ request('sizeGeneral') == '205/60R16' ? 'selected' : '' }}>205/60R16</option>
        <option value="215/55R17" {{ request('sizeGeneral') == '215/55R17' ? 'selected' : '' }}>215/55R17</option>
        <option value="225/45R18" {{ request('sizeGeneral') == '225/45R18' ? 'selected' : '' }}>225/45R18</option>
        <option value="215/50R17" {{ request('sizeGeneral') == '215/50R17' ? 'selected' : '' }}>215/50R17</option>

        <!-- スポーツカー -->
        <option value="0" {{ request('sizeGeneral') == '0' ? 'selected' : '' }}>▼スポーツ</option>
        <option value="225/45R17" {{ request('sizeGeneral') == '225/45R17' ? 'selected' : '' }}>225/45R17</option>
        <option value="235/40R18" {{ request('sizeGeneral') == '235/40R18' ? 'selected' : '' }}>235/40R18</option>
        <option value="245/40R18" {{ request('sizeGeneral') == '245/40R18' ? 'selected' : '' }}>245/40R18</option>
        <option value="255/35R19" {{ request('sizeGeneral') == '255/35R19' ? 'selected' : '' }}>255/35R19</option>

        <!-- 商用車 -->
        <option value="0" {{ request('sizeGeneral') == '0' ? 'selected' : '' }}>▼商用車</option>
        <option value="195/80R15" {{ request('sizeGeneral') == '195/80R15' ? 'selected' : '' }}>195/80R15</option>
        <option value="185/75R15" {{ request('sizeGeneral') == '185/75R15' ? 'selected' : '' }}>185/75R15</option>
        <option value="175/80R14" {{ request('sizeGeneral') == '175/80R14' ? 'selected' : '' }}>175/80R14</option>
        <option value="205/70R15" {{ request('sizeGeneral') == '205/70R15' ? 'selected' : '' }}>205/70R15</option>
        </select>

        <label for="sizeFree">フリー入力</label>
        <input type="text" name="sizeFree" id="sizeFree" value="{{ request('sizeFree') }}" oninput="toggleSizeFields()">
       
    </div>

    <div>
        <h3>宛名</h3>
        <label for="address">宛名入力</label>
        <input type="text" name="address" id="address" value="{{ request('address') }}" >
        <select name="honorific" id="honorific" onchange="updateCalculation()">
            <option value="様">様</option>
            <option value="御中">御中</option>
        </select>
    </div>

    <div>
        <h3>コメント</h3>
        <label for="comment"></label>
        <textarea id="comment" name="comment" rows="5" cols="33">※総額には、工賃、廃棄タイヤ費用、消費税すべて含みます。
        </textarea>
    </div>
    
    <br>
    
    <div>
        <button type="submit">PDF印刷</button>
        <button type="button" onclick="copyToClipboard()">コピーする</button>
    </div>

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
        document.getElementById(`grossProfit${productNumber}`).innerText = '0'; 
        return; // ここで終了
    }

    const wagesTotal = calculateWagesTotal();
    const adjustedCost = cost * costMultiplier;

    const profitTotal = Math.floor((adjustedCost + profitA) * profitBMultiplier);
    const total = profitTotal + wagesTotal;
    const totalWithTax = Math.floor(total * 1.1);
    const tax = totalWithTax - total;
    const grossProfit = profitTotal - adjustedCost; // 粗利を計算

    document.getElementById(`profitTotal${productNumber}`).innerText = profitTotal.toLocaleString();
    document.getElementById(`wagesTotal${productNumber}`).innerText = wagesTotal.toLocaleString();
    document.getElementById(`Total${productNumber}`).innerText = total.toLocaleString();
    document.getElementById(`TotalWithTax${productNumber}`).innerText = totalWithTax.toLocaleString();
    document.getElementById(`tax${productNumber}`).innerText = tax.toLocaleString();
    document.getElementById(`grossProfit${productNumber}`).innerText = grossProfit.toLocaleString(); // 粗利を表示
}

function updateCalculation() {
    calculateProduct(1);
    calculateProduct(2);
    calculateProduct(3);
    prepareFormData(); // 隠しフィールドに値を設定
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
        const profitTotal = document.getElementById(`profitTotal${i}`).innerText.replace(/,/g, '') || 0;
        const wagesTotal = document.getElementById(`wagesTotal${i}`).innerText.replace(/,/g, '') || 0;
        const taxExcludedTotal = document.getElementById(`Total${i}`).innerText.replace(/,/g, '') || 0;
        const taxIncludedTotal = document.getElementById(`TotalWithTax${i}`).innerText.replace(/,/g, '') || 0;

        // 税額を計算
        const tax = taxIncludedTotal - taxExcludedTotal;

        // 隠しフィールドに値を設定
        document.getElementById(`hiddenProfitTotal${i}`).value = profitTotal;
        document.getElementById(`hiddenWagesTotal${i}`).value = wagesTotal;
        document.getElementById(`hiddenTotal${i}`).value = taxExcludedTotal;
        document.getElementById(`hiddenTotalWithTax${i}`).value = taxIncludedTotal;
        document.getElementById(`hiddenTax${i}`).value = tax; // 税額を設定

        // name 属性の設定（送信用）
        document.getElementById(`hiddenProfitTotal${i}`).setAttribute('name', `productData[${i}][profitTotal]`);
        document.getElementById(`hiddenWagesTotal${i}`).setAttribute('name', `productData[${i}][wagesTotal]`);
        document.getElementById(`hiddenTotal${i}`).setAttribute('name', `productData[${i}][taxExcludedTotal]`);
        document.getElementById(`hiddenTotalWithTax${i}`).setAttribute('name', `productData[${i}][taxIncludedTotal]`);
        document.getElementById(`hiddenTax${i}`).setAttribute('name', `productData[${i}][tax]`);
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
        alert('工賃設定が保存されました。');
    } else {
        document.cookie = `wageSettings=; path=/; max-age=0;`;
        alert('工賃設定が削除されました。');
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
        alert('工賃設定を読み込みました。');
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

function copyToClipboard() {
    // コピーするデータを取得
    const data = [
    //選択したタイヤ
    { label: '', value: document.querySelector('input[name="selectTire"]:checked')?.value || '' },
    //サイズ
    { label: 'サイズ：', value: document.getElementById('sizeGeneral')?.value || '' },
    { label: 'サイズ：', value: document.getElementById('sizeFree')?.value || '' },
    //商品１
    { label: '▼', value: document.getElementById('maker1')?.value || '' },
    { label: '', value: addYenSuffix(document.getElementById('TotalWithTax1')?.innerText || '') },
    //商品２
    { label: '▼', value: document.getElementById('maker2')?.value || '' },
    { label: '', value: addYenSuffix(document.getElementById('TotalWithTax2')?.innerText || '') },
    //商品３
    { label: '▼', value: document.getElementById('maker3')?.value || '' },
    { label: '', value: addYenSuffix(document.getElementById('TotalWithTax3')?.innerText || '') },
    //コメント
    { label: '', value: document.getElementById('comment')?.value.trim() || '' } 

];

// コピーボタンに"円"を追加する関数
function addYenSuffix(value) {
    // 値が空または0の場合はそのまま返す
    if (value === '' || value === '0') {
        return value;
    }
    // 値に "円" を追加して返す
    return `${value} 円`;
}

    // 0 や空文字の項目を除外
    const filteredData = data
        .filter(item => item.value !== '0' && item.value !== '' && item.value !== '未入力' && item.value !== '未選択')
        .map(item => `${item.label}${item.value}`);

    // コピーする内容が空の場合は通知して終了
    if (filteredData.length === 0) {
        alert('コピーするデータがありません。');
        return;
    }

    // コピーする内容を整形
    const copyText = filteredData.join('\n');

    // クリップボードにコピー
    navigator.clipboard.writeText(copyText).then(() => {
        alert('データをコピーしました！');
    }).catch(err => {
        alert('コピーに失敗しました。');
        console.error('コピーエラー:', err);
    });
}


function clearWagesSettings() {
    // 工賃と倍率のIDを列挙
    const wageFields = [
        { inputId: 'set1', multiplierId: 'set1Multiplier' },
        { inputId: 'set2', multiplierId: 'set2Multiplier' },
        { inputId: 'set3', multiplierId: 'set3Multiplier' },
        { inputId: 'set4', multiplierId: 'set4Multiplier' },
        { inputId: 'set5', multiplierId: 'set5Multiplier' },
        { inputId: 'set6', multiplierId: 'set6Multiplier' },
        { inputId: 'set7', multiplierId: 'set7Multiplier' }
    ];

    // 各フィールドをゼロにリセット
    wageFields.forEach(field => {
        document.getElementById(field.inputId).value = 0;
        document.getElementById(field.multiplierId).value = 1; // デフォルトの倍率にリセット
    });

    // 設定が変更されたので再計算を実行
    updateCalculation();

    alert('工賃設定をクリアしました。');
}

</script>
