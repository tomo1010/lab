<footer class="bg-white border-t border-gray-200 py-8 text-sm text-gray-700">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">




        {{-- ジャンル 1 --}}
        <div>
            <h5 class="font-semibold mb-2 text-gray-800">ボディタイプ</h5>
            <ul class="space-y-1">
                @foreach ([
                'minivan' => 'ミニバン',
                'puchivan' => 'プチバン',
                'suv' => 'SUV',
                'hatchback' => 'ハッチバック',
                'wagon' => 'ステーションワゴン',
                'sedan' => 'セダン',
                'sports' => 'スポーツカー',
                'kei' => '軽自動車'
                ] as $key => $label)
                <li>
                    <a href="{{ route('car.genre', ['genre' => $key]) }}" class="hover:underline hover:text-black">
                        {{ $label }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- ジャンル 2 --}}
        <div>
            <h5 class="font-semibold mb-2 text-gray-800">軽自動車の種類</h5>
            <ul class="space-y-1">
                @foreach ([
                'kei_wagon' => '軽ワゴン',
                'kei_heightwagon' => '軽ハイトワゴン',
                'kei_slide' => '軽スライドドア',
                'kei_sedan' => '軽セダン',
                'kei_sports' => '軽スポーツ',
                'kei_suv' => '軽SUV',
                'kei_truck' => '軽トラック',
                'kei_hako' => '軽箱（ケッパコ）',
                'kei_hakowagon' => '軽箱ワゴン',
                'kei_heightvan' => '軽ハイトバン'
                ] as $key => $label)
                <li>
                    <a href="{{ route('car.genre', ['genre' => $key]) }}" class="hover:underline hover:text-black">
                        {{ $label }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- ジャンル 3 --}}
        <div>
            <h5 class="font-semibold mb-2 text-gray-800">特徴別</h5>
            <ul class="space-y-1">
                @foreach ([
                'longseler' => 'ロングセラー',
                'suv_3rd' => '3列シートSUV'
                ] as $key => $label)
                <li>
                    <a href="{{ route('car.genre', ['genre' => $key]) }}" class="hover:underline hover:text-black">
                        {{ $label }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- ジャンル 4 --}}
        <div>
            <h5 class="font-semibold mb-2 text-gray-800">年式別</h5>
            <ul class="space-y-1">
                @foreach ([
                '3year' => '新車から3年落ち',
                '5year' => '新車から5年落ち',
                '7year' => '新車から7年落ち'
                ] as $key => $label)
                <li>
                    <a href="{{ route('car.genre', ['genre' => $key]) }}" class="hover:underline hover:text-black">
                        {{ $label }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

    </div>

    <div class="mt-8 text-center text-xs text-gray-400">
        &copy; 2025 kurumayalabo.com All rights reserved.
    </div>
</footer>