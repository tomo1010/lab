@extends('layouts.app')

@section('content')

    {{-- メニューバー --}}
    @include('car.commons.menubar') 

    {{-- ページタイトルを上半期下半期に分けて表示 --}}
    @include('car.commons.titleHalf') 

    {{-- 最新年度ならジャンル別のコラムを表示
    @include('car.commons.explanation') --}}

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>車名</th>
                    <th>@include('car.commons.name_spec')</th>                              
                </tr>
            </thead>
            <tbody>
                @foreach ($cars as $car)
                <tr>
                    <td>
                        @include('car.commons.name_car')
                    </td>
                    <td>
                        @if(!is_null($car->groundclearance))
                        {{ $car->groundclearance }} m
                        @else
                        - cm
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    {{-- 過去のランキング一覧を表示--}}
    @include('car.commons.pastlist')

@endsection