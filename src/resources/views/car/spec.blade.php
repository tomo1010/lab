@extends('car.layouts.app')

@section('content')

{{-- ページタイトルを上半期下半期に分けて表示 --}}
<p class="flex items-center gap-4 border-b border-gray-200 pb-4 mb-6">
    {{-- アイコン --}}
    <img src="{{ asset('img/car_category_icon/' . $spec . '.png') }}" alt="Car Genre Icon" class="w-12 h-12 object-contain">

    {{-- タイトル部分 --}}
    <span class="text-gray-800">
        {{-- 年＋半期 --}}
        <span class="block text-sm text-gray-500 mb-1">
            【{{ $year }}年
            @if($half == 1)
            上半期
            @elseif($half == 2)
            下半期
            @endif
            】
        </span>

        {{-- スペック名 --}}
        <span class="text-xl font-semibold">
            @if($spec == 'maker')
            メーカー
            @elseif($spec == 'maker_kana')
            メーカー英語
            @elseif($spec == 'name')
            車名
            @elseif($spec == 'release')
            発売日
            @elseif($spec == 'grade')
            グレード
            @elseif($spec == 'price')
            価格
            @elseif($spec == 'model')
            型式
            @elseif($spec == 'turningradius')
            最小回転半径
            @elseif($spec == 'drive')
            駆動方式
            @elseif($spec == 'size_length')
            全長
            @elseif($spec == 'size_width')
            全幅
            @elseif($spec == 'size_height')
            全高
            @elseif($spec == 'door')
            ドア数
            @elseif($spec == 'wheelbase')
            ホイールベース
            @elseif($spec == 'mission')
            ミッション
            @elseif($spec == 'tred')
            トレッド
            @elseif($spec == 'shift')
            AI-SHIFT
            @elseif($spec == 'indoorsize_length')
            室内長
            @elseif($spec == 'indoorsize_width')
            室内幅
            @elseif($spec == 'indoorsize_height')
            室内高
            @elseif($spec == 'fourws')
            4WS
            @elseif($spec == 'weight')
            重さ
            @elseif($spec == 'seats')
            シート数
            @elseif($spec == 'capacity')
            最大積載量
            @elseif($spec == 'ridingcapacity')
            乗車人数
            @elseif($spec == 'grossweight')
            車輌総重量
            @elseif($spec == 'missionposition')
            ミッション位置
            @elseif($spec == 'groundclearance')
            乗り降りの高さ（最低地上高）
            @elseif($spec == 'manualmode')
            マニュアルモード
            @elseif($spec == 'color')
            カラー
            @elseif($spec == 'comment')
            掲載コメント
            @elseif($spec == 'enginemodel')
            エンジン型式
            @elseif($spec == 'environmentalengine')
            環境対策エンジン
            @elseif($spec == 'kinds')
            種類
            @elseif($spec == 'fuel')
            使用燃料
            @elseif($spec == 'supercharger')
            過給機
            @elseif($spec == 'fueltank')
            燃料タンク容量
            @elseif($spec == 'cylinderdevice')
            可変気筒装置
            @elseif($spec == 'JC08')
            燃費（JC08）
            @elseif($spec == 'displacement')
            排気量
            @elseif($spec == 'WLTC')
            燃費（WLTC）
            @elseif($spec == 'achievedfuel')
            燃費基準達成
            @elseif($spec == 'ps')
            最高出力（馬力）
            @elseif($spec == 'torque')
            トルク
            @elseif($spec == 'position')
            位置
            @elseif($spec == 'steeringgear')
            ステアリングギア方式
            @elseif($spec == 'powersteering')
            パワーステアリング
            @elseif($spec == 'VGS')
            VGS/VGRS
            @elseif($spec == 'suspension_front')
            サスペンション形式　前
            @elseif($spec == 'suspension_rear')
            サスペンション形式　後
            @elseif($spec == 'tiresize_front')
            タイヤサイズ
            @elseif($spec == 'tiresize_rear')
            タイヤサイズ　後
            @elseif($spec == 'braketype_front')
            ブレーキ形式　前
            @elseif($spec == 'braketype_rear')
            ブレーキ形式　後
            @elseif($spec == 'tax')
            自動車税
            @elseif($spec == 'jtax')
            重量税
            @elseif($spec == 'kg')
            kg単価
            @elseif($spec == 'cruising')
            航続距離
            @elseif($spec == 'bodysize')
            車体の大きさ(全長+全幅+全高の合計)
            @elseif($spec == 'indoorsize')
            室内の広さ(内長+内幅+内高の合計)
            @elseif($spec == 'gap')
            車体は小さく室内は広く
            @elseif($spec == 'overhead')
            車検諸費用
            @elseif($spec == 'jibai')
            自賠責保険
            @elseif($spec == 'minivan_slidedoor')
            スライドドア有無
            @elseif($spec == 'minivan_style')
            形
            @elseif($spec == 'minivan_3rd')
            ３列目の格納
            @elseif($spec == 'puchivan_slideopen')
            スライドドアの大きさ
            @elseif($spec == 'suv_style')
            形
            @elseif($spec == 'wagon_luggage')
            荷室サイズ
            @elseif($spec == 'half')
            上半期・下半期
            @endif

            で比較
        </span>
    </span>
</p>


{{-- 単位を読み込み --}}
@php
$units = [
'bodysize' => 'm',
'color' => '色',
'cruising' => 'km',
'cylinderdevice' => 'mm',
'displacement' => 'cc',
'engine' => 'cc',
'fees' => '円',
'fuel' => 'km/L',
'fueltank' => 'L',
'gap' => 'cm',
'groundclearance' => 'cm',
'indoorsize' => 'm',
'jtax' => '円',
'kg' => '円/kg',
'kinds' => 'mm',
'open' => 'mm',
'overhead' => '円',
'position' => 'mm',
'powersteering' => 'mm',
'price' => '万円',
'ps' => 'ps',
'puchivan_slideopen' => 'cm',
'ridingcapacity' => '人',
'tax' => '円',
'torque' => 'kgm',
'turningradius' => 'm',
'VGS' => 'mm',
'wagon_luggage' => 'mm',
'weight' => 'kg',
'wheelbase' => 'cm',
'WLTC' => 'km/L',
];

$unit = $units[$spec] ?? ''; // 該当しない場合は空文字
@endphp


{{-- 車のスペック一覧テーブル --}}
<div class="container mx-auto mt-6">
    <table class="w-full border-collapse">
        <thead class="bg-gray-200 border-b border-gray-300">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">
                    車名
                </th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">
                    @include('car.commons.name_spec')
                </th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($cars as $car)
            <tr class="border-b border-gray-300 hover:bg-gray-100">
                <td class="px-4 py-2 text-gray-800">
                    <a href="{{ route('car.show', [$car->id, $genre]) }}">
                        <img src="{{ asset('img/' . $car->year . '/' . '180' . '/' . $car->maker_kana . '/' . $car->model . '.jpg' ) }}" alt="{{$car->maker}}{{$car->name}}"></br>
                        {{$car->name}}
                    </a>
                </td>
                <td class="px-4 py-2 text-gray-800">
                    @if(!is_null($car->$spec))
                    {{ $car->$spec }} {{ $unit }}
                    @else
                    - {{ $unit }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- 過去のランキング一覧を表示 --}}
<div class="mt-8">
    @include('car.commons.pastlist')
</div>

@endsection