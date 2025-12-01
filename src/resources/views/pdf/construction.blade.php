<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('pdf.construction') }}">
                    ボディコーティング施工証明書印刷
                </a>
            </h2>
            <x-head-buttons />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="no-print w-full max-w-full md:max-w-4xl mx-auto p-6 bg-white rounded shadow space-y-8">
            <form method="POST" action="{{ route('pdf.generatePdf') }}" target="_blank" class="space-y-6" id="construction-form">
                @csrf
                <input type="hidden" name="view" value="pdf.constructionPdf">

                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700">顧客名</label>
                    <input type="text" name="customer_name" id="customer_name"
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

                {{-- 発行者情報 --}}
                @include('components.company-info')


                {{-- 制限ポップアップ --}}
                <x-pdf-limit-popup />

                <div class="mt-[30px] text-center">
                    <button type="submit" class="bg-blue-600 text-white rounded px-6 py-2 hover:bg-blue-700">
                        PDF作成
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>