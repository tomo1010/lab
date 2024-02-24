@extends('layouts.app')

@section('content')

@include('car.minivan.menubar')

    <h1>{{$year}}年航続距離で比較</h1>

    @if($year == 2024)
    @include('car.minivan.contents_maker')
    @endif

            <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>名前</th>
                            <th>航続距離</th>                              
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cruisings as $car)
                        <tr>
                            <td>
                                @include('car.commons.name')
                            </td>
                            <td>
                                {{ $car->cruising }}km
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

        @for ($i = $thisYear; $i > 2019; $i--)
        <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$i,'spec'=>'cruising']) }}">{{$i}}年ミニバンをkg単価で比較</a><br>
        @endfor

@endsection