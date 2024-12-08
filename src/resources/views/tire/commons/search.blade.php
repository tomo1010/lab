<form action="{{ route('tire.searchResult') }}" method="POST">
    @csrf
    <label for="sizeA">サイズを選択:</label>
    <select name="sizeA" id="sizeA" onchange="toggleSizeFields()">
        <option value="0" {{ request('sizeA') == '0' ? 'selected' : '' }}>選択してください</option>
        <option value="155/" {{ request('sizeA') == '155/' ? 'selected' : '' }}>155</option>
        <option value="200/" {{ request('sizeA') == '200/' ? 'selected' : '' }}>200</option>
        <option value="205/" {{ request('sizeA') == '205/' ? 'selected' : '' }}>205</option>
    </select>

    <label for="sizeB">/</label>
    <select name="sizeB" id="sizeB" onchange="toggleSizeFields()">
        <option value="0" {{ request('sizeB') == '0' ? 'selected' : '' }}>選択してください</option>
        <option value="55" {{ request('sizeB') == '55' ? 'selected' : '' }}>55</option>
        <option value="65" {{ request('sizeB') == '65' ? 'selected' : '' }}>65</option>
        <option value="70" {{ request('sizeB') == '70' ? 'selected' : '' }}>70</option>
    </select>

    <label for="sizeC">R</label>
    <select name="sizeC" id="sizeC" onchange="toggleSizeFields()">
        <option value="0" {{ request('sizeC') == '0' ? 'selected' : '' }}>選択してください</option>
        <option value="R14" {{ request('sizeC') == 'R14' ? 'selected' : '' }}>14</option>
        <option value="R15" {{ request('sizeC') == 'R15' ? 'selected' : '' }}>15</option>
        <option value="R16" {{ request('sizeC') == 'R16' ? 'selected' : '' }}>16</option>
    </select>
    <br>

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

    <hr>

    <select name="maker" id="maker">
    <option value="" {{ request('maker') == '' ? 'selected' : '' }}>選択してください</option>
    <option value="1002426" {{ request('maker') == '1002426' ? 'selected' : '' }}>ブリヂストン</option>
    <option value="1004244" {{ request('maker') == '1004244' ? 'selected' : '' }}>ダンロップ</option>
    <option value="1002909" {{ request('maker') == '1002909' ? 'selected' : '' }}>トーヨータイヤ</option>
    <option value="1002908" {{ request('maker') == '1002908' ? 'selected' : '' }}>ピレリ</option>
    <option value="1002907" {{ request('maker') == '1002907' ? 'selected' : '' }}>ヨコハマ</option>
    <option value="1009464" {{ request('maker') == '1009464' ? 'selected' : '' }}>グッドイヤー</option>
    <option value="1002905" {{ request('maker') == '1002905' ? 'selected' : '' }}>ミシュラン</option>
</select>

    <hr>

    <input type="radio" name="selectTire" value="サマータイヤ" {{ request('selectTire') == 'サマータイヤ' ? 'checked' : '' }}>サマータイヤ
    <input type="radio" name="selectTire" value="サマータイヤ セット" {{ request('selectTire') == 'サマータイヤ セット' ? 'checked' : '' }}>サマータイヤ セット
    <br>
    <input type="radio" name="selectTire" value="スタッドレス" {{ request('selectTire') == 'スタッドレス' ? 'checked' : '' }}>スタッドレスタイヤ
    <input type="radio" name="selectTire" value="スタッドレス セット" {{ request('selectTire') == 'スタッドレス セット' ? 'checked' : '' }}>スタッドレスタイヤ セット
    <br>
    <button type="submit">検索結果へ</button>　<a href="{{ route('tire.index') }}">リセット</a>
</form>

