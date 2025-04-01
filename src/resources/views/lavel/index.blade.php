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
        <form method="POST" action="{{ route('lavels.createPdf') }}">
            @csrf

            <div class="fax-container bg-white shadow-md rounded-md">
                <div class="title">FAX 送付状</div>

                <div class="right-align-small">
                    送信日：
                    <input type="date" name="send_date" class="border rounded px-2 py-1 text-sm" value="{{ date('Y-m-d') }}" required>
                </div>


                <div class="right-align-small">
                    送信枚数：
                    <select name="page_count" class="border rounded px-2 py-1 text-sm">
                        <option value="1">1</option>
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
                    <label class="block mb-1">宛先：</label>
                    <div class="flex items-center gap-2">
                        <input type="text" name="to" class="input-text w-full" placeholder="宛名を入力してください">
                        <select name="to_suffix" class="border rounded px-2 py-1 text-sm">
                            <option value="様">様</option>
                            <option value="御中">御中</option>
                        </select>
                    </div>
                </div>


                <div class="mb-4">
                    件名：
                    <input type="text" name="subject" class="input-text" placeholder="件名を入力してください">
                </div>

                <div class="mb-4">
                    <label>ご挨拶文：</label>
                    <textarea name="message" class="textarea">日頃よりお世話になっております。</textarea>
                </div>

                <div class="footer">
                    <div class="mb-2">発信者情報：</div>
                    <div class="mb-2">
                        〒：
                        <input type="text" name="postal" id="postal" style="width: 100px;" class="border rounded px-1">
                        <input type="text" name="address" id="address" class="input-text mt-1" placeholder="住所を入力してください">
                        <input type="text" name="name" id="name" class="input-text mt-1" placeholder="名前を入力してください">
                    </div>
                    <div class="mb-2">
                        TEL：
                        <input type="text" name="tel" id="tel" style="width:160px;" class="border rounded px-1">
                        FAX：
                        <input type="text" name="fax" id="fax" style="width:160px;" class="border rounded px-1">
                    </div>
                    <div class="mb-2">
                        E-Mail：
                        <input type="text" name="mail" id="tel" style="width:160px;" class="border rounded px-1">
                        URL：
                        <input type="text" name="url" id="fax" style="width:160px;" class="border rounded px-1">
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