@extends('layouts.app')

@section('content')

    <h1>{{$year}}年ミニバンを発売日で比較</h1>

    @include('car.commons.menubar')

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>名前</th>
                                <th>発売日</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($releases as $car)
                            <tr>
                                <td>
                                    @include('car.commons.name')
                                </td>
                                <td>
                                    {{ $car->release }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


        @for ($i = $thisYear; $i > 2019; $i--)
        <a href="{{ route('car.minivanRelease', ['year'=>$i]) }}">{{$i}}年ミニバンを発売日で比較</a><br>
        @endfor

@endsection