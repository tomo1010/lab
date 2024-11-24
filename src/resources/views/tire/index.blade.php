@include('tire.commons.search')


<hr>
使い方
<hr>

<div>
  <form action="{{ route('tire.setPdf') }}" method="post">
    <!-- 送信ボタン -->
    <button type="submit">設定画面へ</button>

    @csrf
    <div>
      @foreach ($items as $item)
        <div>
          <div>
            <a href="{{ $item['itemUrl'] }}">
              <img src="{{ $item['mediumImageUrls'][0]['imageUrl'] }}" alt="Product Image">
            </a>
            <div>
              <!-- チェックボックス -->
              <input type="checkbox" name="itemCodes[]" value="{{ $item['itemCode'] }}" class="limit-checkbox">
              <p>{{ $item['itemPrice'] }}円 {{ $item['reviewCount'] }}件</p>
              <div>
                <span>{{ $item['catchcopy'] }}{{ $item['itemName'] }}</span>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </form>
</div>



<script>
  function toggleSizeFields() {
    const sizeA = document.getElementById('sizeA');
    const sizeB = document.getElementById('sizeB');
    const sizeC = document.getElementById('sizeC');
    const sizeFree = document.getElementById('sizeFree');

    const isSizeSelected = sizeA.value !== "0" || sizeB.value !== "0" || sizeC.value !== "0";
    const isSizeFreeSelected = sizeFree.value !== "0";

    // sizeFreeが選択された場合はsizeA, sizeB, sizeCを無効化
    sizeA.disabled = isSizeFreeSelected;
    sizeB.disabled = isSizeFreeSelected;
    sizeC.disabled = isSizeFreeSelected;

    // sizeA, sizeB, sizeCが選択された場合はsizeFreeを無効化
    sizeFree.disabled = isSizeSelected;
  }
</script>
