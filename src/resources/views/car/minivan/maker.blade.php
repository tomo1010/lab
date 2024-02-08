@extends('layouts.app')

@section('content')

    <h1>{{$year}}年メーカーで比較</h1>

    @include('car.commons.menubar')

    @if($year == 2024)
    @include('car.commons.maker')
    @endif

            <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>名前</th>
                            <th>メーカー</th>                              
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($makers as $car)
                        <tr>
                            <td>
                                @include('car.commons.name')
                            </td>
                            <td>
                                {{ $car->maker }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

        @for ($i = $thisYear; $i > 2019; $i--)
        <a href="{{ route('car.minivanMaker', ['year'=>$i]) }}">{{$i}}年ミニバンをメーカーで比較</a><br>
        @endfor

@endsection