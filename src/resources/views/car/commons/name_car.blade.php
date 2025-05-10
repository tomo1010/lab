<a href="{{ route('car.show', [$car->id]) }}">
    @if(($year > 2025) || ($year == 2025 && $half == 2))
    <img src="{{ asset('img/' . $car->year . '/' . $car->half . '/180/' . $car->maker_kana . '/' . $car->id . '-' . $car->model . '.jpg') }}" alt="{{ $car->maker }}{{ $car->name }}">
    @else
    <img src="{{ asset('img/' . $car->year . '/180/' . $car->maker_kana . '/' . $car->model . '.jpg') }}" alt="{{ $car->maker }}{{ $car->name }}">
    @endif
    <br>
    {{ $car->name }}
</a>