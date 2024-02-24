@extends('layouts.app')

@section('content')

@include('car.minivan.menubar')

    <h1>{{$year}}年自動車税で比較</h1>

    @if($year == 2024)
    @include('car.minivan.contents_maker')
    @endif

            <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>名前</th>
                            <th>重量税</th>                              
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jtaxs as $car)
                        <tr>
                            <td>
                                @include('car.commons.name')
                            </td>
                            <td>
                                {{ $car->jtax }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

        @for ($i = $thisYear; $i > 2019; $i--)
        <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$i,'spec'=>'jtax']) }}">{{$i}}年ミニバンを重量税で比較</a><br>
        @endfor

@endsection