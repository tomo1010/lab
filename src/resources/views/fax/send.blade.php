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
        <form method="POST" action="{{ route('fax.sendPdf') }}">
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


                {{-- 発行者情報 --}}
                @include('components.company-info')

                <div class="submit-btn">
                    <button type="submit" class="bg-blue-600 text-white rounded px-6 py-2 hover:bg-blue-700">
                        PDF作成
                    </button>
                </div>
        </form>
    </div>

</x-app-layout>