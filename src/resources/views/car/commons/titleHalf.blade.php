<p class="flex items-center space-x-2">
    <img src="{{ asset('img/car_category_icon/' . $spec . '.png') }}" alt="Car Genre Icon" class="w-14 h-14">

    <span class="text-2xl font-bold">
        <span class="text-sm text-gray-500">
            【{{$year}}年
            @if($half == 1)
            上半期
            @elseif($half == 2)
            下半期
            @endif
            】
        </span>
        <span class="text-lg text-gray-500">@include('car.commons.name_spec')で比較</span>
    </span>
</p>