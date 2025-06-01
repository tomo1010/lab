<div x-data="{
    showModal: false,
    isOverLimit: {{ $isOverLimit ? 'true' : 'false' }},
    copyOnly() {
        this.$el.closest('form').submit();
    }
}">
    <!-- コピー ボタン -->
    <button type="button"
        @click="isOverLimit ? showModal = true : copyOnly()"
        class="bg-yellow-400 text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transition flex items-center space-x-2"
        title="コピー">
        <i class="fas fa-copy"></i>
    </button>

    <!-- モーダル -->
    <div x-show="showModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak>
        <div @click.away="showModal = false"
            @click.stop
            class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full"
            x-show="showModal"
            x-transition>
            <h2 class="text-lg font-semibold text-red-600 mb-4">保存件数の上限に達しました</h2>
            <p class="mb-4 text-gray-700">
                コピーすると一番古いデータが削除されます。続けますか？
            </p>
            <div class="flex justify-end space-x-2">
                <button type="button"
                    @click.stop="showModal = false"
                    class="px-4 py-2 text-gray-600 hover:underline">
                    キャンセル
                </button>
                <button type="button"
                    @click.stop="showModal = false; copyOnly();"
                    class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    続けてコピー
                </button>
            </div>
        </div>
    </div>
</div>