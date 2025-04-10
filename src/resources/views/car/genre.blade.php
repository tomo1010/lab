@extends('car.layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    {{-- タブメニュー --}}
    <ul class="flex flex-wrap justify-center border-b border-gray-300 mb-8" id="tabs" role="tablist">
        @php
        $tabs = [
        'size' => '大きさ',
        'choose' => '選ぶ楽しみ',
        'utility' => '使い勝手',
        'power' => 'パワー',
        'condition' => '絶対条件',
        'trend' => '流行り',
        'cost' => '維持費',
        'money' => 'お金',
        ];
        @endphp

        @foreach($tabs as $id => $label)
        <li class="mr-4 mb-2">
            <a href="#{{ $id }}"
                class="inline-block px-4 py-2 text-sm text-gray-700 hover:text-black border-b-2 border-transparent hover:border-gray-400 transition no-underline hover:no-underline"
                data-tab-target="{{ $id }}">
                {{ $label }}
            </a>


        </li>
        @endforeach
    </ul>

    {{-- タブコンテンツ --}}
    <div id="tab-content">
        @php
        $specs = [
        'bodysize' => '車体の大きさをミリ単位で比較',
        'tred' => '左右タイヤの幅で比較',
        'indoorsize' => '室内の広さをミリ単位で比較',
        'displacement' => 'エンジンの大きさで比較',
        'tiresize' => 'タイヤサイズで比較',
        'turningradius' => '小廻りがきくかどうかで比較',
        'size' => 'ざっくりS・M・Lのサイズで比較',
        'minivan_slidedoor' => 'スライドドアの有無',
        // 他specも同様にここに追加できます
        ];

        function specIcon($spec) {
        return '<img src="' . asset('img/car_category_icon/' . $spec . '.png') . '" alt="' . $spec . '">';
        }
        @endphp

        <div id="size" class="tab-pane">
            <x-car-spec-table title="大きさ" :items="[
            [specIcon('bodysize'), $specs['bodysize'], 'bodysize'],
            [specIcon('tred'), $specs['tred'], 'tred'],
            [specIcon('indoorsize'), $specs['indoorsize'], 'indoorsize'],
            [specIcon('displacement'), $specs['displacement'], 'displacement'],
            [specIcon('tiresize'), $specs['tiresize'], 'tiresize'],
            [specIcon('turningradius'), $specs['turningradius'], 'turningradius'],
            [specIcon('size'), $specs['size'], 'size'],
            [specIcon('minivan_slidedoor'), $specs['minivan_slidedoor'], 'minivan_slidedoor'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="choose" class="tab-pane hidden">
            <x-car-spec-table title="選ぶ楽しみ" :items="[
            [specIcon('name'), '有名だからって選んでませんか？', 'name'],
            [specIcon('maker'), 'たまにはいつもと違うメーカーから', 'maker'],
            [specIcon('release'), '新型車はやっぱりイイ！', 'release'],
            [specIcon('color'), '最近はカラーバリーションが豊富', 'color'],
            [specIcon('fueltank'), '長距離乗る人は検討材料のひとつ', 'fueltank'],
            [specIcon('kg'), 'クルマって1kgあたりいくら？', 'kg'],
            [specIcon('size'), 'ざっくりS・M・Lのサイズ分けで比較', 'size'],
            [specIcon('minivan_slidedoor'), 'スライドドアの有無', 'minivan_slidedoor'],
            [specIcon('minivan_3rd'), '３列目シートの格納方法', 'minivan_3rd'],
            [specIcon('suv_style'), '３列目シートの格納方法', 'suv_style'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="utility" class="tab-pane hidden">
            <x-car-spec-table title="使い勝手" :items="[
            [specIcon('wheelbase'), '前輪から後輪までの長さ', 'wheelbase'],
            [specIcon('tred'), '左右タイヤの幅', 'tred'],
            [specIcon('indoorsize'), '室内の広さをミリ単位で比較', 'indoorsize'],
            [specIcon('groundclearance'), '高い方が乗りやすい？それとも逆？', 'groundclearance'],
            [specIcon('fueltank'), '気にする人は気にする比較項目', 'fueltank'],
            [specIcon('turningradius'), '駐車場での運転しやすさに直結', 'turningradius'],
            [specIcon('minivan_slidedoor'), 'スライドドアの有無', 'minivan_slidedoor'],
            [specIcon('minivan_3rd'), '３列目シートの格納方法', 'minivan_3rd'],
            [specIcon('ridingcapacity'), 'ミニバンは６人以上乗れるのが魅力のひとつ', 'ridingcapacity'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="power" class="tab-pane hidden">
            <x-car-spec-table title="パワー" :items="[
            [specIcon('weight'), '車輌の重量でもパワーが違ってきます', 'weight'],
            [specIcon('displacement'), 'エンジンの大きさ', 'displacement'],
            [specIcon('ps'), 'クルマのパワーといえば馬力', 'ps'],
            [specIcon('torque'), '出足の強さ', 'torque'],
            [specIcon('minivan_slidedoor'), 'スライドドアの有無', 'minivan_slidedoor'],
            [specIcon('minivan_3rd'), '３列目シートの格納方法', 'minivan_3rd'],
            [specIcon('ridingcapacity'), 'ミニバンは６人以上乗れるのが魅力のひとつ', 'ridingcapacity'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="condition" class="tab-pane hidden">
            <x-car-spec-table title="絶対条件" :items="[
            [specIcon('name'), '欲しいクルマの名前は何？', 'name'],
            [specIcon('maker'), 'メーカーで選ぶのもアリ', 'maker'],
            [specIcon('price'), '予算は大事', 'price'],
            [specIcon('bodysize'), '車体の大きさをミリ単位で比較', 'bodysize'],
            [specIcon('ridingcapacity'), '６人以上のる用途があるなら必須', 'ridingcapacity'],
            [specIcon('groundclearance'), 'こちらも大事といえば大事', 'groundclearance'],
            [specIcon('minivan_style'), '同じミニバンでも形が違います', 'minivan_style'],
            [specIcon('minivan_slidedoor'), 'スライドドアの有無', 'minivan_slidedoor'],
            [specIcon('minivan_3rd'), '３列目シートの格納方法', 'minivan_3rd'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="trend" class="tab-pane hidden">
            <x-car-spec-table title="流行り" :items="[
            [specIcon('release'), '新型車種が欲しい！', 'release'],
            [specIcon('color'), '色も流行りがあります', 'color'],
            [specIcon('WLTC'), '今どきの流行りはコレ', 'WLTC'],
            [specIcon('minivan_style'), 'ミニバンでも形が違います', 'minivan_style'],
            [specIcon('ridingcapacity'), '８人乗りよりも７人乗り？', 'ridingcapacity'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="cost" class="tab-pane hidden">
            <x-car-spec-table title="維持費" :items="[
            [specIcon('price'), '基本のき', 'price'],
            [specIcon('weight'), '実燃費に関係します', 'weight'],
            [specIcon('jtax'), '車検時の税金のひとつ', 'jtax'],
            [specIcon('WLTC'), '日常生活に直結する維持費', 'WLTC'],
            [specIcon('gtax'), '毎年支払う税金', 'gtax'],
            [specIcon('tiresize'), '年間走行距離が多い人はチェック', 'tiresize'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="money" class="tab-pane hidden">
            <x-car-spec-table title="お金" :items="[
            [specIcon('price'), 'クルマを買う時のお金の話', 'price'],
            [specIcon('gtax'), '毎年支払う税金', 'gtax'],
            [specIcon('jtax'), '車検時の税金のひとつ', 'jtax'],
            [specIcon('kg'), 'クルマって1kgあたりいくら？', 'kg'],
            ]" :genre="$genre" :year="$year" />
        </div>


        <p class="text-right text-sm text-gray-500 mt-4">※ジャンル特有の比較項目</p>
    </div>

    {{-- タブ切り替えスクリプト --}}
    <script>
        document.querySelectorAll('[data-tab-target]').forEach(tab => {
            tab.addEventListener('click', e => {
                e.preventDefault();
                const target = tab.getAttribute('data-tab-target');

                // タブ切り替え
                document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));
                document.getElementById(target).classList.remove('hidden');

                // タブの下線切替
                document.querySelectorAll('[data-tab-target]').forEach(t => t.classList.remove('border-black'));
                tab.classList.add('border-black');
            });
        });

        // 初期表示
        document.querySelector('#size').classList.remove('hidden');
    </script>
    @endsection