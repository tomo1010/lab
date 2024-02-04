@extends('layouts.app')

@section('content')

    <h1>{{$year}}ミニバン一覧</h1>

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
                                <td>{{ $car->maker }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>

            <div id="name" class="tab-pane">
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
                                <td>{{ $car->name }}</td>
                                <td>{{ $car->grade }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>

            <div id="release" class="tab-pane active">
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
                                <a href="{{ route('car.show', [$car->id]) }}">{{$car->name}}</a>                                
                                </td>
                                <td>{{ $car->release }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>


            <div id="plice" class="tab-pane">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>名前</th>
                                <th>グレード</th>
                                <th>価格</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prices as $car)
                            <tr>
                                <td>{{ $car->name }}</td>
                                <td>{{ $car->grade }}</td>
                                <td>{{ $car->price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>




            <div id="tax" class="tab-pane">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>車名</th>
                                <th>排気量</th>                              
                                <th>自動車税</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($taxs as $car)
                            <tr>
                                <td>{{ $car->name }}</td>
                                <td>{{ $car->displacement }}cc</td>
                                <td>{{ $car->tax }}円</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>

        </div>

@endsection