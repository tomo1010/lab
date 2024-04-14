{{--検索BOX--}}
<form class="input-group col-md-5" action="{{ route('baby.result')}}" method="GET"> 
  <input type="search" name="keyword" class="form-control input-group-prepend" placeholder="キーワード"></input>
  <span class="input-group-btn input-group-append">
    <input type="submit" class="btn btn-primary"  value="検索">
  </span>
</form>

<table class="table table-striped">
            <thead>
                <tr>
                    <th>車名</th>
                    <th></th>                              
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)

                <tr>
                    <td>
                        <img src="{{ $item['mediumImageUrls'] }}">
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ $item['itemName'] }}
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>


