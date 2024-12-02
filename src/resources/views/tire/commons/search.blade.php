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
        <option value="155/65R14" {{ request('sizeFree') == '155/65R14' ? 'selected' : '' }}>155/65R14</option>
        <option value="195/65R15" {{ request('sizeFree') == '195/65R15' ? 'selected' : '' }}>195/65R15</option>
    </select>
    <hr>

    <label for="maker">メーカーを選択:</label>
    <select name="maker" id="maker">
        <option value="" {{ request('maker') == '' ? 'selected' : '' }}>選択してください</option>
        <option value="1002426" {{ request('maker') == '1002426' ? 'selected' : '' }}>ブリヂストン</option>
        <option value="1002909" {{ request('maker') == '1002909' ? 'selected' : '' }}>トーヨー</option>
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

