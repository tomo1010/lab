<p><h1>
    <span class="small">【 
    {{$year}}年
    @if($half == 1)
        上半期
    @elseif($half == 2)
        下半期
    @else($half == 0)
    @endif
    】</span>
    <br>
    @include('car.commons.name_spec')で比較
</h1></p>