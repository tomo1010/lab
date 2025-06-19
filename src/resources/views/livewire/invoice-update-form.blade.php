<div class="bg-white p-8 border border-gray-300 rounded-md shadow-md text-sm">
    <div class="text-center text-2xl font-bold border-y border-black py-3 mb-6">請求書　編集ページ</div>




    <!-- 発行日 -->
    <div class="text-right text-xs text-gray-600 mb-2">
        発行日：
        <input type="date" wire:model="date" class="border rounded px-2 py-1 text-xs" required>
    </div>

    <!-- 明細枚数 -->
    <div class="text-right text-xs text-gray-600 mb-4">
        明細枚数（本紙含む）：
        <select wire:model="page_count" class="border rounded px-2 py-1 text-xs">
            @for ($i = 1; $i <= 10; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
                @endfor
        </select>
    </div>

    <!-- 宛名 -->
    <div class="mb-6">
        <label class="block mb-1">請求先宛名：</label>
        <div class="flex gap-2">
            <input type="text" wire:model="client" class="w-full border rounded px-2 py-1">
            <select wire:model="to_suffix" class="border rounded px-2 py-1 text-sm">
                <option value="様">様</option>
                <option value="御中">御中</option>
            </select>
        </div>
    </div>

    <!-- 請求先住所 -->
    <div class="mb-6">
        <label class="block mb-1">請求先住所：</label>
        <input type="text" wire:model="client_address" class="w-full border rounded px-2 py-1" placeholder="〒を全角入力→変換">
    </div>

    <!-- 請求内容 -->
    <div class="mb-6">
        <label class="block mb-1">請求内容：</label>
        @for ($i = 0; $i < 5; $i++)
            <div class="flex gap-4 mb-3">
            <input type="text" wire:model="items.{{ $i }}" class="w-2/3 border rounded px-2 py-1" placeholder="項目">
            <input type="number" wire:model="prices.{{ $i }}" class="w-1/3 border rounded px-2 py-1" placeholder="金額" min="0">
    </div>
    @endfor

    <!-- 合計 -->
    <div class="flex gap-4 items-center mb-3">
        <input type="text" class="w-2/3 bg-gray-200 border rounded px-2 py-1" placeholder="合計" disabled>
        <input type="number" class="w-1/3 bg-gray-200 border rounded px-2 py-1" value="{{ $this->computedTotal }}" readonly>
    </div>
</div>

<!-- 備考 -->
<div class="mb-6">
    <label class="block mb-1">備考：</label>
    <textarea wire:model="message" class="w-full h-24 border rounded px-2 py-1 text-sm"></textarea>
</div>


<!-- 会社名 -->
<div class="mt-6 border-t pt-4">
    <div class="mb-2">発行者：</div>
    <div class="mb-2">
        〒：
        <input type="text" name="postal" id="postal" class="w-24 border rounded px-2 py-1" placeholder="123-4567" inputmode="numeric" autocomplete="postal-code">
        <input type="text" name="address" id="address" class="w-full border rounded px-2 py-1 mt-2" placeholder="住所を入力してください">
        <input type="text" name="name" id="name" class="w-full border rounded px-2 py-1 mt-2" placeholder="名前を入力してください">
    </div>

    <div class="mb-4 flex flex-col md:flex-row md:space-x-4">
        <div class="md:w-1/2">
            TEL：
            <input type="tel" name="tel" id="tel" class="w-full border rounded px-2 py-1" placeholder="090-1234-5678" inputmode="tel" autocomplete="tel">
        </div>
        <div class="md:w-1/2 mt-2 md:mt-0">
            FAX：
            <input type="tel" name="fax" id="fax" class="w-full border rounded px-2 py-1" placeholder="03-1234-5678" inputmode="tel" autocomplete="tel">
        </div>
    </div>

    <div class="mb-4 flex flex-col md:flex-row md:space-x-4">
        <div class="md:w-1/2">
            E-Mail：
            <input type="email" name="mail" id="mail" class="w-full border rounded px-2 py-1" placeholder="example@example.com" autocomplete="email">
        </div>
        <div class="md:w-1/2 mt-2 md:mt-0">
            URL：
            <input type="text" name="url" id="url" class="w-full border rounded px-2 py-1" placeholder="https://example.com" autocomplete="url">
        </div>
        <div class="md:w-1/2 mt-2 md:mt-0">
            インボイス番号：
            <input type="text" name="invoice" id="invoice" class="w-full border rounded px-2 py-1" placeholder="T+13桁">
        </div>
    </div>

    <div class="mb-4">
        <label class="block mb-1">振込先</label>
        <input type="text" name="transfer_1" id="transfer_1" class="w-full border rounded px-2 py-1 mb-2" placeholder="○○銀行 ○○支店　普通　口座 1234567">
        <input type="text" name="transfer_2" id="transfer_2" class="w-full border rounded px-2 py-1 mb-2" placeholder="○○銀行 ○○支店　普通　口座 1234567">
        <input type="text" name="transfer_3" id="transfer_3" class="w-full border rounded px-2 py-1" placeholder="○○銀行 ○○支店　普通　口座 1234567">
    </div>

    <div class="mt-4">
        <label class="inline-flex items-center">
            <input type="checkbox" id="save_to_cookie" class="mr-2">
            発信者情報を保存しておく
        </label>
    </div>
</div>






<!-- アクションボタン -->
<!-- 更新ボタン（Livewire） -->


<div class="flex justify-end gap-4">
    <!-- 更新ボタン（Livewire） -->
    <button
        wire:click="updateInvoice"
        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        更新する
    </button>

    <!-- PDFボタン（Alpine.js） -->
    <div x-data="pdfHandler()" x-init="init()" class="flex">
        <form id="pdfForm" method="POST" action="{{ route('pdf.generatePdf') }}" target="_blank" wire:ignore>
            @csrf
            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
            <input type="hidden" name="view" value="invoice.createPdf">
            <button type="button" @click="saveAndGeneratePdf"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                PDF作成
            </button>
        </form>
    </div>
</div>


<script>
    function pdfHandler() {
        return {
            async saveAndGeneratePdf() {
                try {
                    // ✅ find が undefined の場合は first() を fallback に
                    let comp = Livewire.find('invoice-update') || Livewire.first();
                    if (!comp) throw new Error('Livewire コンポーネントが見つかりません');
                    await comp.updateAndGeneratePdf();
                } catch (error) {
                    alert('保存またはPDF作成時にエラーが発生しました。');
                    console.error(error);
                }
            },
            init() {
                window.addEventListener('submit-pdf-form', () => {
                    document.getElementById('pdfForm').submit();
                });
            }
        }
    }
</script>




{{-- メッセージ表示部 --}}
<div
    x-data="{ show: false }"
    x-on:show-message.window="show = true; setTimeout(() => show = false, 2000)"
    x-show="show"
    x-transition
    class="mb-4 px-4 py-2 border-l-4 border-green-500 bg-green-100 text-green-700 rounded flex items-center gap-2">
    <i class="fas fa-check-circle"></i>
    <span>データを更新しました。</span>
</div>





</div>