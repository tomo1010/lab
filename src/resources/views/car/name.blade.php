@extends('layouts.app')

@section('content')

    <h1>{{$year}}年ミニバンを車名で比較</h1>

    @include('car.commons.menubar')

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
        <a href="{{ route('car.minivanName', ['year'=>$i]) }}">{{$i}}年ミニバンを車名で比較</a><br>
        @endfor

@endsection