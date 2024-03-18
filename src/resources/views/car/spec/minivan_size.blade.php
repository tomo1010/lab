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
                    <th>名前</th>
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
                        @if($car->minivan_size == 1)
                        XS
                        @elseif($car->minivan_size == 2)
                        S
                        @elseif($car->minivan_size == 3)
                        M
                        @elseif($car->minivan_size == 4)
                        L
                        @elseif($car->minivan_size == 5)
                        XL
                        @else
                        -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    {{-- 過去のランキング一覧を表示--}}
    @include('car.commons.pastlist')

@endsection