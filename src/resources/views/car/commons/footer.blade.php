{{-- ジャンル別ヘッダ分岐--}}

@if(Request::is('car/minivan*'))
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#2981C0;">
    <a class="navbar-brand" href="{{ route('car.category', ['genre'=>$genre]) }}"><img src="https://minivan.about-car.net/wp-content/uploads/tcd-w/logo.png"></a>

@elseif(Request::is('car/suv*'))
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#748300;">
    <a class="navbar-brand" href="{{ route('car.category', ['genre'=>$genre]) }}"><img src="https://about-car.net/suv/wp-content/uploads/tcd-w/logo.png"></a>
    
@else
    @include('car.commons.title')
@endif 

Copyright © kurumayalabo All rights reserved.