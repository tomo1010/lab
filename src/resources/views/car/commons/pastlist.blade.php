<p>過去のランキング</p>
<table class="table">
    <tbody>
        @for ($i = $thisYear; $i > 2019; $i--)
            <tr><td><a href="{{ route('car.spec', ['genre'=>$genre,'spec'=>$spec,'year'=>$i,'half'=>1]) }}">{{$i}}年上半期 ミニバンを@include('car.commons.nameSpec')で比較</a></td></tr>
            <tr><td><a href="{{ route('car.spec', ['genre'=>$genre,'spec'=>$spec,'year'=>$i,'half'=>2]) }}">{{$i}}年下半期 ミニバンを@include('car.commons.nameSpec')で比較</a></td></tr>
        @endfor
    </tbody>
</table>