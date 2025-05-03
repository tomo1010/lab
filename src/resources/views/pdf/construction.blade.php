<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            施工証明書印刷
        </h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('pdf.constructionPdf') }}" target="_blank">
            @csrf
            <div>
                <label>顧客名：</label>
                <input type="text" name="customer" required>
            </div>
            <div>
                <label>備考：</label>
                <input type="text" name="note">
            </div>
            <button type="submit">PDFを生成</button>
        </form>
    </div>
</x-app-layout>