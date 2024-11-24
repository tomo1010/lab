<form action="{{ route('tire.searchResult') }}" method="POST">

    @csrf
        <label for="sizeA">サイズを選択:</label>
        <select name="sizeA" id="sizeA" onchange="toggleSizeFields()">
          <option value="0">選択してください</option>
          <option value="155/">155</option>
          <option value="200/">200</option>
          <option value="205/">205</option>
        </select>

        <label for="sizeB">サイズを選択:</label>
        <select name="sizeB" id="sizeB" onchange="toggleSizeFields()">
          <option value="0">選択してください</option>
          <option value="55">55</option>
          <option value="65">65</option>
          <option value="70">70</option>
        </select>

        <label for="sizeC">サイズを選択:</label>
        <select name="sizeC" id="sizeC" onchange="toggleSizeFields()">
          <option value="0">選択してください</option>
          <option value="R14">14</option>
          <option value="R15">15</option>
          <option value="R16">16</option>
        </select>
<br>
        <label for="sizeFree">サイズを選択:</label>
        <select name="sizeFree" id="sizeFree" onchange="toggleSizeFields()">
          <option value="0">汎用サイズ</option>
          <option value="155/65R14">155/65R14</option>
          <option value="195/65R15">195/65R15</option>
        </select>
<hr>
        <label for="maker">メーカーを選択:</label>
        <select name="maker" id="maker">
          <option value="">選択してください</option>
          <option value="ブリヂストン">ブリヂストン</option>
          <option value="トーヨー">トーヨー</option>
        </select>
<hr>
        <input type="radio" name="selectTire" value="サマータイヤ">サマータイヤ
        <input type="radio" name="selectTire" value="サマータイヤ セット" checked>サマータイヤ セット
        <br>
        <input type="radio" name="selectTire" value="スタッドレス">スタッドレスタイヤ
        <input type="radio" name="selectTire" value="スタッドレス セット" checked>スタッドレスタイヤ セット

      <!-- 送信ボタン --> 
</br>
      <button type="submit">検索結果へ</button>

</form>
