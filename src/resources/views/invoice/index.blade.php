<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">請求書印刷</h2>
    </x-slot>


    @if (session('success'))
    <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
        {{ session('success') }}
    </div>
    @endif



    <div class="max-w-4xl mx-auto mt-6">
        <form method="POST" :action="action" x-data="{ action: '{{ route('pdf.generatePdf') }}' }" id="invoice-form">

            @csrf
            <input type="hidden" name="view" value="invoice.createPdf">

            <div class="bg-white p-8 border border-gray-300 rounded-md shadow-md text-sm">
                <div class="text-center text-2xl font-bold border-y border-black py-3 mb-6">請求書</div>

                <div class="text-right text-xs text-gray-600 mb-2">
                    発行日：
                    <input type="date" name="date" class="border rounded px-2 py-1 text-xs" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="text-right text-xs text-gray-600 mb-4">
                    明細枚数（本紙含む）：
                    <select name="page_count" class="border rounded px-2 py-1 text-xs">
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ $i === 1 ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block mb-1">請求先宛名：</label>
                    <div class="flex gap-2">
                        <input type="text" name="client" class="w-full border rounded px-2 py-1">
                        <select name="to_suffix" class="border rounded px-2 py-1 text-sm">
                            <option value="様">様</option>
                            <option value="御中">御中</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-1">請求先住所：</label>
                    <input type="text" name="client_address" class="w-full border rounded px-2 py-1" placeholder="〒を全角入力→変換">
                </div>

                <div class="mb-6" x-data="{
                    prices: [0, 0, 0, 0, 0],
                    get total() {
                        return this.prices.reduce((a, b) => Number(a) + Number(b), 0);
                    }
                }">
                    <label class="block mb-1">請求内容：</label>
                    <template x-for="i in 5" :key="i">
                        <div class="flex gap-4 mb-3">
                            <input :name="`item_${i}`" type="text" class="w-2/3 border rounded px-2 py-1" :placeholder="`項目`">
                            <input :name="`price_${i}`" type="number" class="w-1/3 border rounded px-2 py-1" placeholder="金額" x-model.number="prices[i - 1]" min="0">
                        </div>
                    </template>

                    <div class="flex gap-4 items-center mb-3" x-data @input="document.getElementById('hidden_total').value = total">
                        <input type="text" class="w-2/3 bg-gray-200 border rounded px-2 py-1" placeholder="合計" disabled>
                        <input type="number" class="w-1/3 bg-gray-200 border rounded px-2 py-1" :value="total" readonly>
                        <input type="hidden" name="total" id="hidden_total" :value="total">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-1">備考：</label>
                    <textarea name="message" class="w-full h-24 border rounded px-2 py-1 text-sm"></textarea>
                </div>

                <!-- 会社名 -->
                <div class="mt-6 border-t pt-4">
                    <div class="mb-2">発行者：</div>
                    <div class="mb-2">
                        〒：
                        <input type="text" name="postal" id="postal" class="w-24 border rounded px-2 py-1" placeholder="123-4567" inputmode="numeric" autocomplete="postal-code">
                        <input type="text" name="address" id="address" class="w-full border rounded px-2 py-1 mt-2" placeholder="住所を入力してください">
                        <input type="text" name="name" id="name" class="w-full border rounded px-2 py-1 mt-2" placeholder="名前を入力してください">
                    </div>

                    <div class="mb-4 flex flex-col md:flex-row md:space-x-4">
                        <div class="md:w-1/2">
                            TEL：
                            <input type="tel" name="tel" id="tel" class="w-full border rounded px-2 py-1" placeholder="090-1234-5678" inputmode="tel" autocomplete="tel">
                        </div>
                        <div class="md:w-1/2 mt-2 md:mt-0">
                            FAX：
                            <input type="tel" name="fax" id="fax" class="w-full border rounded px-2 py-1" placeholder="03-1234-5678" inputmode="tel" autocomplete="tel">
                        </div>
                    </div>

                    <div class="mb-4 flex flex-col md:flex-row md:space-x-4">
                        <div class="md:w-1/2">
                            E-Mail：
                            <input type="email" name="mail" id="mail" class="w-full border rounded px-2 py-1" placeholder="example@example.com" autocomplete="email">
                        </div>
                        <div class="md:w-1/2 mt-2 md:mt-0">
                            URL：
                            <input type="text" name="url" id="url" class="w-full border rounded px-2 py-1" placeholder="https://example.com" autocomplete="url">
                        </div>
                        <div class="md:w-1/2 mt-2 md:mt-0">
                            インボイス番号：
                            <input type="text" name="invoice_number" id="invoice_number" class="w-full border rounded px-2 py-1" placeholder="T+13桁">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">振込先</label>
                        <input type="text" name="transfer_1" id="transfer_1" class="w-full border rounded px-2 py-1 mb-2" placeholder="○○銀行 ○○支店　普通　口座 1234567">
                        <input type="text" name="transfer_2" id="transfer_2" class="w-full border rounded px-2 py-1 mb-2" placeholder="○○銀行 ○○支店　普通　口座 1234567">
                        <input type="text" name="transfer_3" id="transfer_3" class="w-full border rounded px-2 py-1" placeholder="○○銀行 ○○支店　普通　口座 1234567">
                    </div>

                    <div class="mt-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" id="save_to_cookie" class="mr-2">
                            発信者情報を保存しておく
                        </label>
                    </div>
                </div>



                <div class="submit-btn flex gap-4 justify-center mt-6">
                    <!-- PDF作成ボタン -->
                    <button
                        type="submit"
                        @click="action = '{{ route('pdf.generatePdf') }}'"
                        class="bg-blue-600 text-white rounded px-6 py-2 hover:bg-blue-700">

                        PDF作成
                    </button>

                    <!-- ログインユーザの制限処理 -->
                    @auth
                    @php
                    $limit = auth()->user()->limit();
                    $count = auth()->user()->invoices()->count(); //ページ別の修正
                    $isOverLimit = $count >= $limit;
                    @endphp
                    <!-- 保存ボタン -->
                    <button
                        type="submit"
                        @click="action = '{{ route('invoice.store') }}'"
                        class="bg-green-600 text-white rounded px-6 py-2 hover:bg-green-700">
                        保存
                    </button>
                    @endauth
                </div>



                <!-- データ保存一覧　-->
                @auth
                <x-save-list :items="$invoices" itemName="invoice" :is-over-limit="$isOverLimit" routePrefix="invoice" />
                @endauth


            </div>
        </form>
    </div>


    <script>
        const fields = ['postal', 'address', 'name', 'tel', 'fax', 'mail', 'url', 'transfer_1', 'transfer_2', 'transfer_3'];
        fields.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.addEventListener('input', function() {
                    if (document.getElementById('save_to_cookie').checked) {
                        setCookie(field, this.value, 30);
                    }
                });
            }
        });

        window.addEventListener('DOMContentLoaded', () => {
            fields.forEach(field => {
                const value = getCookie(field);
                if (value) {
                    document.getElementById(field).value = value;
                }
            });

            if (fields.some(field => getCookie(field))) {
                document.getElementById('save_to_cookie').checked = true;
            }
        });

        document.getElementById('save_to_cookie').addEventListener('change', function() {
            if (this.checked) {
                fields.forEach(field => {
                    const value = document.getElementById(field).value;
                    setCookie(field, value, 30);
                });
                alert('発信者情報をクッキーに保存しました。');
            } else {
                fields.forEach(field => deleteCookie(field));
                alert('クッキーから発信者情報を削除しました。');
            }
        });

        function setCookie(name, value, days) {
            const expires = new Date(Date.now() + days * 864e5).toUTCString();
            document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/`;
        }

        function getCookie(name) {
            return document.cookie.split('; ').reduce((r, v) => {
                const parts = v.split('=');
                return parts[0] === name ? decodeURIComponent(parts[1]) : r;
            }, '');
        }

        function deleteCookie(name) {
            setCookie(name, '', -1);
        }
    </script>
</x-app-layout>