<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a
                href="{{ route('invoice.index') }}"
                class="text-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 visited:text-gray-800"
                aria-label="請求書一覧ページへ">
                請求書印刷
            </a>
        </h2>
    </x-slot>

    @if (session('success'))
    <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="max-w-4xl mx-auto mt-6">

        {{-- PDF作成フォーム --}}
        <form
            x-data="formHandler('{{ route('invoice.update', $invoice->id) }}')"
            :action="actionUrl"
            method="POST"
            x-ref="form">
            @csrf
            <!-- Laravel用の隠し _method フィールド -->
            <template x-if="method === 'PUT'">
                <input type="hidden" name="_method" value="PUT">
            </template>
            <input type="hidden" name="view" value="invoice.createPdf">


            <div class="bg-white p-8 border border-gray-300 rounded-md shadow-md text-sm">
                <div class="text-center text-2xl font-bold border-y border-black py-3 mb-6">請求書 編集</div>

                <div class="text-right text-xs text-gray-600 mb-2">
                    発行日：
                    <input type="date" name="date" class="border rounded px-2 py-1 text-xs" value="{{ $invoice->date }}" required>
                </div>

                <div class="text-right text-xs text-gray-600 mb-4">
                    明細枚数（本紙含む）：
                    <select name="page_count" class="border rounded px-2 py-1 text-xs">
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ $invoice->page_count == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block mb-1">請求先宛名：</label>
                    <div class="flex gap-2">
                        <input type="text" name="customer_name" class="w-full border rounded px-2 py-1" value="{{ $invoice->customer_name }}">
                        <select name="to_suffix" class="border rounded px-2 py-1 text-sm">
                            <option value="様" {{ $invoice->to_suffix === '様' ? 'selected' : '' }}>様</option>
                            <option value="御中" {{ $invoice->to_suffix === '御中' ? 'selected' : '' }}>御中</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-1">請求先住所：</label>
                    <input type="text" name="customer_address" class="w-full border rounded px-2 py-1" value="{{ $invoice->customer_address }}">
                </div>

                {{-- 請求内容 --}}
                <div class="mb-6" x-data="invoiceForm({{ json_encode($invoice->items) }}, {{ $invoice->total }})" x-init="init()">
                    <label class="block mb-1">請求内容：</label>

                    <template x-for="(item, i) in items" :key="i">
                        <div class="flex gap-4 mb-2">
                            <input :name="`items[${i}][name]`" x-model="item.name" class="w-2/3 border rounded px-2 py-1" placeholder="項目">
<input
  :name="`items[${i}][price]`"
  x-model="item.price"
  @input="recalculateTotal()"
  type="text"
  class="w-1/3 border rounded px-2 py-1"
  placeholder="金額"
  inputmode="text" />


                        </div>
                    </template>

<!-- ボタンはすでにOK（そのまま使えます） -->
<div class="mt-3 mb-6 space-x-2">
  <button type="button" @click="addItem()" class="text-blue-600 hover:underline underline-offset-2 hover:text-blue-700 text-sm">
    ＋ 行を追加
  </button>
  <button type="button" @click="removeItem()" :disabled="items.length <= 1"
    class="text-blue-600 hover:underline underline-offset-2 hover:text-blue-700 text-sm disabled:text-gray-400 disabled:cursor-not-allowed">
    − 行を削除
  </button>
</div>

                    <div class="flex gap-4 items-center">
                        <input type="text" class="w-2/3 bg-gray-200 border rounded px-2 py-1" placeholder="合計" disabled>
                        <input type="number" class="w-1/3 bg-gray-200 border rounded px-2 py-1" x-model="total" readonly>
                        <input type="hidden" name="total" :value="total">
                    </div>
                </div>


                <!-- ↓この <script> 内の invoiceForm を以下のように修正 -->
                <script>
                    function invoiceForm(initialItems = [], initialTotal = 0) {
                        return {
                            items: initialItems,
                            total: initialTotal,
                            init() {
                                this.recalculateTotal();
                            },
                            addItem() {
                                this.items.push({
                                    name: '',
                                    price: ''
                                });
                                this.recalculateTotal();
                            },
                            // 追加：末尾の行を1つ削除（最低1行は残す）
                            removeItem() {
                                if (this.items.length > 1) {
                                    this.items.pop();
                                    this.recalculateTotal();
                                }
                            },
                            recalculateTotal() {
                                this.total = this.items.reduce((sum, item) => {
                                    const v = parseFloat(String(item.price ?? '').replace(/,/g, ''));
                                    return sum + (Number.isFinite(v) ? v : 0);
                                }, 0);
                            },
                        }
                    }
                </script>



                <div class="mb-6">
                    <label class="block mb-1">備考：</label>
                    <textarea name="message" class="w-full h-24 border rounded px-2 py-1 text-sm">{{ $invoice->message }}</textarea>
                </div>

                {{-- 発行者情報 --}}
                @include('components.company-info')

                <div class="flex justify-center gap-4 mt-6">
                    <!-- ✅ PDF作成ボタン -->
                    <button type="submit"
                        @click.prevent="submitAsPdf"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        PDF作成
                    </button>

                    <!-- ✅ 保存（更新）ボタン -->
                    <button type="submit"
                        @click.prevent="submitAsUpdate"
                        class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        更新
                    </button>
                </div>
            </div>
        </form>



        <script>
            function formHandler(defaultAction) {
                return {
                    actionUrl: defaultAction, // 初期状態は「保存ルート」
                    method: 'PUT',

                    submitAsPdf() {
                        this.actionUrl = '{{ route('pdf.generatePdf') }}';
                        this.method = 'POST';
                        this.$nextTick(() => this.$refs.form.submit());
                    },

                    submitAsUpdate() {
                        this.actionUrl = '{{ route('invoice.update', $invoice->id) }}';
                        this.method = 'PUT';
                        this.$nextTick(() => this.$refs.form.submit());
                    }
                }
            }
        </script>



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