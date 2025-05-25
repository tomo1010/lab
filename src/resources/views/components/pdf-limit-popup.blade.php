@if(session('error'))
<div
    x-data="{ open: false }"
    x-init="requestAnimationFrame(() => open = true)"
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

    <!-- モーダル本体 -->
    <div
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
        <h2 class="text-xl font-bold mb-2 text-red-600">利用制限のお知らせ</h2>
        <p class="mb-4">{{ session('error') }}</p>

        @if(session('access_type') === 'register')
        <a href="{{ route('register') }}"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded mr-2">
            新規登録する
        </a>
        @elseif(session('access_type') === 'subscribe')
        <a href="{{ route('subscription.index') }}"
            class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded mr-2">
            サブスク登録する
        </a>
        @endif

        <button
            @click="open = false"
            type="button"
            class="mt-4 block text-sm text-gray-600 hover:underline">
            閉じる
        </button>
    </div>
</div>
@endif