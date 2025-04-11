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
        'size' => '車体の大きさをミリ単位で比較',
        'price' => 'クルマを買う時のお金の話',
        'tred' => '左右タイヤの幅で比較',
        'indoorsize' => '室内の広さをミリ単位で比較',
        'displacement' => 'エンジンの大きさで比較',
        'tiresize_front' => 'タイヤサイズで比較',
        'turningradius' => '小廻りがきくかどうかで比較',
        'name' => '欲しいクルマの名前は何？',
        'maker' => 'メーカーで選ぶのもアリ',
        'release' => '新型車種が欲しい！',
        'color' => '色も流行りがあります',
        'fueltank' => '気にする人は気にする比較項目',
        'kg' => 'クルマって1kgあたりいくら？',
        'weight' => '車輌の重量でもパワーが違ってきます',
        'ps' => 'クルマのパワーといえば馬力',
        'torque' => '出足の強さ',
        'groundclearance' => '高い方が乗りやすい？それとも逆？',
        'ridingcapacity' => 'ミニバンは６人以上乗れるのが魅力のひとつ',
        'wheelbase' => 'ホイールベースの長さで比較',
        'WLTC' => '今どきの流行りはコレ',
        'jtax' => '車検時の税金のひとつ',
        'gtax' => '毎年支払う税金',
        'tiresize' => '年間走行距離が多い人はチェック',
        //ミニバン
        'minivan_style' => '同じミニバンでも形が違います',
        'minivan_3rd' => '３列目シートの格納方法',
        'minivan_size' => 'ざっくりS・M・Lのサイズで比較',
        'minivan_slidedoor' => 'スライドドアの有無',
        // SUV
        'suv_style' => 'SUVのスタイルで比較',
        'suv_size' => 'SUVのサイズで比較',
        //
        ];

        function specIcon($spec) {
        return '<img src="' . asset('img/car_category_icon/' . $spec . '.png') . '" alt="' . $spec . '">';
        }
        @endphp

        <div id="size" class="tab-pane">
            <x-car-spec-table title="大きさ" :items="[
            [specIcon('size'), $specs['size'], 'size'],
            [specIcon('tred'), $specs['tred'], 'tred'],
            [specIcon('indoorsize'), $specs['indoorsize'], 'indoorsize'],
            [specIcon('displacement'), $specs['displacement'], 'displacement'],
            [specIcon('tiresize_front'), $specs['tiresize_front'], 'tiresize_front'],
            [specIcon('turningradius'), $specs['turningradius'], 'turningradius'],
            [specIcon('minivan_size'), $specs['minivan_size'], 'minivan_size'],
            [specIcon('minivan_slidedoor'), $specs['minivan_slidedoor'], 'minivan_slidedoor'],
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
            [specIcon('size'), $specs['size'], 'size'],
            [specIcon('minivan_slidedoor'), $specs['minivan_slidedoor'], 'minivan_slidedoor'],
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
            [specIcon('minivan_slidedoor'), $specs['minivan_slidedoor'], 'minivan_slidedoor'],
            [specIcon('minivan_3rd'), $specs['minivan_3rd'], 'minivan_3rd'],
            [specIcon('ridingcapacity'), $specs['ridingcapacity'], 'ridingcapacity'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="power" class="tab-pane hidden">
            <x-car-spec-table title="パワー" :items="[
            [specIcon('weight'), $specs['weight'], 'weight'],
            [specIcon('displacement'), $specs['displacement'], 'displacement'],
            [specIcon('ps'), $specs['ps'], 'ps'],
            [specIcon('torque'), $specs['torque'], 'torque'],
            [specIcon('minivan_slidedoor'), $specs['minivan_slidedoor'], 'minivan_slidedoor'],
            [specIcon('minivan_3rd'), $specs['minivan_3rd'], 'minivan_3rd'],
            [specIcon('ridingcapacity'), $specs['ridingcapacity'], 'ridingcapacity'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="condition" class="tab-pane hidden">
            <x-car-spec-table title="絶対条件" :items="[
            [specIcon('name'), $specs['name'], 'name'],
            [specIcon('maker'), $specs['maker'], 'maker'],
            [specIcon('price'), $specs['price'], 'price'],
            [specIcon('size'), $specs['size'], 'size'],
            [specIcon('ridingcapacity'), $specs['ridingcapacity'], 'ridingcapacity'],
            [specIcon('groundclearance'), $specs['groundclearance'], 'groundclearance'],
            [specIcon('minivan_style'), $specs['minivan_style'], 'minivan_style'],
            [specIcon('minivan_slidedoor'), $specs['minivan_slidedoor'], 'minivan_slidedoor'],
            [specIcon('minivan_3rd'), $specs['minivan_3rd'], 'minivan_3rd'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="trend" class="tab-pane hidden">
            <x-car-spec-table title="流行り" :items="[
            [specIcon('release'), $specs['release'], 'release'],
            [specIcon('color'), $specs['color'], 'color'],
            [specIcon('WLTC'), $specs['WLTC'], 'WLTC'],
            [specIcon('minivan_style'), $specs['minivan_style'], 'minivan_style'],
            [specIcon('ridingcapacity'), $specs['ridingcapacity'], 'ridingcapacity'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="cost" class="tab-pane hidden">
            <x-car-spec-table title="維持費" :items="[
            [specIcon('price'), $specs['price'], 'price'],
            [specIcon('weight'), $specs['weight'], 'weight'],
            [specIcon('jtax'), $specs['jtax'], 'jtax'],
            [specIcon('WLTC'), $specs['WLTC'], 'WLTC'],
            [specIcon('gtax'), $specs['gtax'], 'gtax'],
            [specIcon('tiresize_front'), $specs['tiresize_front'], 'tiresize_front'],
            ]" :genre="$genre" :year="$year" />
        </div>

        <div id="money" class="tab-pane hidden">
            <x-car-spec-table title="お金" :items="[
            [specIcon('price'), $specs['price'], 'price'],
            [specIcon('gtax'), $specs['gtax'], 'gtax'],
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