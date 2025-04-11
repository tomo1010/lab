<p>
    <h1 class="text-2xl font-bold">
        <span class="text-sm text-gray-500">【 
        {{$year}}年
        @if($half == 1)
            上半期
        @elseif($half == 2)
            下半期
        @else($half == 0)
        @endif
        】</span>
        <br>
        <span class="text-lg text-blue-600">@include('car.commons.name_spec')で比較</span>
    </h1>
</p>