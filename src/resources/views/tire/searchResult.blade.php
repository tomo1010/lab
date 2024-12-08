@include('tire.commons.search')

{{$keyword}}：{{$count}}件取得


<!-- ソートボタン -->
<div style="margin-bottom: 20px;">
    <span>ソート:</span>
    <a href="{{ route('tire.searchResult', array_merge(request()->all(), ['sort' => '+itemPrice'])) }}" 
       style="padding: 5px 10px; text-decoration: none; background-color: #ccc; color: white; border-radius: 3px;">
        価格昇順
    </a>
    <a href="{{ route('tire.searchResult', array_merge(request()->all(), ['sort' => '-itemPrice'])) }}" 
       style="padding: 5px 10px; text-decoration: none; background-color: #ccc; color: white; border-radius: 3px;">
        価格降順
    </a>
</div>

<!-- ページネーション -->
@if(isset($items['pageCount']) && $items['pageCount'] > 1)
    <div style="margin-top: 20px;">
        <ul style="list-style: none; display: flex; padding: 0;">

            {{-- 前へリンク --}}
            @if($page > 10)
                <li style="margin-right: 5px;">
                    <a href="{{ route('tire.searchResult', array_merge(request()->all(), ['page' => max(1, $page - 10)])) }}" 
                       style="padding: 5px 10px; text-decoration: none; background-color: #ccc; color: white; border-radius: 3px;">
                        前へ
                    </a>
                </li>
            @endif

            {{-- ページ番号リンク --}}
            @php
                $startPage = max(1, $page - ($page % 10 == 0 ? 9 : $page % 10 - 1));
                $endPage = min($items['pageCount'], $startPage + 9);
            @endphp

            @for($i = $startPage; $i <= $endPage; $i++)
                <li style="margin-right: 5px;">
                    <a href="{{ route('tire.searchResult', array_merge(request()->all(), ['page' => $i])) }}" 
                       style="padding: 5px 10px; text-decoration: none; background-color: {{ $i == $page ? '#007bff' : '#ccc' }}; color: white; border-radius: 3px;">
                        {{ $i }}
                    </a>
                </li>
            @endfor

            {{-- 次へリンク --}}
            @if($page + 10 <= $items['pageCount'])
                <li style="margin-right: 5px;">
                    <a href="{{ route('tire.searchResult', array_merge(request()->all(), ['page' => min($items['pageCount'], $page + 10)])) }}" 
                       style="padding: 5px 10px; text-decoration: none; background-color: #ccc; color: white; border-radius: 3px;">
                        次へ
                    </a>
                </li>
            @endif

        </ul>
    </div>
@endif




<div>
  <form action="{{ route('tire.setPdf') }}" method="post">
      @csrf

      <!-- $keyword を送信するための隠しフィールド -->
      <input type="hidden" name="keyword" value="{{ $keyword }}">

      <!-- 送信ボタン -->
      <button type="submit">設定画面へ</button>

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
