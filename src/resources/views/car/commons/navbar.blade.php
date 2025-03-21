<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">

        {{-- ハンバーガーメニュー --}}
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- メニュー項目 --}}
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                
                {{-- 一覧へのリンク--}}                
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">その他のジャンル</a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'minivan']) }}">ミニバン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'puchivan']) }}">プチバン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'suv']) }}">SUV</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'hatchback']) }}">ハッチバック</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'wagon']) }}">ステーションワゴン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'sedan']) }}">セダン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'sports']) }}">スポーツカー</a></li>
                        <li class="dropdown-divider"></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei']) }}">軽自動車</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei_wagon']) }}">軽ワゴン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei_heightwagon']) }}">軽ハイトワゴン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei_slide']) }}">軽スライドドア</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei_sedan']) }}">軽セダン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei_sports']) }}">軽スポーツ</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei_suv']) }}">軽SUV</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei_truck']) }}">軽トラック</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei_hako']) }}">軽箱（ケッパコ）</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei_hakowagon']) }}">軽箱ワゴン</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'kei_heightvan']) }}">軽ハイトバン</a></li>
                        <li class="dropdown-divider"></li>
                        <div class="dropdown-divider"></div>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'longseler']) }}">ロングセラー</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'suv_3rd']) }}">3列シートSUV</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'3year']) }}">新車から3年落ち</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'5year']) }}">新車から5年落ち</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"><a href="{{ route('car.genre', ['genre'=>'7year']) }}">新車から7年落ち</a></li>
                        <li class="dropdown-divider"></li>
                    </ul>
                </li>

    </nav>

    @include('car.commons.header')


</header>

        {{--国産車のみ表示非表示のチェックBOX--}}
        <p style="text-align: right">
        <input type="checkbox" name="import" value="1" onchange="myfunc(this.value)"  {{ request()->input('import') ? 'checked' : '' }}/> 輸入車含む　 
        </p>

        {{--国産車のみをコントローラへ渡す処理--}}
        <script>
            function myfunc(value) {
                let element = document.getElementsByName('import');
                if (element[0].checked) {
                    location.href = location.pathname + '?import=1';
                } else {
                    location.href = location.pathname;
                }
            }
        </script>

