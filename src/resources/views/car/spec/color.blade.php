@extends('car.layouts.app')

@section('content')

    {{-- メニューバー --}}
    @include('car.commons.menubar') 

    {{-- ページタイトルを上半期下半期に分けて表示 --}}
    @include('car.commons.titleHalf') 

    {{-- 車のスペック一覧テーブル --}}
    <div class="container mx-auto mt-6">
        <table class="min-w-full divide-y divide-gray-300 border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wide">
                        車名
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wide">
                        @include('car.commons.name_spec')
                    </th>                              
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
                @foreach ($cars as $car)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                        @include('car.commons.name_car')
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
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