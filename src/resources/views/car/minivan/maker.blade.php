@extends('layouts.app')

@section('content')

    <h1>{{$year}}年ミニバンをメーカーで比較</h1>

    <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item"><a href="#maker" class="nav-link active" data-toggle="tab">メーカー</a></li>
        <li class="nav-item"><a href="#name" class="nav-link" data-toggle="tab">名前</a></li>
        <li class="nav-item"><a href="#release" class="nav-link" data-toggle="tab">発売日</a></li>
        <li class="nav-item"><a href="#plice" class="nav-link" data-toggle="tab">価格</a></li>
        <li class="nav-item"><a href="#tax" class="nav-link" data-toggle="tab">税金</a></li>
    </ul>


        <div class="tab-content">

            <div id="maker" class="tab-pane active">
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
                                <a href="{{ route('car.show', [$car->id]) }}">{{$car->name}}</a>
                            </td>
                            <td>
                                {{ $car->maker }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        @for ($i = 2020; $i < 2025; $i++)
        <a href="{{ route('car.minivanMaker', ['year'=>$i]) }}">{{$i}}年ミニバンをメーカーで比較　</a><br>
        @endfor

@endsection