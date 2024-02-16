@extends('layouts.app')

@section('content')

    <h1>ジャンル一覧</h1>

    <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item"><a href="#minivan" class="nav-link active" data-toggle="tab">ミニバン</a></li>
        <li class="nav-item"><a href="#puchi" class="nav-link" data-toggle="tab">プチバン</a></li>
        <li class="nav-item"><a href="#suv" class="nav-link" data-toggle="tab">SUV</a></li>
        <li class="nav-item"><a href="#compact" class="nav-link" data-toggle="tab">コンパクトカー</a></li>
        <li class="nav-item"><a href="#sedan" class="nav-link" data-toggle="tab">セダン</a></li>
        <li class="nav-item"><a href="#wagon" class="nav-link" data-toggle="tab">ステーションワゴン</a></li>
        <li class="nav-item"><a href="#courpe" class="nav-link" data-toggle="tab">クーペ</a></li>
        <li class="nav-item"><a href="#kei" class="nav-link" data-toggle="tab">軽自動車</a></li>
    </ul>


        <div class="tab-content">

            <div id="minivan" class="tab-pane active">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>名前</th>
                                <th>メーカー</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cars as $car)
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

            <div id="suv" class="tab-pane">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>名前</th>
                                <th>グレード</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cars as $car)
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
                            @foreach ($cars as $car)
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
                            @foreach ($cars as $car)
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
                            @foreach ($cars as $car)
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

        @for ($i = 2020; $i < 2025; $i++)
{{--        <a href="{{ route('car.minivan', ['year'=>$i]) }}">{{$i}}年ミニバン</a><br>--}}

        @endfor

@endsection