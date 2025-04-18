<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ラベル印刷
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/paper-css@0.4.1/paper.css">
    <style>
        @page {
            size: A4;
            margin: 0
        }

        body.A4 {
            margin: 0;
            font-family: sans-serif;
        }

        .sheet {
            width: 210mm;
            height: 297mm;
            padding: 21.5mm 0 0 19.3mm;
            display: grid;
            grid-template-columns: 83.8mm 3.8mm 83.8mm;
            grid-template-rows: repeat(6, 42.3mm);
            gap: 0;
        }

        .label {
            width: 83.8mm;
            height: 42.3mm;
            box-sizing: border-box;
            padding: 4mm;
            font-size: 12px;
            line-height: 1.4;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: 1px dashed #ccc;
        }

        .spacer {
            width: 3.8mm;
            height: 42.3mm;
        }

        .zipcode {
            font-size: 14px;
            font-weight: bold;
        }

        .name {
            margin-top: 4mm;
            font-size: 13px;
            font-weight: bold;
        }

        @media print {

            .no-print,
            header,
            nav,
            aside,
            .sidebar,
            .navbar,
            .footer,
            .hidden-on-print {
                display: none !important;
            }

            .print-only {
                display: block !important;
            }

            body {
                margin: 0 !important;
            }
        }

        .print-only {
            display: none;
        }


        .form-group {
            margin-bottom: 10px;
        }
    </style>
    </head>

    <body class="A4">

        <div class="no-print p-6 max-w-xl mx-auto">
            <form method="POST" action="{{ route('label.index') }}" class="space-y-4 bg-white p-6 shadow rounded">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">郵便番号：</label>
                    <input type="text" name="zipcode" value="{{ old('zipcode', '123-4567') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">住所：</label>
                    <input type="text" name="address" value="{{ old('address', '東京都新宿区西新宿2-8-1') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex gap-4">
                    <div class="w-2/3">
                        <label class="block text-sm font-medium text-gray-700">名前：</label>
                        <input type="text" name="name" value="{{ old('name', '山田 太郎') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="w-1/3">
                        <label class="block text-sm font-medium text-gray-700">敬称：</label>
                        <select name="title"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="様" {{ old('title', '様') == '様' ? 'selected' : '' }}>様</option>
                            <option value="御中" {{ old('title') == '御中' ? 'selected' : '' }}>御中</option>
                        </select>
                    </div>

                </div>

                <div class="flex justify-between mt-4">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        ラベルを表示
                    </button>
                    <button type="button" onclick="window.print()"
                        class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                        印刷
                    </button>
                </div>
            </form>
        </div>


        @if(request()->isMethod('post'))
        <section class="sheet">
            @for ($i = 0; $i < 6; $i++)
                <div class="label">
                <div class="zipcode">〒{{ request('zipcode') }}</div>
                <div>{{ request('address') }}</div>
                <div class="name">{{ request('name') }} {{ request('title') }}</div>
                </div>
                <div class="spacer"></div>
                <div class="label">
                    <div class="zipcode">〒{{ request('zipcode') }}</div>
                    <div>{{ request('address') }}</div>
                    <div class="name">{{ request('name') }} {{ request('title') }}</div>
                </div>
                @endfor
        </section>
        @endif

</x-app-layout>