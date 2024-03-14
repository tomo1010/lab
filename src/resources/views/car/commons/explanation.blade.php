@if($year == $thisYear)

    @if(Request::is('car/minivan*'))
        @include('car.minivan.contents_maker')

    @elseif(Request::is('car/suv*'))
        @include('car.suv.contents_maker')

    @else
        @include('car.commons.title')

    @endif
    
@endif