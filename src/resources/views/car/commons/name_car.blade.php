<a href="{{ route('car.show', [$car->id]) }}">
<img src="{{ asset('img/' . $car->model . '.jpg' ) }}" alt=""></br>
{{$car->name}}</a>