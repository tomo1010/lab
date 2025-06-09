<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            請求書印刷
        </h2>
    </x-slot>

    <style>
        .fax-container {
            font-size: 12pt;
            padding: 2rem;
            background-color: #fff;
            border: 1px solid #ddd;
            margin-top: 1rem;
        }

        .title {
            text-align: center;
            font-size: 20pt;
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 10px 0;
            margin-bottom: 20px;
        }

        .input-text {
            width: 100%;
            padding: 5px;
            font-size: 12pt;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .textarea {
            width: 100%;
            height: 60px;
            font-size: 12pt;
            padding: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .footer {
            margin-top: 30px;
            border-top: 1px solid #000;
            padding-top: 10px;
        }

        .submit-btn {
            margin-top: 30px;
            text-align: center;
        }

        .submit-btn button {
            font-size: 14pt;
            padding: 10px 20px;
        }

        .right-align-small {
            text-align: right;
            font-size: 10pt;
            color: #555;
            margin-bottom: 0.25rem;
        }

        .left-align {
            text-align: left;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
    </style>

    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('invoice.createPdf') }}">
            @csrf

            <div class="fax-container bg-white shadow-md rounded-md">
                <div class="title">ご請求書</div>

                <div class="right-align-small">
                    発行日：
                    <input type="date" name="date" class="border rounded px-2 py-1 text-sm" value="{{ date('Y-m-d') }}" required>
                </div>


                <div class="right-align-small">
                    明細枚数（本紙含む）：
                    <select name="page_count" class="border rounded px-2 py-1 text-sm">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>

                <div class="left-align">
                    <label class="block mb-1">請求先宛名：</label>
                    <div class="flex items-center gap-2">
                        <input type="text" name="client" class="input-text w-full">
                        <select name="to_suffix" class="border rounded px-2 py-1 text-sm">
                            <option value="様">様</option>
                            <option value="御中">御中</option>
                        </select>
                    </div>

                    <div class="left-align">
                        <label class="block mb-1">請求先住所：</label>
                        <div class="flex items-center">
                            <input type="text" name="billingAddress" class="input-text" placeholder="〒を全角入力→変換">
                        </div>
                    </div>

                    <div class="left-align" x-data="{
                        prices: [0, 0, 0, 0, 0],
                        get total() {
                            return this.prices.reduce((a, b) => Number(a) + Number(b), 0);
                        }
                    }">
                        <label class="block mb-1">請求内容：</label>
                        <template x-for="i in 5" :key="i">
                            <div class="flex items-center gap-4 mb-3">
                                <input :name="`item_${i}`" type="text" class="input-text w-2/3" :placeholder="`項目`">
                                <input
                                    :name="`price_${i}`"
                                    type="number"
                                    class="input-text w-1/3"
                                    placeholder="金額"
                                    x-model.number="prices[i-1]"
                                    min="0">
                            </div>
                        </template>
                        <div class="flex items-center gap-4 mb-3" x-data @input="document.getElementById('hidden_total').value = total">
                            <input type="text" class="input-text w-2/3 bg-gray-200" placeholder="合計" disabled>
                            <input type="number" class="input-text w-1/3 bg-gray-200" :value="total" readonly>
                            <input type="hidden" name="total" id="hidden_total" :value="total">
                        </div>

                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">備考：</label>

                        <textarea name=" message" class="textarea"></textarea>
                    </div>

                    <div class="footer">
                        <div class="mb-2">請求元：</div>
                        <div class="mb-2">
                            〒：
                            <input
                                type="text"
                                name="postal"
                                id="postal"
                                style="width: 100px;"
                                class="border rounded px-1"
                                placeholder="123-4567"
                                inputmode="numeric"
                                autocomplete="postal-code">
                            <input type="text" name="address" id="address" class="input-text mt-1" placeholder="住所を入力してください">
                            <input type="text" name="name" id="name" class="input-text mt-1" placeholder="名前を入力してください">
                        </div>

                        <!-- TEL / FAX -->
                        <div class="mb-2 flex flex-col md:flex-row md:space-x-4">
                            <div class="md:w-1/2 mb-2 md:mb-0">
                                TEL：
                                <input
                                    type="tel"
                                    name="tel"
                                    id="tel"
                                    class="border rounded px-1 w-full"
                                    placeholder="090-1234-5678"
                                    inputmode="tel"
                                    autocomplete="tel">
                            </div>
                            <div class="md:w-1/2">
                                FAX：
                                <input
                                    type="tel"
                                    name="fax"
                                    id="fax"
                                    class="border rounded px-1 w-full"
                                    placeholder="03-1234-5678"
                                    inputmode="tel"
                                    autocomplete="tel">
                            </div>
                        </div>

                        <!-- E-Mail / URL -->
                        <div class="mb-2 flex flex-col md:flex-row md:space-x-4">
                            <div class="md:w-1/2 mb-2 md:mb-0">
                                E-Mail：
                                <input
                                    type="email"
                                    name="mail"
                                    id="mail"
                                    class="border rounded px-1 w-full"
                                    placeholder="example@example.com"
                                    autocomplete="email">
                            </div>
                            <div class="md:w-1/2">
                                URL：
                                <input
                                    type="text"
                                    name="url"
                                    id="url"
                                    class="border rounded px-1 w-full"
                                    placeholder="https://example.com"
                                    autocomplete="url">
                            </div>
                        </div>

                        <!-- 振込先口座 -->
                        <div class="mb-2 flex flex-col md:flex-row md:space-x-4">
                            <div class="md:w-1/2 mb-2 md:mb-0">
                                振込先
                                <input
                                    type="text"
                                    name="transfer_1"
                                    id="transfer_1"
                                    class="border rounded px-1 w-full"
                                    placeholder="○○銀行 ○○支店　普通　口座 1234567">
                                <input
                                    type="text"
                                    name="transfer_2"
                                    id="transfer_2"
                                    class="border rounded px-1 w-full"
                                    placeholder="○○銀行 ○○支店　普通　口座 1234567">
                                <input
                                    type="text"
                                    name="transfer_3"
                                    id="transfer_3"
                                    class="border rounded px-1 w-full"
                                    placeholder="○○銀行 ○○支店　普通　口座 1234567">
                            </div>

                        </div>

                        <div class="mb-4 mt-2">
                            <label>
                                <input type="checkbox" id="save_to_cookie" class="mr-1">
                                発信者情報を保存しておく
                            </label>
                        </div>
                    </div>

                    <div class="submit-btn">
                        <button type="submit" class="bg-blue-600 text-white rounded px-6 py-2 hover:bg-blue-700">
                            PDF作成
                        </button>
                    </div>
                </div>
        </form>
    </div>



    <script>
        const fields = ['postal', 'address', 'name', 'tel', 'fax', 'mail', 'url', 'transfer' + '_1', 'transfer' + '_2', 'transfer' + '_3'];
        fields.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.addEventListener('input', function() {
                    if (document.getElementById('save_to_cookie').checked) {
                        setCookie(field, this.value, 30); // 30日
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
                    setCookie(field, value, 30); // 30日
                });
                alert('発信者情報をクッキーに保存しました。');
            } else {
                fields.forEach(field => {
                    deleteCookie(field);
                });
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
                return parts[0] === name ? decodeURIComponent(parts[1]) : r
            }, '');
        }

        function deleteCookie(name) {
            setCookie(name, '', -1);
        }
    </script>


</x-app-layout>