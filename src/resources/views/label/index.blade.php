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

    <body class="A4">
        <div class="no-print p-6 max-w-xl mx-auto">
            <form method="POST" action="{{ route('label.preview') }}" class="space-y-4 bg-white p-6 shadow rounded">
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

                    @auth
                    <button type="button"
                        onclick="saveOnly()"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        保存
                    </button>
                    @endauth

                    <button type="button"
                        onclick="window.print()"
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

        @auth
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">保存されたデータ</h2>

                @if($labels && $labels->count())
                <ul class="mt-6 space-y-4">
                    @foreach ($labels as $label)
                    <li class="p-4 bg-gray-100 rounded-lg flex justify-between items-center">
                        <div>
                            <span class="text-lg font-semibold">
                                {{ $label->name }} {{ $label->title }}（{{ $label->zipcode }}）
                            </span>
                            <p class="text-sm text-gray-500">更新日時: {{ $label->updated_at->format('Y-m-d H:i') }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <form action="{{ route('label.destroy', $label->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 flex items-center space-x-2" title="削除" onclick="return confirm('本当に削除しますか？');">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                    @endforeach
                </ul>

                {{--<div class="mt-6">
                    {{ $labels->links() }}
            </div>--}}
            @else
            <p class="mt-6 text-gray-500">保存されたデータはありません。</p>
            @endif
        </div>
        </div>
        @endauth

        @guest
        <p class="text-center mt-4 text-gray-700">投稿を見るにはログインしてください。</p>
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                ログイン
            </a>
            <a href="{{ route('register') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                新規登録
            </a>
        </div>
        @endguest

        <script>
            function saveOnly() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('label.store') }}";

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                const inputs = ['zipcode', 'address', 'name', 'title'];
                inputs.forEach(name => {
                    const original = document.querySelector(`[name="${name}"]`);
                    if (original) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = name;
                        input.value = original.value;
                        form.appendChild(input);
                    }
                });

                document.body.appendChild(form);

                const iframe = document.createElement('iframe');
                iframe.name = 'hidden-frame';
                iframe.style.display = 'none';
                document.body.appendChild(iframe);
                form.target = 'hidden-frame';

                form.submit();

                setTimeout(() => location.reload(), 1000);
            }
        </script>
    </body>
</x-app-layout>