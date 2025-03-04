@extends('car.layouts.app')

@section('content')

    <h1>カテゴリー</h1>

        @if (count($cars) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>比較年度</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars as $car)
                    <tr>
                        <td>{{ $car->id }}</td>
                        <td>{{ $car->maker }}</td>
                        <td><a href="{{ route('car.show', [$car->id]) }}">{{$car->name}}</a></td>
                        <td>{{ $car->release }}</td>
                        <td>{{ $car->grade }}</td>
                        <td>{{ $car->price }}</td>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->turningradius }}</td>
                        <td>{{ $car->drive }}</td>
                        <td>{{ $car->size }}</td>
                        <td>{{ $car->doors }}</td>
                        <td>{{ $car->wheeelbase }}</td>
                        <td>{{ $car->mission }}</td>
                        <td>{{ $car->tred }}</td>
                        <td>{{ $car->shift }}</td>
                        <td>{{ $car->indoorsize }}</td>
                        <td>{{ $car->weight }}</td>
                        <td>{{ $car->seats }}</td>
                        <td>{{ $car->capacity }}</td>
                        <td>{{ $car->ridingcapacity }}</td>
                        <td>{{ $car->grossweight }}</td>
                        <td>{{ $car->missionposition }}</td>
                        <td>{{ $car->groundclearance }}</td>
                        <td>{{ $car->colors }}</td>
                        <td>{{ $car->comment }}</td>
                        <td>{{ $car->enginemodel }}</td>
                        <td>{{ $car->environmentalengine }}</td>
                        <td>{{ $car->kinds }}</td>
                        <td>{{ $car->fuel }}</td>
                        <td>{{ $car->supercharger }}</td>
                        <td>{{ $car->fueltank }}</td>
                        <td>{{ $car->cylinderdevice }}</td>
                        <td>{{ $car->JC08 }}</td>
                        <td>{{ $car->displacement }}</td>
                        <td>{{ $car->WLTC }}</td>
                        <td>{{ $car->achievedfuel }}</td>
                        <td>{{ $car->ps }}</td>
                        <td>{{ $car->torque }}</td>
                        <td>{{ $car->position }}</td>
                        <td>{{ $car->steeringgear }}</td>
                        <td>{{ $car->powersteering }}</td>
                        <td>{{ $car->VGS }}</td>
                        <td>{{ $car->Fsuspension }}</td>
                        <td>{{ $car->Rsuspension }}</td>
                        <td>{{ $car->Fttiresize }}</td>
                        <td>{{ $car->Rtiresize }}</td>
                        <td>{{ $car->Fbraketype }}</td>
                        <td>{{ $car->Rbraketype }}</td>
                        <td>{{ $car->year }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        @endif

@endsection