<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('fax.change') }}">
                    車両入替え送付状印刷
                </a>
            </h2>
            <x-head-buttons />
        </div>
    </x-slot>

    <style>
        .title {
            text-align: center;
            font-size: 20pt;
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 10px 0;
            margin-bottom: 20px;
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

    <div class="py-12">
        <div class="w-full max-w-full md:max-w-4xl mx-auto p-6 bg-white rounded shadow space-y-8">
            <form method="POST" action="{{ route('fax.changePdf') }}">
                @csrf

                <div>
                    <div class="title">車両入替え 送付状</div>

                    <div class="right-align-small">
                        送信日：
                        <input type="date" name="send_date" class="border rounded px-2 py-1 text-sm" value="{{ date('Y-m-d') }}" required>
                    </div>


                    <div class="right-align-small">
                        送信枚数：
                        <select name="page_count" class="border rounded px-2 py-1 text-sm">
                            <option value="1">1枚</option>
                            <option value="2" selected>2枚</option>
                            <option value="3">3枚</option>
                            <option value="4">4枚</option>
                            <option value="5">5枚</option>
                            <option value="6">6枚</option>
                            <option value="7">7枚</option>
                            <option value="8">8枚</option>
                            <option value="9">9枚</option>
                            <option value="10">10枚</option>
                        </select>
                    </div>

                    <div class="left-align">
                        <label class="block mb-1">宛先：</label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="to" class="w-full border rounded px-2 py-1" placeholder="宛名を入力してください">
                            <select name="to_suffix" class="border rounded px-2 py-1 text-sm">
                                <option value="様">様</option>
                                <option value="御中">御中</option>
                            </select>
                        </div>
                    </div>


                    <div class="left-align">
                        <label class="block mb-1">車両入替え予定日：</label>
                        <input type="date" name="change_date" class="w-full border rounded px-2 py-1" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="left-align">

                        <div class="flex items-center">
                            <input type="text" name="price" class="w-full border rounded px-2 py-1" placeholder="車両金額を入力してください">
                            <span class="ml-2 whitespace-nowrap">万円</span>
                        </div>
                    </div>

                    <div class="left-align">
                        <div class="flex items-center">
                            <input type="text" name="before" class="w-full border rounded px-2 py-1" placeholder="入替え前の車あれば入力">
                            <span class="ml-2 whitespace-nowrap">から新しい車へ入替え</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <textarea name=" message" class="w-full border rounded px-2 py-1">車両入替えの手続きをお願いします。</textarea>
                    </div>

                    {{-- 発行者情報 --}}
                    @include('components.company-info')

                    <div class="submit-btn">
                        <button type="submit" class="bg-blue-600 text-white rounded px-6 py-2 hover:bg-blue-700">
                            PDF作成
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <script>
        const fields = ['postal', 'address', 'name', 'tel', 'fax'];

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