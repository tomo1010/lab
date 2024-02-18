@extends('layouts.app')

@section('content')

@include('car.minivan.menubar')

    <h1>{{$year}}年kg単価で比較</h1>

    @if($year == 2024)
    @include('car.minivan.contents_maker')
    @endif

            <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>名前</th>
                            <th>kg単価</th>                              
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kgs as $car)
                        <tr>
                            <td>
                                @include('car.commons.name')
                            </td>
                            <td>
                                {{ $car->kg }}円
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

        @for ($i = $thisYear; $i > 2019; $i--)
        <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$i,'spec'=>'tax']) }}">{{$i}}年ミニバンを自動車税で比較</a><br>
        @endfor

@endsection