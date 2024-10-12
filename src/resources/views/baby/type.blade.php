@extends('baby.layouts.app')

@section('content')

@include('baby.commons.menu')

<div class="flex justify-center space-x-4 my-4">
    <a href="{{ route('baby.type', [$type, $page-1]) }}" class="text-blue-500 hover:underline">
        {{ $page }}ページ
    </a>
    <a href="{{ route('baby.type', [$type, $page+1]) }}" class="text-blue-500 hover:underline">
        次のページ
    </a>
</div>


<div class="max-w-6xl mx-auto p-4">
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto">
            <tbody>
                @foreach ($items as $item)
                <tr class="border-b">
                    <!-- Product Image with fixed width -->
                    <td class="p-4 w-[150px]">
                        <a href="{{ $item['itemUrl'] }}">
                            <img class="w-[128px] h-[128px] object-contain rounded-md" 
                                 src="{{ $item['mediumImageUrls'][0]['imageUrl'] }}" 
                                 alt="Product Image">
                        </a>
                    </td>

                    <!-- Product Name with flexible width -->
                    <td class="p-4">
                        <a href="{{ $item['itemUrl'] }}" class="text-xs text-gray-700 hover:text-blue-500">
                            {{ \Illuminate\Support\Str::limit($item['itemName'], 75) }}
                        </a>
                    </td>



                    <!-- Price & Reviews with flexible width -->
                    <td class="p-4 text-right w-[115px]">
                        <span class="text-2xl text-red-500 font-semibold">{{ $item['itemPrice'] }}</span><span class="text-red-500">円</span>
                        <div class="mt-1 text-gray-600">
                            <i class="far fa-comments"></i>
                            <a href="{{ $item['itemUrl'] }}" class="hover:text-blue-500">
                                {{ $item['reviewCount'] }}件
                            </a>
                        </div>
                        ポイント{{ $item['pointRate'] }}.0倍
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>









@endsection
