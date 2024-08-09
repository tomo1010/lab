<a href="{{ route('car.show', [$car->id]) }}">
<img src="{{ asset('img/' . $car->year . '/' . '180' . '/' . $car->maker_kana . '/' . $car->model . '.jpg' ) }}" alt="{{$car->maker}}{{$car->name}}"></br>
{{$car->name}}</a>