<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            施工証明書印刷
        </h2>
    </x-slot>

    <div class="no-print p-6 max-w-xl mx-auto">
        <form method="POST" action="{{ route('pdf.generatePdf') }}" target="_blank" class="space-y-6">
            @csrf
            <input type="hidden" name="view" value="pdf.constructionPdf">

            <div>
                <label for="customer" class="block text-sm font-medium text-gray-700">顧客名</label>
                <input type="text" name="customer" id="customer" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="note" class="block text-sm font-medium text-gray-700">備考</label>
                <input type="text" name="note" id="note"
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