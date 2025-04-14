@extends('car.layouts.app')

@section('content')

<p>
<h1>{{$car->name}}詳細ページ</h1>
</p>
<table class="table table-striped">

        <tr>
                <th>画像</th>
                <td><img src="{{ asset('img/' . $car->year . '/' . '180' . '/' . $car->maker_kana . '/' . $car->model . '.jpg' ) }}" alt="{{$car->maker}}{{$car->name}}"></br>
                </td>
        </tr>

        <tr>
                <th>id</th>
                <td>{{ $car->id }}</td>
        </tr>

        <tr>
                <th>メーカー</th>
                <td>{{ $car->maker }}</td>
        </tr>

        <tr>
                <th>車名</th>
                <td>{{$car->name}}</td>
        </tr>

        <tr>
                <th>発売日</th>
                <td>{{ $car->release->format('Y年m月') }}</td>
        </tr>

        <tr>
                <th>グレード</th>
                <td>{{ $car->grade }}</td>
        </tr>

        <tr>
                <th>価格</th>
                <td>{{ $car->price }}万円〜</td>
        </tr>

        <tr>
                <th>型式</th>
                <td>{{ $car->model }}</td>
        </tr>

        <tr>
                <th>最小回転半径</th>
                <td>{{ $car->turningradius }}m</td>
        </tr>

        <tr>
                <th>駆動方式</th>
                <td>{{ $car->drive }}</td>
        </tr>

        <tr>
                <th>全長×全幅×全高</th>
                <td>{{ $car->size }}cm</td>
        </tr>

        <tr>
                <th>ドア数</th>
                <td>{{ $car->door }}</td>
        </tr>

        <tr>
                <th>ホイールベース</th>
                <td>{{ $car->wheelbase }}m</td>
        </tr>

        <tr>
                <th>ミッション</th>
                <td>{{ $car->mission }}</td>
        </tr>

        <tr>
                <th>トレッド</th>
                <td>{{ $car->tred }}</td>
        </tr>

        <tr>
                <th>AIシフト</th>
                <td>{{ $car->shift }}</td>
        </tr>

        <tr>
                <th>室内(全長×全幅×全高)</th>
                <td>{{ $car->indoorsize }}cm</td>
        </tr>

        <tr>
                <th>車両重量</th>
                <td>{{ $car->weight }}kg</td>
        </tr>

        <tr>
                <th>シート列数</th>
                <td>{{ $car->seats }}</td>
        </tr>

        <tr>
                <th>積載量</th>
                <td>{{ $car->capacity }}kg</td>
        </tr>

        <tr>
                <th>乗車定員</th>
                <td>{{ $car->ridingcapacity }}人</td>
        </tr>

        <tr>
                <th>総重量</th>
                <td>{{ $car->grossweight }}kg</td>
        </tr>

        <tr>
                <th>ミッション位置</th>
                <td>{{ $car->missionposition }}</td>
        </tr>

        <tr>
                <th>最低地上高</th>
                <td>{{ $car->groundclearance }}cm</td>
        </tr>

        <tr>
                <th>色数</th>
                <td>{{ $car->colors }}</td>
        </tr>

        <tr>
                <th>コメント</th>
                <td>{{ $car->comment }}</td>
        </tr>

        <tr>
                <th>エンジン型式</th>
                <td>{{ $car->enginemodel }}</td>
        </tr>

        <tr>
                <th>環境対策エンジン</th>
                <td>{{ $car->environmentalengine }}</td>
        </tr>

        <tr>
                <th>種類</th>
                <td>{{ $car->kinds }}</td>
        </tr>

        <tr>
                <th>使用燃料</th>
                <td>{{ $car->fuel }}</td>
        </tr>

        <tr>
                <th>過給機</th>
                <td>{{ $car->supercharger }}</td>
        </tr>

        <tr>
                <th>燃料タンク</th>
                <td>{{ $car->fueltank }}L</td>
        </tr>

        <tr>
                <th>可変気筒装置</th>
                <td>{{ $car->cylinderdevice }}</td>
        </tr>

        <tr>
                <th>燃費（JC08）</th>
                <td>{{ $car->JC08 }}</td>
        </tr>

        <tr>
                <th>総排気量</th>
                <td>{{ $car->displacement }}cc</td>
        </tr>

        <tr>
                <th>燃費（WLTC）
                </th>
                <td>{{ $car->WLTC }}km/L</td>
        </tr>

        <tr>
                <th>燃費基準達成</th>
                <td>{{ $car->achievedfuel }}</td>
        </tr>

        <tr>
                <th>最高出力</th>
                <td>{{ $car->ps }}ps</td>
        </tr>

        <tr>
                <th>トルク</th>
                <td>{{ $car->torque }}</td>
        </tr>

        <tr>
                <th>位置</th>
                <td>{{ $car->position }}</td>
        </tr>

        <tr>
                <th>ステアリングギア方式</th>
                <td>{{ $car->steeringgear }}</td>
        </tr>

        <tr>
                <th>パワーステアリング</th>
                <td>{{ $car->powersteering }}</td>
        </tr>

        <tr>
                <th>VGS</th>
                <td>{{ $car->VGS }}</td>
        </tr>

        <tr>
                <th>サスペンション形式前</th>
                <td>{{ $car->Fsuspension }}</td>
        </tr>

        <tr>
                <th>サスペンション形式後</th>
                <td>{{ $car->Rsuspension }}</td>
        </tr>

        <tr>
                <th>タイヤサイズ前</th>
                <td>{{ $car->Fttiresize }}</td>
        </tr>

        <tr>
                <th>タイヤサイズ後</th>
                <td>{{ $car->Rtiresize }}</td>
        </tr>

        <tr>
                <th>ブレーキ形式前</th>
                <td>{{ $car->Fbraketype }}</td>
        </tr>

        <tr>
                <th>ブレーキ形式後</th>
                <td>{{ $car->Rbraketype }}</td>
        </tr>

        <tr>
                <th>データ年度</th>
                <td>{{ $car->year }}</td>
        </tr>

        <tr>
                <th>ジャンル</th>
                <td>{{ $car->genre }}</td>
        </tr>

</table>


@endsection