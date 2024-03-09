@extends('layouts.app')

@section('content')

    {{-- メニューバー --}}
    @include('car.commons.menubar') 

    {{-- ページタイトルを上半期下半期に分けて表示 --}}
    @include('car.commons.titleHalf') 

    {{-- 最新年度ならジャンル別のコラムを表示--}}
    @include('car.commons.explanation') 

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>車名</th>
                    <th>@include('car.commons.nameSpec')</th>                              
                </tr>
            </thead>
            <tbody>
                @foreach ($JC08s as $car)
                <tr>
                    <td>
                        @include('car.commons.nameCar')
                    </td>
                    <td>
                        @if(!is_null($car->JC08))
                        {{ $car->JC08 }} km/L
                        @else
                        - km/L
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    {{-- 過去のランキング一覧を表示--}}
    @include('car.commons.pastlist')

@endsection