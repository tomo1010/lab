<p>過去のランキング</p>
<table class="table">
    <tbody>

        @for ($i = $thisyear; $i > 2019; $i--)
        @if ($i >= 2025)
        <tr>
            <td>
                <a href="{{ route('car.spec', ['genre'=>$genre, 'spec'=>$spec, 'year'=>$i, 'half'=>2]) }}">
                    {{$i}}年下半期 @include('car.commons.name_spec')で比較
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="{{ route('car.spec', ['genre'=>$genre, 'spec'=>$spec, 'year'=>$i, 'half'=>1]) }}">
                    {{$i}}年上半期 @include('car.commons.name_spec')で比較
                </a>
            </td>
        </tr>
        @else
        <tr>
            <td>
                <a href="{{ route('car.spec', ['genre'=>$genre, 'spec'=>$spec, 'year'=>$i, 'half'=>1]) }}">
                    {{$i}}年 @include('car.commons.name_spec')で比較
                </a>
            </td>
        </tr>
        @endif
        @endfor



    </tbody>
</table>