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
];

$safeGenre = $genre ?? '';
$bgClass = $genreStyles[$safeGenre][0] ?? 'bg-gray-100';
$logoUrl = $genreStyles[$safeGenre][1] ?? null;
@endphp

<header class="sticky top-0 z-50 mb-6 border-b border-gray-200 {{ $bgClass }}">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        {{-- ロゴ --}}
        <div class="flex items-center space-x-4">
            @if($logoUrl)
            <a href="{{ route('car.genre', ['genre' => $safeGenre]) }}">
                <img src="{{ $logoUrl }}" alt="{{ $safeGenre }} ロゴ" class="w-[150px] h-[36px] object-none max-w-none flex-shrink-0" />
            </a>
            @else
            <a href="{{ route('car.genre', ['genre' => $safeGenre]) }}" class="text-lg font-semibold text-white">
                軽自動車比較サイト
            </a>
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
                    '3year' => '新車から3年落ち', '5year' => '新車から5年落ち', '7year' => '新車から7年落ち'
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
            hamburgerButton.addEventListener('click', () => {
                hamburgerMenu.classList.toggle('hidden');
            });
        </script>
    </div>

    <script>
        const dropdownBtn = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownBtn?.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });
    </script>
</header>

{{-- 国産車チェックボックス --}}
<p class="text-right px-4 mb-1">
    <input type="checkbox" name="import" value="1" onchange="myfunc(this.value)" {{ request()->input('import') ? 'checked' : '' }}>
    <span class="text-sm text-gray-700">輸入車含む</span>
</p>

<script>
    function myfunc(value) {
        const element = document.getElementsByName('import');
        if (element[0].checked) {
            location.href = location.pathname + '?import=1';
        } else {
            location.href = location.pathname;
        }
    }
</script>