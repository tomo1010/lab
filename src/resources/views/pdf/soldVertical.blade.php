
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            売約済み（縦書き）
        </h2>
    </x-slot>

    <div class="no-print p-6 max-w-xl mx-auto">
        <form method="POST" action="{{ route('pdf.generatePdf') }}" target="_blank" class="space-y-6">
            @csrf

            <input type="hidden" name="view" value="pdf.soldHorizentalPdf">

            <div>
                <label for="customer_1" class="block text-sm font-medium text-gray-700">顧客名</label>
                <input type="text" name="customer_1" id="customer_1" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="customer_2" class="block text-sm font-medium text-gray-700">顧客名</label>
                <input type="text" name="customer_2" id="customer_2" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    PDFを生成
                </button>
            </div>
        </form>
    </div>
</x-app-layout>