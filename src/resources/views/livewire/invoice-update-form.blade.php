<div> {{-- Livewire コンポーネントのルート要素 --}}

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
        <div class="mb-6" x-data="invoiceForm()" x-init="initEdit({{ Js::from($items ?? []) }})">
            <label class="block mb-1">請求内容：</label>

            <template x-for="(item, i) in items" :key="i">
                <div class="flex gap-4 mb-2">
                    <input :name="`items[${i}][name]`" x-model="item.name" class="w-2/3 border rounded px-2 py-1" placeholder="項目">
                    <input :name="`items[${i}][price]`" x-model.number="item.price" @input="recalculateTotal()" type="number" class="w-1/3 border rounded px-2 py-1" placeholder="金額" min="0">
                </div>
            </template>

            <button type="button" @click="addItem()" class="text-blue-600 text-sm mb-3">＋ 行を追加</button>

            <div class="flex gap-4 items-center">
                <input type="text" class="w-2/3 bg-gray-200 border rounded px-2 py-1" placeholder="合計" disabled>
                <input type="number" class="w-1/3 bg-gray-200 border rounded px-2 py-1" x-model="total" readonly>
                <input type="hidden" name="total" :value="total">
            </div>
        </div>

        <!-- 備考 -->
        <div class="mb-6">
            <label class="block mb-1">備考：</label>
            <textarea wire:model="message" class="w-full h-24 border rounded px-2 py-1 text-sm"></textarea>
        </div>

        <!-- 発行者情報フォーム -->
        @include('components.company-info')
    </div>

    <!-- アクションボタン -->
    <div class="flex justify-center gap-4 mt-6">
        <!-- PDFボタン（Alpine.js） -->
        <div x-data="pdfHandler()" x-init="init()" class="flex">
            <form id="pdfForm" method="POST" action="{{ route('pdf.generatePdf') }}" target="_blank" wire:ignore>
                @csrf
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                <input type="hidden" name="view" value="invoice.createPdf">
                <button type="button" @click="saveAndGeneratePdf"
                    class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    PDF作成
                </button>
            </form>
        </div>

        <!-- 更新ボタン（Livewire） -->
        <button
            wire:click="updateInvoice"
            class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
            更新
        </button>
    </div>

    <!-- メッセージ表示 -->
    <div
        x-data="{ show: false }"
        x-on:show-message.window="show = true; setTimeout(() => show = false, 2000)"
        x-show="show"
        x-transition
        class="mb-4 px-4 py-2 border-l-4 border-green-500 bg-green-100 text-green-700 rounded flex items-center gap-2">
        <i class="fas fa-check-circle"></i>
        <span>データを更新しました。</span>
    </div>

    <!-- Alpine.js スクリプト -->
    <script>
        function invoiceForm() {
            return {
                items: [],
                total: 0,

                init() {},

                initEdit(initialItems = []) {
                    this.items = initialItems.map(item => ({
                        name: item.name ?? '',
                        price: Number(item.price ?? 0)
                    }));
                    this.recalculateTotal();
                },

                addItem() {
                    this.items.push({
                        name: '',
                        price: 0
                    });
                    this.recalculateTotal();
                },

                recalculateTotal() {
                    this.total = this.items.reduce((sum, item) => sum + Number(item.price || 0), 0);
                }
            }
        }

        function pdfHandler() {
            return {
                async saveAndGeneratePdf() {
                    try {
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

</div> {{-- ✅ ルートを1つのdivに統一 --}}