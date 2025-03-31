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

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            vertical-align: top;
            padding: 5px;
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
    </style>

    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('lavels.createPdf') }}">
            @csrf

            <div class="fax-container bg-white shadow-md rounded-md">
                <div class="title">FAX 送付状</div>

                <table class="info-table">
                    <tr>
                        <td style="width: 60%;">
                            <input type="text" name="to" class="input-text" placeholder="宛先を入力してください"> 御中
                        </td>
                        <td style="width: 40%;">
                            <div class="mb-2">
                                送信日：
                                <input type="text" name="date_year" style="width:40px;" class="border rounded px-1"> 年
                                <input type="text" name="date_month" style="width:30px;" class="border rounded px-1"> 月
                                <input type="text" name="date_day" style="width:30px;" class="border rounded px-1"> 日
                            </div>
                            <div>
                                送信枚数：
                                <input type="text" name="page_count" style="width:40px;" class="border rounded px-1"> 枚（当紙含む）
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="mb-4">
                    件名：
                    <input type="text" name="subject" class="input-text" placeholder="件名を入力してください">
                </div>

                <div class="mb-4">
                    <label>ご挨拶文（任意）：</label>
                    <textarea name="message" class="textarea">日頃よりお世話になっております。</textarea>
                </div>

                <div class="footer">
                    <div class="mb-2">発信者情報：</div>
                    <div class="mb-2">
                        〒<input type="text" name="postal" style="width: 80px;" class="border rounded px-1">
                        <input type="text" name="address" class="input-text mt-1" placeholder="住所を入力してください">
                    </div>
                    <div>
                        TEL：<input type="text" name="tel" style="width:120px;" class="border rounded px-1">
                        ／FAX：<input type="text" name="fax" style="width:120px;" class="border rounded px-1">
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
</x-app-layout>