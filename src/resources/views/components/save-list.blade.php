<!-- components/quote-list.blade.php -->
@props(['items', 'itemName', 'isOverLimit' => false, 'routePrefix'])

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">保存データ</h2>

        @if(isset($items) && $items->count())
        <ul class="mt-6 space-y-4">
            @foreach ($items as $item)
            @php
            $man = $item->total / 10000;
            $displayMan = fmod($man, 1) === 0.0 ? number_format($man, 0) : number_format($man, 1);
            @endphp
            <li class="p-4 bg-gray-100 rounded-lg flex justify-between items-center">
                <div>
                    <span class="text-lg font-semibold flex items-center space-x-2">
                        <a href="{{ route("{$routePrefix}.edit", $item->id) }}">
                            {{ $item->car }} {{ $item->color }} {{ $displayMan }}万円 {{ $item->customer_name }}様 {{ $item->item1_cost }}
                        </a>
                    </span>
                    <p class="text-sm text-gray-500">更新日時: {{ $item->updated_at->format('Y-m-d H:i') }}</p>
                    <p class="text-sm text-gray-500">メモ: {{ $item->memo }}</p>
                </div>

                <div class="flex space-x-2">
                    <!-- 編集 -->
                    <!--
                    <a href="{{ route("{$routePrefix}.edit", $item->id) }}"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 flex items-center space-x-2"
                        title="編集">
                        <i class="fas fa-edit"></i>
                    </a>
-->
                    <!-- コピー -->
                    <form action="{{ route("{$routePrefix}.copy", $item->id) }}" method="POST">
                        @csrf
                        <x-copy-limit-modal :is-over-limit="$isOverLimit" />
                    </form>

                    <!-- 削除 -->
                    <form action="{{ route("{$routePrefix}.destroy", $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 flex items-center space-x-2"
                            title="削除"
                            onclick="return confirm('本当に削除しますか？');">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>

            </li>
            @endforeach
        </ul>

        <div class="mt-6">
            {{ $items->links() }}
        </div>

        @else
        <p class="mt-6 text-gray-500">保存されたデータはありません。</p>
        @endif
    </div>
</div>