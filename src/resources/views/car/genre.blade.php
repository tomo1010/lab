@extends('car.layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    {{-- 大カテゴリー --}}
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

    {{-- 小カテゴリー --}}
    <div id="tab-content">
        @php
        $specs = [
        'color' => '色も流行りがあります',
        'displacement' => 'エンジンの大きさで比較',
        'drive' => '駆動方式',
        'fees' => '車検時に加入する強制保険',
        'fueltank' => '気にする人は気にする比較項目',
        'gap' => 'コンパクトなのに室内が広い',
        'groundclearance' => '高い方が乗りやすい？それとも逆？',
        'indoorsize' => '室内の広さをミリ単位で比較',
        'jtax' => '車検時の税金のひとつ',
        'kg' => 'クルマって1kgあたりいくら？',
        'cruising' => '航続距離で比較',
        'maker' => 'メーカーで選ぶのもアリ',
        'mt' => 'マニュアルミッションの設定あり',
        'name' => '欲しいクルマの名前は何？',
        'overhead' => '車検諸費用',
        'price' => 'クルマを買う時のお金の話',
        'ps' => 'クルマのパワーといえば馬力',
        'release' => '新型車種が欲しい！',
        'ridingcapacity' => '乗車人数で比較',
        'bodysize' => '車体の大きさをミリ単位で比較',
        'tax' => '毎年支払う税金',
        'tiresize_front' => 'タイヤサイズで比較',
        'torque' => '出足の強さ',
        'tred' => '左右タイヤの幅で比較',
        'turningradius' => '小廻りがきくかどうかで比較',
        'weight' => '車輌の重量でもパワーが違ってきます',
        'wheelbase' => 'ホイールベースの長さで比較',
        'WLTC' => '今どきの流行りはコレ',

        //ミニバン
        'minivan_size' => 'ざっくりS・M・Lのサイズで比較',
        'minivan_slidedoor' => 'スライドドアの有無',
        'minivan_style' => '同じミニバンでも形が違います',
        'minivan_3rd' => '３列目シートの格納方法',

        //プチバン
        'puchivan_doorsize' => 'スライドドアの開口部で比較',

        // SUV
        'suv_size' => 'ざっくりS・M・Lのサイズで比較',
        'suv_style' => 'SUVのスタイルで比較',

        //ハッチバック
        'hatchback_size' => 'ざっくりS・M・Lのサイズで比較',

        //セダン
        'sedan_size' => 'ざっくりS・M・Lのサイズで比較',

        //ステーションワゴン
        'wagon_size' => 'ざっくりS・M・Lのサイズで比較',
        'wagon_luggage' => '荷室の広さで比較',

        //スポーツ
        'sports_size' => 'ざっくりS・M・Lのサイズで比較',
        'open' => 'オープンカーの設定あり',
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
            [specIcon('tiresize_front'), $specs['tiresize_front'], 'tiresize_front'],
            [specIcon('turningradius'), $specs['turningradius'], 'turningradius'],
            [specIcon('minivan_size'), $specs['minivan_size'], 'minivan_size'],
            [specIcon('suv_size'), $specs['suv_size'], 'suv_size'],
            [specIcon('hatchback_size'), $specs['hatchback_size'], 'hatchback_size'],
            [specIcon('sedan_size'), $specs['sedan_size'], 'sedan_size'],
            [specIcon('wagon_size'), $specs['wagon_size'], 'wagon_size'],
            [specIcon('sports_size'), $specs['sports_size'], 'sports_size'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="choose" class="tab-pane hidden">
            <x-car-spec-table title="選ぶ楽しみ" :items="[
            [specIcon('name'), $specs['name'], 'name'],
            [specIcon('maker'), $specs['maker'], 'maker'],
            [specIcon('release'), $specs['release'], 'release'],
            [specIcon('color'), $specs['color'], 'color'],
            [specIcon('fueltank'), $specs['fueltank'], 'fueltank'],
            [specIcon('kg'), $specs['kg'], 'kg'],
            [specIcon('gap'), $specs['gap'], 'gap'],
            [specIcon('minivan_3rd'), $specs['minivan_3rd'], 'minivan_3rd'],
            [specIcon('suv_style'), $specs['suv_style'], 'suv_style'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="utility" class="tab-pane hidden">
            <x-car-spec-table title="使い勝手" :items="[
            [specIcon('wheelbase'), $specs['wheelbase'], 'wheelbase'],
            [specIcon('tred'), $specs['tred'], 'tred'],
            [specIcon('indoorsize'), $specs['indoorsize'], 'indoorsize'],
            [specIcon('groundclearance'), $specs['groundclearance'], 'groundclearance'],
            [specIcon('fueltank'), $specs['fueltank'], 'fueltank'],
            [specIcon('turningradius'), $specs['turningradius'], 'turningradius'],
            [specIcon('ridingcapacity'), $specs['ridingcapacity'], 'ridingcapacity'],
            [specIcon('cruising'), $specs['cruising'], 'cruising'],
            [specIcon('minivan_slidedoor'), $specs['minivan_slidedoor'], 'minivan_slidedoor'],
            [specIcon('minivan_3rd'), $specs['minivan_3rd'], 'minivan_3rd'],
            [specIcon('puchivan_doorsize'), $specs['puchivan_doorsize'], 'puchivan_doorsize'],
            [specIcon('wagon_luggage'), $specs['wagon_luggage'], 'wagon_luggage'],

            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="power" class="tab-pane hidden">
            <x-car-spec-table title="パワー" :items="[
            [specIcon('weight'), $specs['weight'], 'weight'],
            [specIcon('displacement'), $specs['displacement'], 'displacement'],
            [specIcon('ps'), $specs['ps'], 'ps'],
            [specIcon('torque'), $specs['torque'], 'torque'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="condition" class="tab-pane hidden">
            <x-car-spec-table title="絶対条件" :items="[
            [specIcon('name'), $specs['name'], 'name'],
            [specIcon('maker'), $specs['maker'], 'maker'],
            [specIcon('price'), $specs['price'], 'price'],
            [specIcon('bodysize'), $specs['bodysize'], 'bodysize'],
            [specIcon('ridingcapacity'), $specs['ridingcapacity'], 'ridingcapacity'],
            [specIcon('drive'), $specs['drive'], 'drive'],
            [specIcon('minivan_style'), $specs['minivan_style'], 'minivan_style'],
            [specIcon('minivan_slidedoor'), $specs['minivan_slidedoor'], 'minivan_slidedoor'],
            [specIcon('minivan_3rd'), $specs['minivan_3rd'], 'minivan_3rd'],
            [specIcon('puchivan_doorsize'), $specs['puchivan_doorsize'], 'puchivan_doorsize'],
            [specIcon('suv_style'), $specs['suv_style'], 'suv_style'],
            [specIcon('wagon_luggage'), $specs['wagon_luggage'], 'wagon_luggage'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="trend" class="tab-pane hidden">
            <x-car-spec-table title="流行り" :items="[
            [specIcon('release'), $specs['release'], 'release'],
            [specIcon('color'), $specs['color'], 'color'],
            [specIcon('WLTC'), $specs['WLTC'], 'WLTC'],
            [specIcon('ridingcapacity'), $specs['ridingcapacity'], 'ridingcapacity'],
            [specIcon('minivan_style'), $specs['minivan_style'], 'minivan_style'],

            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="cost" class="tab-pane hidden">
            <x-car-spec-table title="維持費" :items="[
            [specIcon('price'), $specs['price'], 'price'],
            [specIcon('jtax'), $specs['jtax'], 'jtax'],
            [specIcon('WLTC'), $specs['WLTC'], 'WLTC'],
            [specIcon('tax'), $specs['tax'], 'tax'],
            [specIcon('tiresize_front'), $specs['tiresize_front'], 'tiresize_front'],
            [specIcon('overhead'), $specs['overhead'], 'overhead'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="money" class="tab-pane hidden">
            <x-car-spec-table title="お金" :items="[
            [specIcon('price'), $specs['price'], 'price'],
            [specIcon('tax'), $specs['tax'], 'tax'],
            [specIcon('jtax'), $specs['jtax'], 'jtax'],
            [specIcon('kg'), $specs['kg'], 'kg'],
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