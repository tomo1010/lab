<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            タイヤ計算機
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!--<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
<h1 class="text-2xl font-bold text-center text-gray-800 mb-5">タイヤ代の計算機・見積りサイト</h1>-->


                <form action="{{ route('tirecalc.createPdf') }}" method="POST">
                    @csrf

                    <!-- $comment を送信するための隠しフィールド -->
                    <input type="hidden" name="comment" value="{{ $comment }}">

                    <!-- 隠しフィールド（送信用） -->
                    <input type="hidden" name="productData[1][profitTotal]" id="hiddenProfitTotal1">
                    <input type="hidden" name="productData[1][wagesTotal]" id="hiddenWagesTotal1">
                    <input type="hidden" name="productData[1][taxExcludedTotal]" id="hiddenTotal1">
                    <input type="hidden" name="productData[1][taxIncludedTotal]" id="hiddenTotalWithTax1">
                    <input type="hidden" name="productData[2][profitTotal]" id="hiddenProfitTotal2">
                    <input type="hidden" name="productData[2][wagesTotal]" id="hiddenWagesTotal2">
                    <input type="hidden" name="productData[2][taxExcludedTotal]" id="hiddenTotal2">
                    <input type="hidden" name="productData[2][taxIncludedTotal]" id="hiddenTotalWithTax2">
                    <input type="hidden" name="productData[3][profitTotal]" id="hiddenProfitTotal3">
                    <input type="hidden" name="productData[3][wagesTotal]" id="hiddenWagesTotal3">
                    <input type="hidden" name="productData[3][taxExcludedTotal]" id="hiddenTotal3">
                    <input type="hidden" name="productData[3][taxIncludedTotal]" id="hiddenTotalWithTax3">
                    <!-- 消費税 -->
                    <input type="hidden" name="productData[1][tax]" id="hiddenTax1">
                    <input type="hidden" name="productData[2][tax]" id="hiddenTax2">
                    <input type="hidden" name="productData[3][tax]" id="hiddenTax3">


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50 p-5 rounded-lg shadow-md">
                        <h2 class="text-xl font-bold text-gray-800 border-b pb-2 mb-0 md:col-span-3">①原価設定</h2>

                        <div x-data="taxCalculator()" class="max-w-2xl p-6 bg-white rounded shadow space-y-8">

                            <!-- 共通設定：税区分 -->
                            <div>
                                <h2 class="text-xl font-bold mb-2">税区分の選択</h2>
                                <label class="inline-flex items-center mr-4">
                                    <input type="radio" x-model="taxMode" value="including" class="mr-1">
                                    税込み
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" x-model="taxMode" value="excluding" class="mr-1">
                                    税抜き
                                </label>
                            </div>




                            <!-- 商品 1 -->
                            <div class="p-4 border rounded space-y-4">
                                <!-- 商品 1 -->
                                <div class="p-4 border rounded space-y-4">
                                    <h3 class="text-lg font-semibold">商品 1</h3>

                                    <!-- 単価 -->
                                    <div>
                                        <label class="block mb-1 font-bold">単価</label>
                                        <input type="number" x-model.number="item1.cost" min="0" class="w-full border rounded px-2 py-1">
                                    </div>

                                    <!-- 数量 -->
                                    <div>
                                        <label class="block mb-1 font-bold">数量</label>
                                        <select x-model.number="item1.quantity" class="w-full border rounded px-2 py-1">
                                            <option value="1">1個</option>
                                            <option value="2">2個</option>
                                            <option value="3">3個</option>
                                            <option value="4">4個</option>
                                        </select>
                                    </div>

                                    <!-- 表示単価 -->
                                    <div>
                                        <p>表示単価：<span x-text="displayUnitPrice(item1).toLocaleString()"></span> 円</p>
                                    </div>

                                    <!-- 工賃小計 -->
                                    <div>
                                        <p>工賃小計：<span x-text="laborSubtotal.toLocaleString()"></span> 円</p>
                                    </div>

                                    <!-- 合計 -->
                                    <div>
                                        <p class="font-bold text-lg">合計：<span x-text="totalWithLabor(item1).toLocaleString()"></span> 円</p>
                                    </div>
                                </div>


                                <!-- 商品 2 -->
                                <div class="p-4 border rounded space-y-4">
                                    <h3 class="text-lg font-semibold">商品 2</h3>

                                    <div>
                                        <label class="block mb-1 font-bold">単価</label>
                                        <input type="number" x-model.number="item2.cost" min="0" class="w-full border rounded px-2 py-1">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-bold">数量</label>
                                        <select x-model.number="item2.quantity" class="w-full border rounded px-2 py-1">
                                            <option value="1">1個</option>
                                            <option value="2">2個</option>
                                            <option value="3">3個</option>
                                            <option value="4">4個</option>
                                        </select>
                                    </div>

                                    <!-- 表示単価 -->
                                    <div>
                                        <p>表示単価：<span x-text="displayUnitPrice(item2).toLocaleString()"></span> 円</p>
                                    </div>

                                    <!-- 工賃小計 -->
                                    <div>
                                        <p>工賃小計：<span x-text="laborSubtotal.toLocaleString()"></span> 円</p>
                                    </div>

                                    <!-- 合計 -->
                                    <div>
                                        <p class="font-bold text-lg">合計：<span x-text="totalWithLabor(item1).toLocaleString()"></span> 円</p>
                                    </div>
                                </div>


                                <!-- 商品 3 -->
                                <div class="p-4 border rounded space-y-4">
                                    <h3 class="text-lg font-semibold">商品 3</h3>

                                    <!-- 単価 -->
                                    <div>
                                        <label class="block mb-1 font-bold">単価</label>
                                        <input type="number" x-model.number="item3.cost" min="0" class="w-full border rounded px-2 py-1">
                                    </div>

                                    <!-- 数量 -->
                                    <div>
                                        <label class="block mb-1 font-bold">数量</label>
                                        <select x-model.number="item3.quantity" class="w-full border rounded px-2 py-1">
                                            <option value="1">1個</option>
                                            <option value="2">2個</option>
                                            <option value="3">3個</option>
                                            <option value="4">4個</option>
                                        </select>
                                    </div>

                                    <!-- 表示単価 -->
                                    <div>
                                        <p>表示単価：<span x-text="displayUnitPrice(item3).toLocaleString()"></span> 円</p>
                                    </div>

                                    <!-- 工賃小計 -->
                                    <div>
                                        <p>工賃小計：<span x-text="laborSubtotal.toLocaleString()"></span> 円</p>
                                    </div>

                                    <!-- 合計 -->
                                    <div>
                                        <p class="font-bold text-lg">合計：<span x-text="totalWithLabor(item3).toLocaleString()"></span> 円</p>
                                    </div>
                                </div>




                                <!-- 共通設定：粗利 -->
                                <div class="p-4 border rounded space-y-4">
                                    <div>
                                        <label class="block font-bold mb-1">粗利A（加算）</label>
                                        <select x-model="grossA" class="w-full border rounded px-2 py-1">
                                            <option :value="null">選択してください</option>
                                            <template x-for="amount in [5000, 10000, 15000, 20000]" :key="amount">
                                                <option :value="amount" x-text="`${amount.toLocaleString()} 円`"></option>
                                            </template>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block font-bold mb-1">粗利B（掛け算）</label>
                                        <!-- 粗利B（掛け算） -->
                                        <select x-model="grossB" class="w-full border rounded px-2 py-1">
                                            <option :value="null">選択してください</option>
                                            <template x-for="rate in [1.1, 1.2, 1.3, 1.4, 1.5]" :key="rate">
                                                <option :value="rate" x-text="rate.toFixed(1)"></option>
                                            </template>
                                        </select>
                                    </div>
                                </div>



                                <!-- ✅ 工賃設定フォーム -->
                                <div class="space-y-2 border p-4 rounded">
                                    <h3 class="text-lg font-bold mb-2">工賃設定</h3>

                                    <!-- 税込み/税抜きトグル -->
                                    <div>
                                        <label class="inline-flex items-center mr-4">
                                            <input type="radio" x-model="laborTaxMode" value="including" class="mr-1">
                                            税込み
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" x-model="laborTaxMode" value="excluding" class="mr-1">
                                            税抜き
                                        </label>
                                    </div>

                                    <!-- 明細行 -->
                                    <template x-for="(row, index) in laborItems" :key="index">
                                        <div class="grid grid-cols-3 gap-2 mb-2">
                                            <input type="text" x-model="row.name" class="border rounded px-2 py-1" placeholder="項目名">
                                            <input type="number" x-model.number="row.price" min="0" class="border rounded px-2 py-1" placeholder="金額">
                                            <select x-model.number="row.quantity" class="border rounded px-2 py-1">
                                                <option value="1">1個</option>
                                                <option value="2">2個</option>
                                                <option value="3">3個</option>
                                                <option value="4">4個</option>
                                                <option value="5">5個</option>
                                                <option value="6">6個</option>
                                                <option value="7">7個</option>
                                                <option value="8">8個</option>
                                                <option value="9">9個</option>
                                                <option value="10">10個</option>
                                                <option value="11">11個</option>
                                                <option value="12">12個</option>
                                                <option value="13">13個</option>
                                                <option value="14">14個</option>
                                                <option value="15">15個</option>
                                                <option value="16">16個</option>
                                                <option value="17">17個</option>
                                                <option value="18">18個</option>
                                                <option value="19">19個</option>
                                                <option value="20">20個</option>

                                            </select>
                                        </div>
                                    </template>

                                    <!-- 明細追加ボタン -->
                                    <button type="button" @click="addLaborItem()" class="text-blue-600 text-sm">＋ 明細を追加</button>

                                    <!-- 工賃小計 -->
                                    <div class="mt-4 font-bold">
                                        工賃小計：<span x-text="laborSubtotal.toLocaleString()"></span> 円
                                    </div>
                                </div>
                            </div>






                        </div>


                        <!-- Alpine.js ロジック -->
                        <script>
                            function taxCalculator() {
                                return {
                                    taxMode: 'including',
                                    grossA: null,
                                    grossB: null,

                                    item1: {
                                        cost: null,
                                        quantity: 1
                                    },
                                    item2: {
                                        cost: null,
                                        quantity: 1
                                    },
                                    item3: {
                                        cost: null,
                                        quantity: 1
                                    },

                                    laborTaxMode: 'including',

                                    // ✅ 工賃明細：名前入りで初期化
                                    laborItems: [{
                                            name: '組替えバランス',
                                            price: null,
                                            quantity: 4
                                        },
                                        {
                                            name: '脱着',
                                            price: null,
                                            quantity: 4
                                        },
                                        {
                                            name: '廃棄タイヤ',
                                            price: null,
                                            quantity: 4
                                        },
                                        {
                                            name: 'バルブ',
                                            price: null,
                                            quantity: 4
                                        },
                                        {
                                            name: 'ナット',
                                            price: null,
                                            quantity: 16
                                        },
                                    ],

                                    addLaborItem() {
                                        this.laborItems.push({
                                            name: '',
                                            price: 0,
                                            quantity: 1,
                                        });
                                    },

                                    get laborSubtotal() {
                                        const subtotal = this.laborItems.reduce((sum, item) => {
                                            const price = Number(item.price) || 0;
                                            const quantity = Number(item.quantity) || 0;
                                            return sum + (price * quantity);
                                        }, 0);

                                        return this.laborTaxMode === 'including' ?
                                            subtotal :
                                            Math.round(subtotal * 1.1);
                                    },

                                    applyGrossMargin(cost) {
                                        const add = parseFloat(this.grossA);
                                        const mul = parseFloat(this.grossB);
                                        const safeAdd = isNaN(add) ? 0 : add;
                                        const safeMul = isNaN(mul) ? 1 : mul;
                                        return Math.round((cost + safeAdd) * safeMul);
                                    },

                                    displayUnitPrice(item) {
                                        const base = item.cost * item.quantity;

                                        // 粗利計算
                                        let unitPrice = base;
                                        const add = parseFloat(this.grossA);
                                        const mul = parseFloat(this.grossB);

                                        if (!isNaN(add)) {
                                            unitPrice = base + add;
                                        } else if (!isNaN(mul)) {
                                            unitPrice = Math.round(base * mul);
                                        }

                                        // 税処理
                                        return this.taxMode === 'including' ?
                                            unitPrice :
                                            Math.round(unitPrice * 1.1);
                                    },


                                    totalPrice(item) {
                                        return this.displayUnitPrice(item) * item.quantity;
                                    },

                                    totalWithLabor(item) {
                                        return this.displayUnitPrice(item) + this.laborSubtotal;
                                    }

                                }
                            }
                        </script>












                        <!-- 商品 2 -->
                        <div class="bg-blue-50 p-5 rounded-lg">
                            <h2 class="text-lg font-semibold text-center mb-3">商品 2</h2>

                            <div class="flex gap-2 mb-2">
                                <input type="number" name="cost2" id="cost2"
                                    class="border px-4 py-2 rounded-lg w-3/4" placeholder="原価入力"
                                    inputmode="numeric" pattern="[0-9]*" onchange="updateCalculation()">

                                <select name="cost2Multiplier" id="cost2Multiplier"
                                    class="border px-4 py-2 rounded-lg w-1/4" onchange="updateCalculation()">
                                    <option value="1">×1</option>
                                    <option value="2">×2</option>
                                    <option value="3">×3</option>
                                    <option value="4">×4</option>
                                </select>
                            </div>

                            <div class="mt-3">
                                <p>商品代金: <span id="profitTotal2">0</span> 円
                                    <span class="text-sm text-gray-600 sm:block">（粗利: <span id="grossProfit2">0</span> 円）</span>
                                </p>
                                <p>工賃合計: <span id="wagesTotal2">0</span> 円</p>
                                <p>税抜合計: <span id="Total2">0</span> 円</p>

                                <p class="font-bold">税込合計: <span id="TotalWithTax2">0</span> 円
                                    <span class="text-sm text-gray-600 font-normal sm:block">（内消費税: <span id="tax2">0</span> 円）</span>
                                </p>
                            </div>
                        </div>

                        <!-- 商品 3 -->
                        <div class="bg-yellow-50 p-5 rounded-lg">
                            <h2 class="text-lg font-semibold text-center mb-3">商品 3</h2>

                            <div class="flex gap-2 mb-2">
                                <input type="number" name="cost3" id="cost3"
                                    class="border px-4 py-2 rounded-lg w-3/4" placeholder="原価入力"
                                    inputmode="numeric" pattern="[0-9]*" onchange="updateCalculation()">

                                <select name="cost3Multiplier" id="cost3Multiplier"
                                    class="border px-4 py-2 rounded-lg w-1/4" onchange="updateCalculation()">
                                    <option value="1">×1</option>
                                    <option value="2">×2</option>
                                    <option value="3">×3</option>
                                    <option value="4">×4</option>
                                </select>
                            </div>

                            <div class="mt-3">
                                <p>商品代金: <span id="profitTotal3">0</span> 円
                                    <span class="text-sm text-gray-600 sm:block">（粗利: <span id="grossProfit3">0</span> 円）</span>
                                </p>
                                <p>工賃合計: <span id="wagesTotal3">0</span> 円</p>
                                <p>税抜合計: <span id="Total3">0</span> 円</p>

                                <p class="font-bold">税込合計: <span id="TotalWithTax3">0</span> 円
                                    <span class="text-sm text-gray-600 font-normal sm:block">（内消費税: <span id="tax3">0</span> 円）</span>
                                </p>
                            </div>
                        </div>
                    </div>



                    <hr class="my-6">

                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <div class="bg-gray-50 p-5 rounded-lg shadow-md">
                            <h2 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">②粗利設定</h2>

                            <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                                <!-- 粗利A -->
                                <div>
                                    <label for="profitOptionA" class="block text-gray-700 font-semibold mb-1">粗利A</label>
                                    <select name="profitOptionA" id="profitOptionA" onchange="updateCalculation()" class="w-full px-4 py-2 border rounded-lg">
                                        <option value="0">選択してください</option>
                                        <option value="5000">5,000円</option>
                                        <option value="10000">10,000円</option>
                                        <option value="15000">15,000円</option>
                                        <option value="20000">20,000円</option>
                                    </select>
                                </div>

                                <!-- 粗利B -->
                                <div>
                                    <label for="profitOptionB" class="block text-gray-700 font-semibold mb-1">粗利B</label>
                                    <select name="profitOptionB" id="profitOptionB" onchange="updateCalculation()" class="w-full px-4 py-2 border rounded-lg">
                                        <option value="0">選択してください</option>
                                        <option value="1.1">×1.1</option>
                                        <option value="1.2">×1.2</option>
                                        <option value="1.3">×1.3</option>
                                        <option value="1.4">×1.4</option>
                                        <option value="1.5">×1.5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>

                            <hr class="my-6">

                            <div class="bg-gray-50 p-5 rounded-lg shadow-md">
                                <h2 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">③工賃その他設定</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div>
                                        <label for="set1" class="block text-gray-700 font-semibold mb-1">組替えバランス工賃</label>
                                        <div class="flex gap-2">
                                            <input type="number" name="set1" id="set1" class="w-full px-4 py-2 border rounded-lg" placeholder="0" inputmode="numeric" pattern="[0-9]*" onchange="updateCalculation()">
                                            <select name="set1Multiplier" id="set1Multiplier" class="px-4 py-2 border rounded-lg" onchange="updateCalculation()">
                                                <option value="1">×1</option>
                                                <option value="2">×2</option>
                                                <option value="3">×3</option>
                                                <option value="4">×4</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- 脱着工賃 -->
                                    <div>
                                        <label for="set2" class="block text-gray-700 font-semibold mb-1">脱着工賃</label>
                                        <div class="flex gap-2">
                                            <input type="number" name="set2" id="set2" class="w-full px-4 py-2 border rounded-lg" placeholder="0" inputmode="numeric" pattern="[0-9]*" onchange="updateCalculation()">
                                            <select name="set2Multiplier" id="set2Multiplier" class="px-4 py-2 border rounded-lg" onchange="updateCalculation()">
                                                <option value="1">×1</option>
                                                <option value="2">×2</option>
                                                <option value="3">×3</option>
                                                <option value="4">×4</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- 廃タイヤ費用 -->
                                    <div>
                                        <label for="set3" class="block text-gray-700 font-semibold mb-1">廃タイヤ費用</label>
                                        <div class="flex gap-2">
                                            <input type="number" name="set3" id="set3" class="w-full px-4 py-2 border rounded-lg" placeholder="0" inputmode="numeric" pattern="[0-9]*" onchange="updateCalculation()">
                                            <select name="set3Multiplier" id="set3Multiplier" class="px-4 py-2 border rounded-lg" onchange="updateCalculation()">
                                                <option value="1">×1</option>
                                                <option value="2">×2</option>
                                                <option value="3">×3</option>
                                                <option value="4">×4</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- ナット代 -->
                                    <div>
                                        <label for="set4" class="block text-gray-700 font-semibold mb-1">ナット代</label>
                                        <div class="flex gap-2">
                                            <input type="number" name="set4" id="set4" class="w-full px-4 py-2 border rounded-lg" placeholder="0" inputmode="numeric" pattern="[0-9]*" onchange="updateCalculation()">
                                            <select name="set4Multiplier" id="set4Multiplier" class="px-4 py-2 border rounded-lg" onchange="updateCalculation()">
                                                <option value="1">×1</option>
                                                <option value="2">×2</option>
                                                <option value="3">×3</option>
                                                <option value="4">×4</option>
                                                <option value="5">×5</option>
                                                <option value="6">×6</option>
                                                <option value="7">×7</option>
                                                <option value="8">×8</option>
                                                <option value="9">×9</option>
                                                <option value="10">×10</option>
                                                <option value="11">×11</option>
                                                <option value="12">×12</option>
                                                <option value="13">×13</option>
                                                <option value="14">×14</option>
                                                <option value="15">×15</option>
                                                <option value="16">×16</option>
                                                <option value="17">×17</option>
                                                <option value="18">×18</option>
                                                <option value="19">×19</option>
                                                <option value="20">×20</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- バルブ代 -->
                                    <div>
                                        <label for="set5" class="block text-gray-700 font-semibold mb-1">バルブ代</label>
                                        <div class="flex gap-2">
                                            <input type="number" name="set5" id="set5" class="w-full px-4 py-2 border rounded-lg" placeholder="0" inputmode="numeric" pattern="[0-9]*" onchange="updateCalculation()">
                                            <select name="set5Multiplier" id="set5Multiplier" class="px-4 py-2 border rounded-lg" onchange="updateCalculation()">
                                                <option value="1">×1</option>
                                                <option value="2">×2</option>
                                                <option value="3">×3</option>
                                                <option value="4">×4</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- 袋代 -->
                                    <div>
                                        <label for="set6" class="block text-gray-700 font-semibold mb-1">袋代</label>
                                        <div class="flex gap-2">
                                            <input type="number" name="set6" id="set6" class="w-full px-4 py-2 border rounded-lg" placeholder="0" inputmode="numeric" pattern="[0-9]*" onchange="updateCalculation()">
                                            <select name="set6Multiplier" id="set6Multiplier" class="px-4 py-2 border rounded-lg" onchange="updateCalculation()">
                                                <option value="1">×1</option>
                                                <option value="2">×2</option>
                                                <option value="3">×3</option>
                                                <option value="4">×4</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- その他 -->
                                    <div>
                                        <label for="set7" class="block text-gray-700 font-semibold mb-1">その他</label>
                                        <div class="flex gap-2">
                                            <input type="number" name="set7" id="set7" class="w-full px-4 py-2 border rounded-lg" placeholder="0" inputmode="numeric" pattern="[0-9]*" onchange="updateCalculation()">
                                            <select name="set7Multiplier" id="set7Multiplier" class="px-4 py-2 border rounded-lg" onchange="updateCalculation()">
                                                <option value="1">×1</option>
                                                <option value="2">×2</option>
                                                <option value="3">×3</option>
                                                <option value="4">×4</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- 設定ボタン -->
                                <div class="mt-6 flex justify-between items-center">
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" id="saveToCookie" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" onchange="saveSettingsToCookie()">
                                        <span class="text-gray-700 font-semibold">設定を保存</span>
                                    </label>
                                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600" onclick="clearWagesSettings()">工賃設定をクリア</button>
                                </div>
                            </div>


                            <hr class="my-6">

                            <!-- アコーディオンメニュー -->
                            <div x-data="{ open: false }" class="max-w-4xl mx-auto bg-white rounded-lg p-6 my-6 ">

                                <!-- トグル見出し -->
                                <div class="flex items-center justify-between cursor-pointer mb-4" @click="open = !open">
                                    <h2 class="text-2xl font-bold text-gray-800">📄 PDF印刷・コピー設定</h2>
                                    <div class="text-xl">
                                        <span x-show="!open">＋</span>
                                        <span x-show="open">−</span>
                                    </div>
                                </div>

                                <!-- アコーディオン内容 -->
                                <div x-show="open" x-transition>

                                    <!-- タイトル選択 -->
                                    <div class="mb-6">
                                        <h3 class="text-lg font-semibold text-gray-700 mb-2">タイトル</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            <label class="flex items-center"><input type="radio" name="selectTire" value="夏タイヤ" class="mr-2"> 夏タイヤのみ</label>
                                            <label class="flex items-center"><input type="radio" name="selectTire" value="夏タイヤAWセット" class="mr-2"> 夏タイヤ AWセット</label>
                                            <label class="flex items-center"><input type="radio" name="selectTire" value="冬タイヤ" class="mr-2"> 冬タイヤのみ</label>
                                            <label class="flex items-center"><input type="radio" name="selectTire" value="冬タイヤAWセット" class="mr-2"> 冬タイヤ AWセット</label>
                                            <label class="flex items-center"><input type="radio" name="selectTire" value="オールシーズンタイヤ" class="mr-2"> オールシーズンタイヤのみ</label>
                                            <label class="flex items-center"><input type="radio" name="selectTire" value="オールシーズンタイヤAWセット" class="mr-2"> オールシーズンタイヤ AWセット</label>
                                            <label class="flex items-center"><input type="radio" name="selectTire" value="AWのみ" class="mr-2"> AWのみ</label>
                                        </div>
                                    </div>

                                    <!-- メーカー選択 -->
                                    <div class="mb-6">
                                        <h3 class="text-lg font-semibold text-gray-700 mb-2">メーカー</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <select name="maker1" id="maker1" class="w-full px-4 py-2 border rounded-lg bg-red-50">
                                                <option value="" {{ request('maker1') == '' ? 'selected' : '' }}>商品１</option>
                                                <optgroup label="分類">
                                                    <option value="国内メーカー" {{ request('maker1') == '国産メーカー' ? 'selected' : '' }}>国産メーカー</option>
                                                    <option value="海外メーカー" {{ request('maker1') == '輸入メーカー' ? 'selected' : '' }}>輸入メーカー</option>
                                                    <option value="アジアンタイヤ" {{ request('maker1') == 'アジアンタイヤ' ? 'selected' : '' }}>アジアンタイヤ</option>
                                                </optgroup>
                                                <optgroup label="国内メーカー">
                                                    <option value="ブリヂストン" {{ request('maker1') == 'ブリヂストン' ? 'selected' : '' }}>ブリヂストン</option>
                                                    <option value="ダンロップ" {{ request('maker1') == 'ダンロップ' ? 'selected' : '' }}>ダンロップ</option>
                                                    <option value="ヨコハマ" {{ request('maker1') == 'ヨコハマ' ? 'selected' : '' }}>ヨコハマ</option>
                                                    <option value="トーヨータイヤ" {{ request('maker1') == 'トーヨータイヤ' ? 'selected' : '' }}>トーヨータイヤ</option>
                                                    <option value="セーバリング" {{ request('maker1') == 'セーバリング' ? 'selected' : '' }}>セーバリング</option>
                                                    <option value="ファルケン" {{ request('maker1') == 'ファルケン' ? 'selected' : '' }}>ファルケン</option>
                                                    <option value="ニットー" {{ request('maker1') == 'ニットー' ? 'selected' : '' }}>ニットー</option>
                                                </optgroup>
                                                <optgroup label="海外メーカー">
                                                    <option value="グッドイヤー" {{ request('maker1') == 'グッドイヤー' ? 'selected' : '' }}>グッドイヤー</option>
                                                    <option value="ミシュラン" {{ request('maker1') == 'ミシュラン' ? 'selected' : '' }}>ミシュラン</option>
                                                    <option value="ピレリ" {{ request('maker1') == 'ピレリ' ? 'selected' : '' }}>ピレリ</option>
                                                    <option value="コンチネンタル" {{ request('maker1') == 'コンチネンタル' ? 'selected' : '' }}>コンチネンタル</option>
                                                </optgroup>
                                                <optgroup label="アジアンタイヤ">
                                                    <option value="ナンカン（台湾）" {{ request('maker1') == 'ナンカン（台湾）' ? 'selected' : '' }}>ナンカン（台湾）</option>
                                                    <option value="ハンコック（韓国）" {{ request('maker1') == 'ハンコック（韓国）' ? 'selected' : '' }}>ハンコック（韓国）</option>
                                                    <option value="クムホ（韓国）" {{ request('maker1') == 'クムホ（韓国）' ? 'selected' : '' }}>クムホ（韓国）</option>
                                                    <option value="マキシス（台湾）" {{ request('maker1') == 'マキシス（台湾）' ? 'selected' : '' }}>マキシス（台湾）</option>
                                                    <option value="ジーテックス（中国）" {{ request('maker1') == 'ジーテックス（中国）' ? 'selected' : '' }}>ジーテックス（中国）</option>
                                                    <option value="トライアングル（中国）" {{ request('maker1') == 'トライアングル（中国）' ? 'selected' : '' }}>トライアングル（中国）</option>
                                                </optgroup>
                                            </select>
                                            <select name="maker2" id="maker2" class="w-full px-4 py-2 border rounded-lg bg-blue-50">
                                                <option value="" {{ request('maker2') == '' ? 'selected' : '' }}>商品２</option>
                                                <optgroup label="分類">
                                                    <option value="国内メーカー" {{ request('maker1') == '国産メーカー' ? 'selected' : '' }}>国産メーカー</option>
                                                    <option value="海外メーカー" {{ request('maker1') == '輸入メーカー' ? 'selected' : '' }}>輸入メーカー</option>
                                                    <option value="アジアンタイヤ" {{ request('maker1') == 'アジアンタイヤ' ? 'selected' : '' }}>アジアンタイヤ</option>
                                                </optgroup>
                                                <optgroup label="国内メーカー">
                                                    <option value="ブリヂストン" {{ request('maker1') == 'ブリヂストン' ? 'selected' : '' }}>ブリヂストン</option>
                                                    <option value="ダンロップ" {{ request('maker1') == 'ダンロップ' ? 'selected' : '' }}>ダンロップ</option>
                                                    <option value="ヨコハマ" {{ request('maker1') == 'ヨコハマ' ? 'selected' : '' }}>ヨコハマ</option>
                                                    <option value="トーヨータイヤ" {{ request('maker1') == 'トーヨータイヤ' ? 'selected' : '' }}>トーヨータイヤ</option>
                                                    <option value="セーバリング" {{ request('maker1') == 'セーバリング' ? 'selected' : '' }}>セーバリング</option>
                                                    <option value="ファルケン" {{ request('maker1') == 'ファルケン' ? 'selected' : '' }}>ファルケン</option>
                                                    <option value="ニットー" {{ request('maker1') == 'ニットー' ? 'selected' : '' }}>ニットー</option>
                                                </optgroup>
                                                <optgroup label="海外メーカー">
                                                    <option value="グッドイヤー" {{ request('maker1') == 'グッドイヤー' ? 'selected' : '' }}>グッドイヤー</option>
                                                    <option value="ミシュラン" {{ request('maker1') == 'ミシュラン' ? 'selected' : '' }}>ミシュラン</option>
                                                    <option value="ピレリ" {{ request('maker1') == 'ピレリ' ? 'selected' : '' }}>ピレリ</option>
                                                    <option value="コンチネンタル" {{ request('maker1') == 'コンチネンタル' ? 'selected' : '' }}>コンチネンタル</option>
                                                </optgroup>
                                                <optgroup label="アジアンタイヤ">
                                                    <option value="ナンカン（台湾）" {{ request('maker1') == 'ナンカン（台湾）' ? 'selected' : '' }}>ナンカン（台湾）</option>
                                                    <option value="ハンコック（韓国）" {{ request('maker1') == 'ハンコック（韓国）' ? 'selected' : '' }}>ハンコック（韓国）</option>
                                                    <option value="クムホ（韓国）" {{ request('maker1') == 'クムホ（韓国）' ? 'selected' : '' }}>クムホ（韓国）</option>
                                                    <option value="マキシス（台湾）" {{ request('maker1') == 'マキシス（台湾）' ? 'selected' : '' }}>マキシス（台湾）</option>
                                                    <option value="ジーテックス（中国）" {{ request('maker1') == 'ジーテックス（中国）' ? 'selected' : '' }}>ジーテックス（中国）</option>
                                                    <option value="トライアングル（中国）" {{ request('maker1') == 'トライアングル（中国）' ? 'selected' : '' }}>トライアングル（中国）</option>
                                                </optgroup>
                                            </select>
                                            <select name="maker3" id="maker3" class="w-full px-4 py-2 border rounded-lg bg-yellow-50">
                                                <option value="" {{ request('maker3') == '' ? 'selected' : '' }}>商品３</option>
                                                <optgroup label="分類">
                                                    <option value="国内メーカー" {{ request('maker1') == '国産メーカー' ? 'selected' : '' }}>国産メーカー</option>
                                                    <option value="海外メーカー" {{ request('maker1') == '輸入メーカー' ? 'selected' : '' }}>輸入メーカー</option>
                                                    <option value="アジアンタイヤ" {{ request('maker1') == 'アジアンタイヤ' ? 'selected' : '' }}>アジアンタイヤ</option>
                                                </optgroup>
                                                <optgroup label="国内メーカー">
                                                    <option value="ブリヂストン" {{ request('maker1') == 'ブリヂストン' ? 'selected' : '' }}>ブリヂストン</option>
                                                    <option value="ダンロップ" {{ request('maker1') == 'ダンロップ' ? 'selected' : '' }}>ダンロップ</option>
                                                    <option value="ヨコハマ" {{ request('maker1') == 'ヨコハマ' ? 'selected' : '' }}>ヨコハマ</option>
                                                    <option value="トーヨータイヤ" {{ request('maker1') == 'トーヨータイヤ' ? 'selected' : '' }}>トーヨータイヤ</option>
                                                    <option value="セーバリング" {{ request('maker1') == 'セーバリング' ? 'selected' : '' }}>セーバリング</option>
                                                    <option value="ファルケン" {{ request('maker1') == 'ファルケン' ? 'selected' : '' }}>ファルケン</option>
                                                    <option value="ニットー" {{ request('maker1') == 'ニットー' ? 'selected' : '' }}>ニットー</option>
                                                </optgroup>
                                                <optgroup label="海外メーカー">
                                                    <option value="グッドイヤー" {{ request('maker1') == 'グッドイヤー' ? 'selected' : '' }}>グッドイヤー</option>
                                                    <option value="ミシュラン" {{ request('maker1') == 'ミシュラン' ? 'selected' : '' }}>ミシュラン</option>
                                                    <option value="ピレリ" {{ request('maker1') == 'ピレリ' ? 'selected' : '' }}>ピレリ</option>
                                                    <option value="コンチネンタル" {{ request('maker1') == 'コンチネンタル' ? 'selected' : '' }}>コンチネンタル</option>
                                                </optgroup>
                                                <optgroup label="アジアンタイヤ">
                                                    <option value="ナンカン（台湾）" {{ request('maker1') == 'ナンカン（台湾）' ? 'selected' : '' }}>ナンカン（台湾）</option>
                                                    <option value="ハンコック（韓国）" {{ request('maker1') == 'ハンコック（韓国）' ? 'selected' : '' }}>ハンコック（韓国）</option>
                                                    <option value="クムホ（韓国）" {{ request('maker1') == 'クムホ（韓国）' ? 'selected' : '' }}>クムホ（韓国）</option>
                                                    <option value="マキシス（台湾）" {{ request('maker1') == 'マキシス（台湾）' ? 'selected' : '' }}>マキシス（台湾）</option>
                                                    <option value="ジーテックス（中国）" {{ request('maker1') == 'ジーテックス（中国）' ? 'selected' : '' }}>ジーテックス（中国）</option>
                                                    <option value="トライアングル（中国）" {{ request('maker1') == 'トライアングル（中国）' ? 'selected' : '' }}>トライアングル（中国）</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- タイヤサイズ選択 -->
                                    <div class="mb-6">
                                        <h3 class="text-lg font-semibold text-gray-700 mb-2">タイヤサイズ</h3>
                                        <select name="sizeGeneral" id="sizeGeneral" class="w-full px-4 py-2 border rounded-lg">
                                            <option value="0" {{ request('sizeGeneral') == '0' ? 'selected' : '' }}>汎用サイズ</option>

                                            <optgroup label="軽自動車">
                                                <option value="145/80R12" {{ request('sizeGeneral') == '145R/8012' ? 'selected' : '' }}>145R/8012</option>
                                                <option value="145/80R13" {{ request('sizeGeneral') == '145/80R13' ? 'selected' : '' }}>145/80R13</option>
                                                <option value="155/65R14" {{ request('sizeGeneral') == '155/65R14' ? 'selected' : '' }}>155/65R14</option>
                                                <option value="155/55R14" {{ request('sizeGeneral') == '155/55R14' ? 'selected' : '' }}>155/55R14</option>
                                                <option value="165/55R15" {{ request('sizeGeneral') == '165/55R15' ? 'selected' : '' }}>165/55R15</option>
                                            </optgroup>

                                            <optgroup label="ミニバン">
                                                <option value="195/65R15" {{ request('sizeGeneral') == '195/65R15' ? 'selected' : '' }}>195/65R15</option>
                                                <option value="205/60R16" {{ request('sizeGeneral') == '205/60R16' ? 'selected' : '' }}>205/60R16</option>
                                                <option value="215/60R16" {{ request('sizeGeneral') == '215/60R16' ? 'selected' : '' }}>215/60R16</option>
                                                <option value="225/55R17" {{ request('sizeGeneral') == '225/55R17' ? 'selected' : '' }}>225/55R17</option>
                                            </optgroup>

                                            <optgroup label="SUV">
                                                <option value="215/65R16" {{ request('sizeGeneral') == '215/65R16' ? 'selected' : '' }}>215/65R16</option>
                                                <option value="225/60R17" {{ request('sizeGeneral') == '225/60R17' ? 'selected' : '' }}>225/60R17</option>
                                                <option value="235/55R18" {{ request('sizeGeneral') == '235/55R18' ? 'selected' : '' }}>235/55R18</option>
                                                <option value="245/45R20" {{ request('sizeGeneral') == '245/45R20' ? 'selected' : '' }}>245/45R20</option>
                                            </optgroup>

                                            <optgroup label="コンパクトカー">
                                                <option value="175/65R15" {{ request('sizeGeneral') == '175/65R15' ? 'selected' : '' }}>175/65R15</option>
                                                <option value="185/60R15" {{ request('sizeGeneral') == '185/60R15' ? 'selected' : '' }}>185/60R15</option>
                                                <option value="195/65R15" {{ request('sizeGeneral') == '195/65R15' ? 'selected' : '' }}>195/65R15</option>
                                                <option value="185/55R16" {{ request('sizeGeneral') == '185/55R16' ? 'selected' : '' }}>185/55R16</option>
                                            </optgroup>

                                            <optgroup label="セダン">
                                                <option value="205/60R16" {{ request('sizeGeneral') == '205/60R16' ? 'selected' : '' }}>205/60R16</option>
                                                <option value="215/50R17" {{ request('sizeGeneral') == '215/50R17' ? 'selected' : '' }}>215/50R17</option>
                                                <option value="215/55R17" {{ request('sizeGeneral') == '215/55R17' ? 'selected' : '' }}>215/55R17</option>
                                                <option value="225/45R18" {{ request('sizeGeneral') == '225/45R18' ? 'selected' : '' }}>225/45R18</option>
                                            </optgroup>

                                            <optgroup label="スポーツ">
                                                <option value="225/45R17" {{ request('sizeGeneral') == '225/45R17' ? 'selected' : '' }}>225/45R17</option>
                                                <option value="235/40R18" {{ request('sizeGeneral') == '235/40R18' ? 'selected' : '' }}>235/40R18</option>
                                                <option value="245/40R18" {{ request('sizeGeneral') == '245/40R18' ? 'selected' : '' }}>245/40R18</option>
                                                <option value="255/35R19" {{ request('sizeGeneral') == '255/35R19' ? 'selected' : '' }}>255/35R19</option>
                                            </optgroup>

                                            <optgroup label="商用車">
                                                <option value="145/80R12" {{ request('sizeGeneral') == '145R/8012' ? 'selected' : '' }}>145R/8012</option>
                                                <option value="175/80R14" {{ request('sizeGeneral') == '175/80R14' ? 'selected' : '' }}>175/80R14</option>
                                                <option value="185/75R15" {{ request('sizeGeneral') == '185/75R15' ? 'selected' : '' }}>185/75R15</option>
                                                <option value="195/80R15" {{ request('sizeGeneral') == '195/80R15' ? 'selected' : '' }}>195/80R15</option>
                                                <option value="205/70R15" {{ request('sizeGeneral') == '205/70R15' ? 'selected' : '' }}>205/70R15</option>
                                            </optgroup>

                                        </select>
                                        <div class="mt-3">
                                            <input type="text" inputmode="text" pattern="[0-9/ R]*" name="sizeFree" id="sizeFree"
                                                placeholder="例: 155/65R14" class="w-full px-4 py-2 border rounded-lg">
                                        </div>
                                    </div>

                                    <!-- 宛名 -->
                                    <div class="mb-6">
                                        <h3 class="text-lg font-semibold text-gray-700 mb-2">宛名</h3>
                                        <div class="flex gap-2">
                                            <input type="text" name="address" id="address" class="w-full px-4 py-2 border rounded-lg"
                                                placeholder="宛名を入力">
                                            <select name="honorific" id="honorific" class="px-4 py-2 border rounded-lg">
                                                <option value="様">様</option>
                                                <option value="御中">御中</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- コメント -->
                                    <div class="mb-6">
                                        <h3 class="text-lg font-semibold text-gray-700 mb-2">コメント</h3>
                                        <textarea id="comment" name="comment" rows="4" class="w-full px-4 py-2 border rounded-lg">
※総額には、工賃、廃棄タイヤ費用、消費税すべて含みます。
            </textarea>
                                    </div>

                                </div>
                            </div>



                            <!-- ボタン -->
                            <div class="flex justify-between items-center">
                                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-600">📄 PDF印刷</button>
                                <button type="button" class="bg-gray-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-gray-600" onclick="copyToClipboard()">📋 コピーする</button>
                            </div>
                        </div>
                    </div>
            </div>








            <script>
                function updateCalculation() {
                    calculateProduct(1);
                    calculateProduct(2);
                    calculateProduct(3);
                    prepareFormData(); // 計算結果を隠しフィールドに設定

                }

                //htmlへ計算結果を表示する
                function calculateProduct(productNumber) {

                    const cost = parseInt(document.getElementById(`cost${productNumber}`).value) || 0;
                    const costMultiplier = parseInt(document.getElementById(`cost${productNumber}Multiplier`).value) || 1;
                    const profitA = parseInt(document.getElementById('profitOptionA')?.value) || 0;
                    const profitBMultiplier = parseFloat(document.getElementById('profitOptionB')?.value) || 1;

                    // 原価が0の場合は計算せずに終了
                    if (cost === 0) {
                        document.getElementById(`profitTotal${productNumber}`).innerText = '0';
                        document.getElementById(`wagesTotal${productNumber}`).innerText = '0';
                        document.getElementById(`Total${productNumber}`).innerText = '0';
                        document.getElementById(`TotalWithTax${productNumber}`).innerText = '0';
                        document.getElementById(`grossProfit${productNumber}`).innerText = '0';
                        return; // ここで終了
                    }

                    const wagesTotal = calculateWagesTotal();
                    const adjustedCost = cost * costMultiplier;
                    const profitTotal = Math.floor((adjustedCost + profitA) * profitBMultiplier);
                    const total = profitTotal + wagesTotal;
                    const totalWithTax = Math.floor(total * 1.1);

                    const tax = totalWithTax - total; // 消費税を計算
                    const grossProfit = profitTotal - adjustedCost; // 粗利を計算

                    document.getElementById(`profitTotal${productNumber}`).innerText = profitTotal.toLocaleString();
                    document.getElementById(`wagesTotal${productNumber}`).innerText = wagesTotal.toLocaleString();
                    document.getElementById(`Total${productNumber}`).innerText = total.toLocaleString();
                    document.getElementById(`TotalWithTax${productNumber}`).innerText = totalWithTax.toLocaleString();

                    document.getElementById(`tax${productNumber}`).innerText = tax.toLocaleString(); // 消費税を表示
                    document.getElementById(`grossProfit${productNumber}`).innerText = grossProfit.toLocaleString(); // 粗利を表示
                }


                //工賃計算
                function calculateWagesTotal() {
                    const sets = [1, 2, 3, 4, 5, 6, 7].map((set) => {
                        const value = parseInt(document.getElementById(`set${set}`)?.value) || 0;
                        const multiplier = parseInt(document.getElementById(`set${set}Multiplier`)?.value) || 1;
                        return value * multiplier;
                    });

                    return sets.reduce((acc, curr) => acc + curr, 0);
                }

                //フォームへデータを送る準備
                function prepareFormData() {
                    for (let i = 1; i <= 3; i++) {
                        const profitTotal = document.getElementById(`profitTotal${i}`).innerText.replace(/,/g, '') || 0;
                        const wagesTotal = document.getElementById(`wagesTotal${i}`).innerText.replace(/,/g, '') || 0;
                        const taxExcludedTotal = document.getElementById(`Total${i}`).innerText.replace(/,/g, '') || 0;
                        const taxIncludedTotal = document.getElementById(`TotalWithTax${i}`).innerText.replace(/,/g, '') || 0;
                        const tax = taxIncludedTotal - taxExcludedTotal; // 税額を計算

                        // 隠しフィールドに値を設定
                        document.getElementById(`hiddenProfitTotal${i}`).value = profitTotal;
                        document.getElementById(`hiddenWagesTotal${i}`).value = wagesTotal;
                        document.getElementById(`hiddenTotal${i}`).value = taxExcludedTotal;
                        document.getElementById(`hiddenTotalWithTax${i}`).value = taxIncludedTotal;
                        document.getElementById(`hiddenTax${i}`).value = tax; // 税額を設定

                        // name 属性の設定（送信用）
                        document.getElementById(`hiddenProfitTotal${i}`).setAttribute('name', `productData[${i}][profitTotal]`);
                        document.getElementById(`hiddenWagesTotal${i}`).setAttribute('name', `productData[${i}][wagesTotal]`);
                        document.getElementById(`hiddenTotal${i}`).setAttribute('name', `productData[${i}][taxExcludedTotal]`);
                        document.getElementById(`hiddenTotalWithTax${i}`).setAttribute('name', `productData[${i}][taxIncludedTotal]`);
                        document.getElementById(`hiddenTax${i}`).setAttribute('name', `productData[${i}][tax]`);
                    }
                }




                // フォーム送信時にprepareFormDataを呼び出す
                document.querySelector('form').addEventListener('submit', (event) => {
                    prepareFormData();
                });



                // 工賃設定をクッキーに保存する関数
                function saveSettingsToCookie() {
                    const isChecked = document.getElementById('saveToCookie').checked;
                    if (isChecked) {
                        const settings = {};

                        for (let i = 1; i <= 7; i++) {
                            const value = parseInt(document.getElementById(`set${i}`).value) || 0;
                            const multiplier = parseInt(document.getElementById(`set${i}Multiplier`).value) || 1;
                            settings[`set${i}`] = {
                                value,
                                multiplier
                            };
                        }

                        document.cookie = `wageSettings=${JSON.stringify(settings)}; path=/; max-age=31536000;`;
                        alert('工賃設定が保存されました。');
                    } else {
                        document.cookie = `wageSettings=; path=/; max-age=0;`;
                        alert('工賃設定が削除されました。');
                    }
                }

                // クッキーから工賃設定を読み込む関数
                function loadSettingsFromCookie() {
                    const cookies = document.cookie.split('; ').reduce((acc, curr) => {
                        const [key, value] = curr.split('=');
                        acc[key] = value;
                        return acc;
                    }, {});

                    if (cookies.wageSettings) {
                        const settings = JSON.parse(cookies.wageSettings);
                        for (let i = 1; i <= 7; i++) {
                            if (settings[`set${i}`]) {
                                document.getElementById(`set${i}`).value = settings[`set${i}`].value || 0;
                                document.getElementById(`set${i}Multiplier`).value = settings[`set${i}`].multiplier || 1;
                            }
                        }
                        //alert('工賃設定を読み込みました。');
                    }
                }

                // ページ読み込み時にクッキーから設定を読み込む
                window.onload = loadSettingsFromCookie;

                function prepareFormData() {
                    for (let i = 1; i <= 3; i++) {
                        document.getElementById(`hiddenProfitTotal${i}`).value = document.getElementById(`profitTotal${i}`).innerText.replace(/,/g, '');
                        document.getElementById(`hiddenWagesTotal${i}`).value = document.getElementById(`wagesTotal${i}`).innerText.replace(/,/g, '');
                        document.getElementById(`hiddenTotal${i}`).value = document.getElementById(`Total${i}`).innerText.replace(/,/g, '');
                        document.getElementById(`hiddenTotalWithTax${i}`).value = document.getElementById(`TotalWithTax${i}`).innerText.replace(/,/g, '');
                    }
                }

                function copyToClipboard() {
                    // コピーするデータを取得
                    const data = [
                        //選択したタイヤ
                        {
                            label: '',
                            value: document.querySelector('input[name="selectTire"]:checked')?.value || ''
                        },
                        //サイズ
                        {
                            label: 'サイズ：',
                            value: document.getElementById('sizeGeneral')?.value || ''
                        },
                        {
                            label: 'サイズ：',
                            value: document.getElementById('sizeFree')?.value || ''
                        },
                        //商品１
                        {
                            label: '▼',
                            value: document.getElementById('maker1')?.value || ''
                        },
                        {
                            label: '',
                            value: addYenSuffix(document.getElementById('TotalWithTax1')?.innerText || '')
                        },
                        //商品２
                        {
                            label: '▼',
                            value: document.getElementById('maker2')?.value || ''
                        },
                        {
                            label: '',
                            value: addYenSuffix(document.getElementById('TotalWithTax2')?.innerText || '')
                        },
                        //商品３
                        {
                            label: '▼',
                            value: document.getElementById('maker3')?.value || ''
                        },
                        {
                            label: '',
                            value: addYenSuffix(document.getElementById('TotalWithTax3')?.innerText || '')
                        },
                        //コメント
                        {
                            label: '',
                            value: document.getElementById('comment')?.value.trim() || ''
                        },

                    ];

                    // コピーボタンに"円"を追加する関数
                    function addYenSuffix(value) {
                        // 値が空または0の場合はそのまま返す
                        if (value === '' || value === '0') {
                            return value;
                        }
                        // 値に "円" を追加して返す
                        return `${value} 円`;
                    }

                    // 0 や空文字の項目を除外
                    const filteredData = data
                        .filter(item => item.value !== '0' && item.value !== '' && item.value !== '未入力' && item.value !== '未選択')
                        .map(item => `${item.label}${item.value}`);

                    // コピーする内容が空の場合は通知して終了
                    if (filteredData.length === 0) {
                        alert('コピーするデータがありません。');
                        return;
                    }

                    // コピーする内容を整形
                    const copyText = filteredData.join('\n');

                    // クリップボードにコピー
                    navigator.clipboard.writeText(copyText).then(() => {
                        alert('データをコピーしました！');
                    }).catch(err => {
                        alert('コピーに失敗しました。');
                        console.error('コピーエラー:', err);
                    });
                }


                function clearWagesSettings() {
                    // 工賃と倍率のIDを列挙
                    const wageFields = [{
                            inputId: 'set1',
                            multiplierId: 'set1Multiplier'
                        },
                        {
                            inputId: 'set2',
                            multiplierId: 'set2Multiplier'
                        },
                        {
                            inputId: 'set3',
                            multiplierId: 'set3Multiplier'
                        },
                        {
                            inputId: 'set4',
                            multiplierId: 'set4Multiplier'
                        },
                        {
                            inputId: 'set5',
                            multiplierId: 'set5Multiplier'
                        },
                        {
                            inputId: 'set6',
                            multiplierId: 'set6Multiplier'
                        },
                        {
                            inputId: 'set7',
                            multiplierId: 'set7Multiplier'
                        }
                    ];

                    // 各フィールドをゼロにリセット
                    wageFields.forEach(field => {
                        document.getElementById(field.inputId).value = 0;
                        document.getElementById(field.multiplierId).value = 1; // デフォルトの倍率にリセット
                    });

                    // 設定が変更されたので再計算を実行
                    updateCalculation();

                    alert('工賃設定をクリアしました。');
                }
            </script>

</x-app-layout>