<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            売約済み（横書き）
        </h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('pdf.generatePdf') }}" target="_blank">
            @csrf

            <input type="hidden" name="view" value="pdf.soldHorizentalPdf">

            <div>
                <label>顧客名：</label>
                <input type="text" name="customer" required>
            </div>
            <button type="submit">PDFを生成</button>
        </form>
    </div>
</x-app-layout>