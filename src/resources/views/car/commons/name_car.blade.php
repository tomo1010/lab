<a href="{{ route('car.show', [$car->id]) }}">
<img src="{{ asset('img/' . $car->maker_kana . '/' . $car->model . '.jpg' ) }}" alt="{{$car->maker}}{{$car->name}}"></br>
{{$car->name}}</a>