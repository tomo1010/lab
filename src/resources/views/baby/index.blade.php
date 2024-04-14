{{--検索BOX--}}
                <form class="input-group col-md-5" action="{{ route('baby.result')}}" method="GET"> 
                  <input type="search" name="keyword" class="form-control input-group-prepend" placeholder="キーワード"></input>
                  <span class="input-group-btn input-group-append">
                    <input type="submit" class="btn btn-primary"  value="検索">
                  </span>
                </form>