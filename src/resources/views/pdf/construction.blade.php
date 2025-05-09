<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight shadow-sm">
            ボディコーティング施工証明書印刷
        </h2>
    </x-slot>

    <div class="bg-gray-100 flex justify-center pt-8 px-4">
        <div class="no-print bg-white rounded-2xl shadow-sm p-8 w-full max-w-xl mt-4">
            <form method="POST" action="{{ route('pdf.generatePdf') }}" target="_blank" class="space-y-6" id="construction-form">
                @csrf
                <input type="hidden" name="view" value="pdf.constructionPdf">

                <div>
                    <label for="customer" class="block text-sm font-medium text-gray-700">顧客名</label>
                    <input type="text" name="customer" id="customer"
                        class="mt-1 w-full border rounded px-1">
                </div>

                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">施工年月日</label>
                    <input type="date" name="date" id="date"
                        class="mt-1 w-full border rounded px-1">
                </div>

                <div>
                    <label for="guarantee" class="block text-sm font-medium text-gray-700 mb-1">保証期間</label>
                    <div class="space-y-2 sm:space-y-0 sm:space-x-4 sm:flex">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="inline-flex items-center">
                            <input
                                type="radio"
                                name="guarantee"
                                id="guarantee"
                                value="{{ $i }}年"
                                class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
                            <span class="ml-2">{{ $i }}年</span>
                            </label>
                            @endfor
                    </div>
                </div>

                <div>
                    <label for="carName" class="block text-sm font-medium text-gray-700">車種</label>
                    <input type="text" name="carName" id="carName"
                        class="mt-1 w-full border rounded px-1">
                </div>

                <div>
                    <label for="frameNumbar" class="block text-sm font-medium text-gray-700">車台番号</label>
                    <input type="text" name="frameNumbar" id="frameNumbar"
                        class="mt-1 w-full border rounded px-1">
                </div>

                <div>
                    <label for="note" class="block text-sm font-medium text-gray-700">備考</label>
                    <input type="text" name="note" id="note"
                        class="mt-1 w-full border rounded px-1">
                </div>

                <!-- 発信者情報 -->
                <div class="border-t pt-4 mt-6">
                    <div class="mb-2 text-sm font-medium text-gray-700">施工店：</div>

                    <div class="mb-2">
                        〒：
                        <input type="text" name="postal" id="postal" style="width: 100px;" class="mt-1 border rounded px-1" placeholder="123-4567" inputmode="numeric" autocomplete="postal-code">
                        <input type="text" name="address" id="address" class="mt-1 w-full border rounded px-1" placeholder="住所を入力してください">
                        <input type="text" name="name" id="name" class="mt-1 w-full border rounded px-1" placeholder="名前を入力してください">
                    </div>

                    <div class="mb-2 flex flex-col md:flex-row md:space-x-4">
                        <div class="md:w-1/2 mb-2 md:mb-0">
                            TEL：
                            <input type="tel" name="tel" id="tel" class="mt-1 w-full border rounded px-1" placeholder="090-1234-5678" inputmode="tel" autocomplete="tel">
                        </div>
                        <div class="md:w-1/2">
                            FAX：
                            <input type="tel" name="fax" id="fax" class="mt-1 w-full border rounded px-1" placeholder="03-1234-5678" inputmode="tel" autocomplete="tel">
                        </div>
                    </div>

                    <div class="mb-2 flex flex-col md:flex-row md:space-x-4">
                        <div class="md:w-1/2 mb-2 md:mb-0">
                            E-Mail：
                            <input type="email" name="mail" id="mail" class="mt-1 w-full border rounded px-1" placeholder="example@example.com" autocomplete="email">
                        </div>
                        <div class="md:w-1/2">
                            URL：
                            <input type="url" name="url" id="url" class="mt-1 w-full border rounded px-1" placeholder="https://example.com" autocomplete="url">
                        </div>
                    </div>

                    <div class="mb-4 mt-2">
                        <label>
                            <input type="checkbox" id="save_to_cookie" class="mr-1">
                            発信者情報を保存しておく
                        </label>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        PDFを生成
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 発信者情報保存スクリプト -->
    <script>
        const senderFields = ['postal', 'address', 'name', 'tel', 'fax', 'mail', 'url'];
        const storageKey = 'sender_info';

        document.getElementById('construction-form').addEventListener('submit', function() {
            if (document.getElementById('save_to_cookie').checked) {
                const data = {};
                senderFields.forEach(id => {
                    data[id] = document.getElementById(id).value;
                });
                localStorage.setItem(storageKey, JSON.stringify(data));
            } else {
                localStorage.removeItem(storageKey);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const saved = localStorage.getItem(storageKey);
            if (saved) {
                const data = JSON.parse(saved);
                senderFields.forEach(id => {
                    if (data[id]) {
                        document.getElementById(id).value = data[id];
                    }
                });
                document.getElementById('save_to_cookie').checked = true;
            }
        });
    </script>
</x-app-layout>