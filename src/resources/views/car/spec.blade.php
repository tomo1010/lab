@extends('car.layouts.app')

@section('content')

{{-- ページタイトルを上半期下半期に分けて表示 --}}
@include('car.commons.titleHalf')

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
                    @include('car.commons.name_car')
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