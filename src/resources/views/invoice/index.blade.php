<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">請求書印刷</h2>
    </x-slot>

    @if (session('success'))
    <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="max-w-4xl mx-auto mt-6">

        {{-- PDF作成フォーム --}}
        <form method="POST" :action="action" x-data="{ action: '{{ route('pdf.generatePdf') }}' }" id="pdf-form">

            @csrf
            <input type="hidden" name="view" value="invoice.createPdf">

            <div class="bg-white p-8 border border-gray-300 rounded-md shadow-md text-sm">
                <div class="text-center text-2xl font-bold border-y border-black py-3 mb-6">請求書</div>

                <div class="text-right text-xs text-gray-600 mb-2">
                    発行日：
                    <input type="date" name="date" class="border rounded px-2 py-1 text-xs" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="text-right text-xs text-gray-600 mb-4">
                    明細枚数（本紙含む）：
                    <select name="page_count" class="border rounded px-2 py-1 text-xs">
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ $i === 1 ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block mb-1">請求先宛名：</label>
                    <div class="flex gap-2">
                        <input type="text" name="customer_name" class="w-full border rounded px-2 py-1">
                        <select name="to_suffix" class="border rounded px-2 py-1 text-sm">
                            <option value="様">様</option>
                            <option value="御中">御中</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-1">請求先住所：</label>
                    <input type="text" name="customer_address" class="w-full border rounded px-2 py-1" placeholder="〒を全角入力→変換">
                </div>

                {{-- 請求内容と合計 --}}
                @php
                $defaultItems = old('items') ?? array_fill(0, 5, ['name' => '', 'price' => 0]);
                @endphp

                <div class="mb-6" x-data="invoiceForm()" x-init="init()">
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

                <script>
                    function invoiceForm() {
                        return {
                            items: @json($defaultItems),
                            total: 0,
                            init() {
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
                </script>

                <div class="mb-6">
                    <label class="block mb-1">備考：</label>
                    <textarea name="message" class="w-full h-24 border rounded px-2 py-1 text-sm"></textarea>
                </div>




                {{-- 発行者情報フォーム --}}
                @include('components.company-info')


                {{-- ボタン群 --}}
                <div class="flex justify-center gap-4 mt-6">
                    {{-- PDFボタン --}}
                    <button
                        type="submit"
                        @click="action = '{{ route('pdf.generatePdf') }}'"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        PDF作成
                    </button>

                    @auth
                    {{-- 保存ボタン（ログインユーザーのみ） --}}
                    <button
                        type="submit"
                        @click="action = '{{ route('invoice.store') }}'"
                        class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        保存
                    </button>
                    @endauth
                </div>
            </div>
        </form>

        {{-- 保存済み一覧 --}}
        @auth
        @php
        $limit = auth()->user()->limit();
        $count = auth()->user()->invoices()->count();
        $isOverLimit = $count >= $limit;
        @endphp
        <x-save-list :items="$invoices" itemName="invoice" :is-over-limit="$isOverLimit" routePrefix="invoice" />
        @endauth
    </div>


</x-app-layout>