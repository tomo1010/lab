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
                    <th>名前</th>
                    <th>@include('car.commons.nameSpec')</th>                              
                </tr>
            </thead>
            <tbody>
                @foreach ($cars as $car)
                <tr>
                    <td>
                        @include('car.commons.nameCar')
                    </td>
                    <td>
                        {{ $car->tax }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    {{-- 過去のランキング一覧を表示--}}
    @include('car.commons.pastlist')

@endsection