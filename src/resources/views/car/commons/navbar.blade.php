@php
$genreStyles = [
'minivan' => ['bg-[#2981C0]', asset('img/car_genre_bunner/minivan.png')],
'puchivan' => ['bg-[#EF6C70]', asset('img/car_genre_bunner/puchivan.png')],
'suv' => ['bg-[#748300]', asset('img/car_genre_bunner/suv.png')],
'hatchback' => ['bg-[#FFAD35]', asset('img/car_genre_bunner/hatchback.png')],
'sedan' => ['bg-[#3E327B]', asset('img/car_genre_bunner/sedan.png')],
'wagon' => ['bg-[#90374E]', asset('img/car_genre_bunner/wagon.png')],
'sports' => ['bg-[#FE4500]', asset('img/car_genre_bunner/sports.png')],
'kei' => ['bg-[#E8C605]', null],
'kei_wagon' => ['bg-[#E8C605]', null],
'kei_heightwagon' => ['bg-[#E8C605]', null],
'kei_slide' => ['bg-[#E8C605]', null],
'kei_sedan' => ['bg-[#E8C605]', null],
'kei_sports' => ['bg-[#E8C605]', null],
'kei_suv' => ['bg-[#E8C605]', null],
'kei_truck' => ['bg-[#E8C605]', null],
'kei_hako' => ['bg-[#E8C605]', null],
'kei_hakowagon' => ['bg-[#E8C605]', null],
'kei_heightvan' => ['bg-[#E8C605]', null],
];

$safeGenre = $genre ?? '';
$bgClass = $genreStyles[$safeGenre][0] ?? 'bg-gray-500';
$logoUrl = $genreStyles[$safeGenre][1] ?? null;
@endphp

<header class="sticky top-0 z-50 mb-2 border-b border-gray-200 {{ $bgClass }}">
    <div class="bg-gray-650 text-white text-center py-2 text-sm">
        全メーカー全車種{{$count}}台比較ランキング
    </div>
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        {{-- ロゴ --}}
        <div class="flex items-center space-x-4">
            @if($logoUrl)
            <a href="{{ route('car.genre', ['genre' => $safeGenre]) }}">
                <img src="{{ $logoUrl }}" alt="{{ $safeGenre }} ロゴ" class="w-[150px] h-[36px] object-contain max-w-none flex-shrink-0" />
            </a>
            @else
            {{-- テキストタイトル --}}
            @php
            $labels = [
            'kei' => '軽自動車',
            'kei_wagon' => '軽ワゴン', 'kei_heightwagon' => '軽ハイトワゴン', 'kei_slide' => '軽スライドドア',
            'kei_sedan' => '軽セダン', 'kei_sports' => '軽スポーツ', 'kei_suv' => '軽SUV', 'kei_truck' => '軽トラック',
            'kei_hako' => '軽箱（ケッパコ）', 'kei_hakowagon' => '軽箱ワゴン', 'kei_heightvan' => '軽ハイトバン',
            'longseler' => 'ロングセラー', 'suv_3rd' => '3列シートSUV',
            'headlight' => '丸目ヘッドライト', 'oem' => 'OEM', 'compact' => 'コンパクトカー', '2door_courpe' => '２ドアクーペ', 'familly' => 'ファミリーカー',
            '3year' => '新車から3年落ち', '5year' => '新車から5年落ち', '7year' => '新車から7年落ち',
            ];
            $currentLabel = $labels[$safeGenre] ?? null;
            @endphp

            @if($currentLabel)
            <div class="mb-2">
                <a href="{{ route('car.genre', ['genre' => $safeGenre]) }}" class="text-lg font-semibold text-white">
                    {{ $currentLabel }}比較サイト
                </a>
            </div>
            @endif
            @endif
        </div>

        {{-- ハンバーガーメニュー --}}
        <div class="relative inline-block text-left">
            <button id="hamburgerButton" type="button"
                class="inline-flex justify-center items-center gap-1 px-4 py-2 text-sm font-medium text-white hover:text-black border border-white rounded-md shadow-sm hover:bg-white hover:bg-opacity-20 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <div id="hamburgerMenu"
                class="hidden absolute right-0 z-10 mt-2 w-64 max-h-96 overflow-y-auto rounded-md bg-white shadow-lg border border-gray-200">
                <ul class="py-1 text-sm text-gray-700">
                    @foreach ([
                    'minivan' => 'ミニバン', 'puchivan' => 'プチバン', 'suv' => 'SUV', 'hatchback' => 'ハッチバック',
                    'wagon' => 'ステーションワゴン', 'sedan' => 'セダン', 'sports' => 'スポーツカー', 'kei' => '軽自動車',
                    'kei_wagon' => '軽ワゴン', 'kei_heightwagon' => '軽ハイトワゴン', 'kei_slide' => '軽スライドドア',
                    'kei_sedan' => '軽セダン', 'kei_sports' => '軽スポーツ', 'kei_suv' => '軽SUV', 'kei_truck' => '軽トラック',
                    'kei_hako' => '軽箱（ケッパコ）', 'kei_hakowagon' => '軽箱ワゴン', 'kei_heightvan' => '軽ハイトバン',
                    'longseler' => 'ロングセラー', 'suv_3rd' => '3列シートSUV',
                    'headlight' => '丸目ヘッドライト', 'oem' => 'OEM', 'compact' => 'コンパクトカー', '2door_courpe' => '２ドアクーペ', 'familly' => 'ファミリーカー',
                    '3year' => '新車から3年落ち', '5year' => '新車から5年落ち', '7year' => '新車から7年落ち',
                    ] as $key => $label)
                    <li>
                        <a href="{{ route('car.genre', ['genre' => $key]) }}"
                            class="block px-4 py-2 hover:bg-gray-100">{{ $label }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <script>
            const hamburgerButton = document.getElementById('hamburgerButton');
            const hamburgerMenu = document.getElementById('hamburgerMenu');

            // ハンバーガーボタン押したとき
            hamburgerButton.addEventListener('click', (e) => {
                e.stopPropagation(); // クリックイベントが親に伝わらないようにする
                hamburgerMenu.classList.toggle('hidden');
            });

            // メニュー押したときも、メニューが閉じないようにする
            hamburgerMenu.addEventListener('click', (e) => {
                e.stopPropagation();
            });

            // ドキュメントのどこかを押したとき
            document.addEventListener('click', () => {
                if (!hamburgerMenu.classList.contains('hidden')) {
                    hamburgerMenu.classList.add('hidden');
                }
            });
        </script>

    </div>

</header>

{{-- チェックボックスセクション（中央寄せ＆下部広め） --}}
<div class="flex flex-wrap justify-center px-4 mt-1 mb-10 space-x-4">
    <label class="flex items-center space-x-1 text-sm text-gray-700">
        <input type="checkbox" name="import" value="1" onchange="updateFilters()" {{ request()->input('import') ? 'checked' : '' }}>
        <span>輸入車含む</span>
    </label>

    <label class="flex items-center space-x-1 text-sm text-gray-700">
        <input type="checkbox" name="exclude_keicar" value="1" onchange="updateFilters()" {{ request()->input('exclude_keicar') ? 'checked' : '' }}>
        <span>軽外す</span>
    </label>

    <label class="flex items-center space-x-1 text-sm text-gray-700">
        <input type="checkbox" name="exclude_hv" value="1" onchange="updateFilters()" {{ request()->input('exclude_hv') ? 'checked' : '' }}>
        <span>HV外す</span>
    </label>

    <label class="flex items-center space-x-1 text-sm text-gray-700">
        <input type="checkbox" name="exclude_diesel" value="1" onchange="updateFilters()" {{ request()->input('exclude_diesel') ? 'checked' : '' }}>
        <span>ディーゼル外す</span>
    </label>
</div>

<script>
    function updateFilters() {
        const params = new URLSearchParams();

        if (document.getElementsByName('import')[0].checked) {
            params.set('import', '1');
        }

        if (document.getElementsByName('exclude_keicar')[0].checked) {
            params.set('exclude_keicar', '1');
        }

        if (document.getElementsByName('exclude_hv')[0].checked) {
            params.set('exclude_hv', '1');
        }

        if (document.getElementsByName('exclude_diesel')[0].checked) {
            params.set('exclude_diesel', '1');
        }

        location.href = location.pathname + '?' + params.toString();
    }
</script>