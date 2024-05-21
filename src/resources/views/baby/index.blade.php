{{--検索BOX--}}
<form class="input-group col-md-5" action="{{ route('baby.result')}}" method="GET"> 
  <input type="search" name="keyword" class="form-control input-group-prepend" placeholder="キーワード"></input>
  <span class="input-group-btn input-group-append">
    <input type="submit" class="btn btn-primary"  value="検索">
  </span>
</form>

<p><a href="{{ route('baby.index',) }}">HOME</a>　<a href="{{ route('baby.type', ['type' => 'sticker',]) }}">ステッカータイプ</a>　マグネットタイプ　吸盤タイプ</p>

        <table class="table table-striped">
            <tbody>
                @foreach ($items as $item)

                <tr>
                    <td>
                        <img src="{{ $item['mediumImageUrls'][0]['imageUrl'] }}">
                    </td>

                    <td>
                    <a href="{{ $item['itemUrl'] }}">{{ $item['itemName'] }}</a>
                    </td>

                    <td>
                    {{ $item['itemPrice'] }}円<br>
                    {{ $item['reviewCount'] }}件<br>
                    </td>
                </tr>

                @endforeach

              </tbody>
        </table>
