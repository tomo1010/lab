@extends('layouts.app')

@section('content')

    <p>
    <h1>{{$year}}年ミニバンを車名で比較</h1>
    </p>
    
    @include('car.minivan.menubar')

            <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>名前</th>
                                <th>グレード</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($names as $car)
                            <tr>
                                <td>
                                    @include('car.commons.name')
                                </td>
                                <td>
                                    {{ $car->grade }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

        @for ($i = $thisYear; $i > 2019; $i--)
        <a href="{{ route('car.spec', ['genre'=>$genre,'year'=>$i,'spec'=>'name']) }}">{{$i}}年ミニバンを車名で比較</a><br>
        @endfor

@endsection