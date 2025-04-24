@extends('car.layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl font-semibold text-gray-800 mb-6">{{ $car->name }} 詳細ページ</h1>

                <table class="min-w-full table-auto border-separate border-spacing-0">
                        <tbody class="text-sm">
                                @php
                                $specs = [
                                '画像' => '<img src="' . asset('img/' . $car->year . '/180/' . $car->maker_kana . '/' . $car->model . '.jpg') . '" alt="' . $car->maker . $car->name . '">',
                                'id' => $car->id,
                                'メーカー' => $car->maker,
                                '車名' => $car->name,
                                '発売日' => $car->release->format('Y年m月'),
                                'グレード' => $car->grade,
                                '価格' => $car->price . '万円〜',
                                '型式' => $car->model,
                                '最小回転半径' => $car->turningradius . 'm',
                                '駆動方式' => $car->drive,
                                '全長×全幅×全高' => $car->size . 'cm',
                                'ドア数' => $car->door,
                                'ホイールベース' => $car->wheelbase . 'm',
                                'ミッション' => $car->mission,
                                'トレッド' => $car->tred,
                                'AIシフト' => $car->shift,
                                '室内(全長×全幅×全高)' => $car->indoorsize . 'cm',
                                '車両重量' => $car->weight . 'kg',
                                'シート列数' => $car->seats,
                                '積載量' => $car->capacity . 'kg',
                                '乗車定員' => $car->ridingcapacity . '人',
                                '総重量' => $car->grossweight . 'kg',
                                'ミッション位置' => $car->missionposition,
                                '最低地上高' => $car->groundclearance . 'cm',
                                '色数' => $car->colors,
                                'コメント' => $car->comment,
                                'エンジン型式' => $car->enginemodel,
                                '環境対策エンジン' => $car->environmentalengine,
                                '種類' => $car->kinds,
                                '使用燃料' => $car->fuel,
                                '過給機' => $car->supercharger,
                                '燃料タンク' => $car->fueltank . 'L',
                                '可変気筒装置' => $car->cylinderdevice,
                                '燃費（JC08）' => $car->JC08,
                                '総排気量' => $car->displacement . 'cc',
                                '燃費（WLTC）' => $car->WLTC . 'km/L',
                                '燃費基準達成' => $car->achievedfuel,
                                '最高出力' => $car->ps . 'ps',
                                'トルク' => $car->torque,
                                '位置' => $car->position,
                                'ステアリングギア方式' => $car->steeringgear,
                                'パワーステアリング' => $car->powersteering,
                                'VGS' => $car->VGS,
                                'サスペンション形式前' => $car->Fsuspension,
                                'サスペンション形式後' => $car->Rsuspension,
                                'タイヤサイズ前' => $car->Fttiresize,
                                'タイヤサイズ後' => $car->Rtiresize,
                                'ブレーキ形式前' => $car->Fbraketype,
                                'ブレーキ形式後' => $car->Rbraketype,
                                'データ年度' => $car->year,
                                'ジャンル' => $car->genre,
                                '入力日時' => $car->created_at,
                                ];
                                @endphp

                                @foreach ($specs as $label => $value)
                                <tr class="hover:bg-gray-100">
                                        <th class="text-left px-6 py-4 font-medium text-gray-700 border-b border-gray-300">{{ $label }}</th>
                                        <td class="px-6 py-4 border-b border-gray-300">{!! $value !!}</td>
                                </tr>
                                @endforeach

                        </tbody>
                </table>
        </div>
</div>

@endsection