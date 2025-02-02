@extends('car.layouts.app')

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
                    <th>@include('car.commons.name_spec')（重量税+自賠責保険）</th>                              
                </tr>
            </thead>
            <tbody>
                @foreach ($cars as $car)
                <tr>
                    <td>
                        @include('car.commons.name_car')
                    </td>
                    <td>
                        @if(!empty($car->overhead))
                        {{ $car->jtax }} + {{ $car->jibai }} = {{ $car->overhead }}
                        @else
                        -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        ※車検総額には諸費用とは別に 工賃 + 部品代 が必要です。<p>

    {{-- 過去のランキング一覧を表示--}}
    @include('car.commons.pastlist')

@endsection