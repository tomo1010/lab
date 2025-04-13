@extends('car.layouts.app')

@section('content')

{{-- メニューバー --}}
@include('car.commons.menubar')

{{-- ページタイトルを上半期下半期に分けて表示 --}}
@include('car.commons.titleHalf')

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
                    @if(!is_null($car->color))
                    {{ $car->color }} 色
                    @else
                    - 色
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