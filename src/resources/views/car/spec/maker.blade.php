@extends('layouts.app')

@section('content')

@include('car.commons.menubar')

    <p><h1>
        {{$year}}年
        @if($half == 1)
            上半期
        @elseif($half == 2)
            下半期
        @else($half == 0)
        @endif
        メーカーで比較
    </h1></p>

        @if($year == $thisYear)
            {{-- ジャンル別コラム分岐--}}
            @if(Request::is('car/minivan*'))
                @include('car.minivan.contents_maker')
            @elseif(Request::is('car/suv*'))
                @include('car.suv.contents_maker')
            @else
                @include('car.commons.title')
            @endif
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
            <a href="{{ route('car.spec', ['genre'=>$genre,'spec'=>'maker','year'=>$i]) }}">{{$i}}年    
            ミニバンをメーカーで比較</a><br>
        @endfor

@endsection