@extends('baby.layouts.app')

@section('content')

@include('baby.commons.menu')

<p><a href="{{ route('baby.type', [$type, $page-1]) }}">{{ $page }}ページ</a>　<a href="{{ route('baby.type', [$type, $page+1]) }}">次のページ</a></p>

        <table class="table table-striped">
            <tbody>
                @foreach ($items as $item)

                <tr>
                    <td>
                    <a href="{{ $item['itemUrl'] }}"><img src="{{ $item['mediumImageUrls'][0]['imageUrl'] }}"></a>
                    </td>

                    <td>
                    <a href="{{ $item['itemUrl'] }}">{{ $item['itemName'] }}</a>
                    </td>

                    <td nowrap>
                    {{ $item['itemPrice'] }}円<br>
                    <i class="far fa-comments fa-lg"></i> <a href="{{ $item['itemUrl'] }}">{{ $item['reviewCount'] }}件</a><br>
                    </td>
                </tr>

                @endforeach


              </tbody>
        </table>

@endsection
