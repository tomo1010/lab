<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('pdf.soldHorizental') }}">
                    売約済み（横書き）
                </a>
            </h2>
            <x-head-buttons />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="no-print w-full max-w-full md:max-w-4xl mx-auto p-6 bg-white rounded shadow space-y-8">
            <form method="POST" action="{{ route('pdf.generatePdf') }}" target="_blank" class="space-y-6">
                @csrf

                <input type="hidden" name="view" value="pdf.soldHorizentalPdf">

                <div>
                    <label for="customer_1" class="block text-sm font-medium text-gray-700">顧客名</label>
                    <input type="text" name="customer_1" id="customer_1"
                        class="mt-1 w-full border rounded px-1">
                </div>

                <div>
                    <label for="customer_2" class="block text-sm font-medium text-gray-700">顧客名</label>
                    <input type="text" name="customer_2" id="customer_2"
                        class="mt-1 w-full border rounded px-1">
                </div>

                <div class="mt-[30px] text-center">
                    <button type="submit" class="bg-blue-600 text-white rounded px-6 py-2 hover:bg-blue-700">
                        PDF作成
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>