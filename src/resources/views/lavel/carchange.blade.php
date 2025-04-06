<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            FAX送付状印刷
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

        .fax-sender {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .fax-recipient {
            margin-top: 1rem;
            margin-bottom: 1rem;
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
    </style>

    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('lavels.carchangePdf') }}">
            @csrf

            <div class="fax-container bg-white shadow-md rounded-md">
                <div class="title">FAX 送付状<br>車両入替えのご依頼</div>

                <div class="right-align-small">
                    送信日：
                    <input type="date" name="send_date" class="border rounded px-2 py-1 text-sm" value="{{ date('Y-m-d') }}" required>
                </div>


                <div class="right-align-small">
                    送信枚数：
                    <select name="page_count" class="border rounded px-2 py-1 text-sm">
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>あｖ
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    <br>（本紙入れての枚数）
                </div>


                <!-- 送信先 + 発信者 情報を並べるラッパー -->
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- 送信先情報 -->
                    <div class="fax-recipient bg-gray-100 p-4 rounded-md md:w-1/2">
                        <label class="block mb-1">宛先：</label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="to" class="input-text w-full" placeholder="宛名を入力してください">
                            <select name="to_suffix" class="border rounded px-2 py-1 text-sm">
                                <option value="様">様</option>
                                <option value="御中">御中</option>
                            </select>
                        </div>
                    </div>

                    <!-- 発信者情報 -->
                    <div class="fax-sender bg-gray-100 p-4 rounded-md md:w-1/2">
                        <div class="mb-2">発信者情報：</div>
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
                                    type="url"
                                    name="url"
                                    id="url"
                                    class="border rounded px-1 w-full"
                                    placeholder="https://example.com"
                                    autocomplete="url">
                            </div>
                        </div>

                        <div class="mb-4 mt-2">
                            <label>
                                <input type="checkbox" id="save_to_cookie" class="mr-1">
                                発信者情報を保存しておく
                            </label>
                        </div>
                    </div>
                </div>



                <!-- 車両入替え情報 -->
                <div class="mb-4 bg-gray-100 p-4 rounded-md">
                    <div class="mb-4">
                        お客様名（契約者）：
                        <input type="text" name="subject" class="input-text" placeholder="お客様名を入力してください">
                    </div>

                    <div class="mb-4 flex flex-col md:flex-row md:space-x-4">
                        <div class="md:w-1/2">
                            納車予定日：
                            <input type="date" name="carchenge_date" class="border rounded px-2 py-1 text-sm w-full" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="md:w-1/2">
                            車両金額：
                            <input type="text" name="carchenge_price" class="border rounded px-2 py-1 text-sm w-full" placeholder="車両金額を入力">
                        </div>
                    </div>

                    <div class="mb-4 flex flex-col md:flex-row md:space-x-4">
                        <div class="md:w-1/2 flex items-center">
                            <input type="text" name="beforecar" class="input-text ml-2 w-full" placeholder="乗換え前の車両">
                            <span class="ml-2 whitespace-nowrap">から車両入替</span>
                        </div>
                    </div>

                </div>


                <!-- 備考欄 -->
                <div class="mb-4">
                    <label>備考：</label>
                    <textarea name="message" class="textarea">車両入れ替えの手続きお願いします。</textarea>
                </div>


                <!-- PDFボタン -->
                <div class="submit-btn">
                    <button type="submit" class="bg-blue-600 text-white rounded px-6 py-2 hover:bg-blue-700">
                        PDF作成
                    </button>
                </div>
            </div>
        </form>
    </div>



    <script>
        const fields = ['postal', 'address', 'name', 'tel', 'fax'];

        window.addEventListener('DOMContentLoaded', () => {
            let loaded = false;

            fields.forEach(field => {
                const value = getCookie(field);
                if (value) {
                    document.getElementById(field).value = value;
                    loaded = true;
                }
            });

            if (loaded) {
                document.getElementById('save_to_cookie').checked = true;
                alert('クッキーから発信者情報を読み込みました。');
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