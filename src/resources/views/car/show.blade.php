@extends('car.layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">{{ $car->name }} 詳細ページ</h1>

        <table class="w-full text-sm border-t border-gray-200">
                <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr>
                                <th class="py-2 px-4 text-left font-medium w-1/4"></th>
                                <td class="py-2 px-4">
                                        <img src="{{ asset('img/' . $car->year . '/180/' . $car->maker_kana . '/' . $car->model . '.jpg') }}" alt="{{ $car->maker }}{{ $car->name }}" class="w-48">
                                </td>
                        </tr>

                        @foreach ([
                        'id' => 'ID',
                        'maker' => 'メーカー',
                        'name' => '車名',
                        'grade' => 'グレード',
                        'price' => '価格',
                        'model' => '型式',
                        'turningradius' => '最小回転半径',
                        'drive' => '駆動方式',
                        'size' => '全長×全幅×全高',
                        'door' => 'ドア数',
                        'wheelbase' => 'ホイールベース',
                        'mission' => 'ミッション',
                        'tred' => 'トレッド',
                        'shift' => 'AIシフト',
                        'indoorsize' => '室内(全長×全幅×全高)',
                        'weight' => '車両重量',
                        'seats' => 'シート列数',
                        'capacity' => '積載量',
                        'ridingcapacity' => '乗車定員',
                        'grossweight' => '総重量',
                        'missionposition' => 'ミッション位置',
                        'groundclearance' => '最低地上高',
                        'colors' => '色数',
                        'comment' => 'コメント',
                        'enginemodel' => 'エンジン型式',
                        'environmentalengine' => '環境対策エンジン',
                        'kinds' => '種類',
                        'fuel' => '使用燃料',
                        'supercharger' => '過給機',
                        'fueltank' => '燃料タンク',
                        'cylinderdevice' => '可変気筒装置',
                        'JC08' => '燃費（JC08）',
                        'displacement' => '総排気量',
                        'WLTC' => '燃費（WLTC）',
                        'achievedfuel' => '燃費基準達成',
                        'ps' => '最高出力',
                        'torque' => 'トルク',
                        'position' => '位置',
                        'steeringgear' => 'ステアリングギア方式',
                        'powersteering' => 'パワーステアリング',
                        'VGS' => 'VGS',
                        'Fsuspension' => 'サスペンション形式前',
                        'Rsuspension' => 'サスペンション形式後',
                        'Fttiresize' => 'タイヤサイズ前',
                        'Rtiresize' => 'タイヤサイズ後',
                        'Fbraketype' => 'ブレーキ形式前',
                        'Rbraketype' => 'ブレーキ形式後',
                        'year' => 'データ年度',
                        'genre' => 'ジャンル',
                        ] as $key => $label)
                        <tr>
                                <th class="py-2 px-4 text-left font-medium">{{ $label }}</th>
                                <td class="py-2 px-4">
                                        {{ $car->$key }}
                                        @switch($key)
                                        @case('price') 万円〜 @break
                                        @case('fueltank') L @break
                                        @case('WLTC') km/L @break
                                        @case('displacement') cc @break
                                        @case('ps') ps @break
                                        @case('weight') @case('capacity') @case('grossweight') kg @break
                                        @case('ridingcapacity') 人 @break
                                        @case('groundclearance') @case('size') @case('indoorsize') cm @break
                                        @case('turningradius') @case('wheelbase') m @break
                                        @endswitch
                                </td>
                        </tr>
                        @endforeach

                        <tr>
                                <th class="py-2 px-4 text-left font-medium">発売日</th>
                                <td class="py-2 px-4">{{ $car->release->format('Y年m月') }}</td>
                        </tr>
                </tbody>
        </table>
</div>
@endsection