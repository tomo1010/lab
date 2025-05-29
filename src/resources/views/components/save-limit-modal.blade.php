<div x-data="{ showModal: false, isOverLimit: {{ $isOverLimit ? 'true' : 'false' }} }">
    <!-- 保存ボタン -->
    <button type="button"
        @click="isOverLimit ? showModal = true : saveOnly()"
        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
        保存
    </button>

    <!-- モーダル -->
    <div x-show="showModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div @click.away="showModal = false"
            class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full"
            x-show="showModal"
            x-transition>
            <h2 class="text-lg font-semibold text-red-600 mb-4">保存件数の上限に達しました</h2>
            <p class="mb-4 text-gray-700">
                保存すると一番古いデータが削除されます。続けますか？
            </p>
            <div class="flex justify-end space-x-2">
                <button @click="showModal = false"
                    class="px-4 py-2 text-gray-600 hover:underline">
                    キャンセル
                </button>
                <button @click="showModal = false; saveOnly();"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    続けて保存
                </button>
            </div>
        </div>
    </div>
</div>