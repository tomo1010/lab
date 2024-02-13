@extends('layouts.app')

@section('content')

@include('car.minivan.menubar')

    <h1>{{$year}}年メーカーで比較</h1>

    @if($year == 2024)
    @include('car.minivan.contents_maker')
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
        <a href="{{ route('car.maker', ['genre'=>$genre,'year'=>$i]) }}">{{$i}}年ミニバンをメーカーで比較</a><br>
        @endfor

@endsection