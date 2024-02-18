@extends('layouts.app')

@section('content')

    <h1>{{$spec}}</h1>

        @if (count($cars) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>比較年度</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = $thisYear; $i > 2019; $i--)
                        <a href="{{ route('car.spec', ['genre'=>$genre,'spec'=>'$spec','year'=>$i]) }}">{{$i}}年ミニバンを{{$spec}}で比較</a><br>
                    @endfor
                </tbody>
            </table>
        @endif

@endsection