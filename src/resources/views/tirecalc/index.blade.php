<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('tirecalc.index') }}">
                タイヤ計算機
            </a>
        </h2>

    </x-slot>

    @if (session('success'))
    <div class=" bg-green-100 text-green-800 p-2 mb-4 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="py-12">
        <div x-data="{ showLoginModal: false }">

            <div x-data="taxCalculator()" class="w-full max-w-full md:max-w-4xl mx-auto p-6 bg-white rounded shadow space-y-8">

                <form method="POST" :action="action" x-data="{ action: '{{ route('tirecalc.createPdf') }}' }" id="pdf-form">

                    @csrf
                    <input type="hidden" name="view" value="tirecalc.createPdf">


                    <input type="hidden" name="item1_cost" :value="item1.cost">
                    <input type="hidden" name="item1_quantity" :value="item1.quantity">
                    <input type="hidden" name="item2_cost" :value="item2.cost">
                    <input type="hidden" name="item2_quantity" :value="item2.quantity">
                    <input type="hidden" name="item3_cost" :value="item3.cost">
                    <input type="hidden" name="item3_quantity" :value="item3.quantity">

                    <!-- 粗利A/B、工賃税モードなども同様に送信 -->
                    <template x-for="(item, i) in laborItems" :key="i">
                        <div>
                            <input type="hidden" :name="`laborItems[${i}][name]`" :value="item.name">
                            <input type="hidden" :name="`laborItems[${i}][price]`" :value="item.price">
                            <input type="hidden" :name="`laborItems[${i}][quantity]`" :value="item.quantity">
                        </div>
                    </template>


                    <input type="hidden" name="grossA" :value="grossA">
                    <input type="hidden" name="grossB" :value="grossB">
                    <input type="hidden" name="taxMode" :value="taxMode">
                    <input type="hidden" name="laborTaxMode" :value="laborTaxMode">

                    <input type="hidden" name="laborSubtotal" :value="laborSubtotal">
                    <input type="hidden" name="totalWithLabor1" :value="totalWithLabor(item1)">
                    <input type="hidden" name="totalWithLabor2" :value="totalWithLabor(item2)">
                    <input type="hidden" name="totalWithLabor3" :value="totalWithLabor(item3)">

                    <!-- PDF印刷設定フォームの値を送信 -->




                    <div class="mt-1 pt-2">

                        <!-- 原価入力 -->
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-1">①原価入力</h3>
                            <label class="inline-flex items-center mr-4">
                                <input type="radio" x-model="taxMode" value="including" class="mr-1">
                                税込み
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" x-model="taxMode" value="excluding" class="mr-1">
                                税抜き
                            </label>
                        </div>

                        <!-- 商品1 -->
                        <div class="p-4 border rounded bg-red-50 space-y-3 mb-4">

                            <div class="flex gap-4">
                                <div class="w-[70%]">

                                    <input type="number" x-model.number="item1.cost" min="0" placeholder="商品Aの原価" class="w-full border rounded px-2 py-1">
                                </div>
                                <div class="w-[30%]">

                                    <select x-model.number="item1.quantity" class="w-full border rounded px-2 py-1">
                                        <option value="1">1個</option>
                                        <option value="2">2個</option>
                                        <option value="3">3個</option>
                                        <option value="4">4個</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-sm leading-relaxed space-y-1">
                                <p>
                                    タイヤ代：<span x-text="displayUnitPrice(item1).toLocaleString()"></span> 円
                                    （粗利 <span x-text="getProfitAmount(item1).toLocaleString()"></span> 円）
                                </p>
                                <p>工賃合計：<span x-text="laborSubtotal.toLocaleString()"></span> 円</p>
                                <p class="font-bold text-base mt-1">合計：<span x-text="totalWithLabor(item1).toLocaleString()"></span> 円</p>
                            </div>
                        </div>

                        <!-- 商品2 -->
                        <div class="p-4 border rounded bg-blue-50 space-y-3 mb-4">

                            <div class="flex gap-4">
                                <div class="w-[70%]">

                                    <input type="number" x-model.number="item2.cost" min="0" placeholder="商品Bの原価" class="w-full border rounded px-2 py-1">
                                </div>
                                <div class="w-[30%]">

                                    <select x-model.number="item2.quantity" class="w-full border rounded px-2 py-1">
                                        <option value="1">1個</option>
                                        <option value="2">2個</option>
                                        <option value="3">3個</option>
                                        <option value="4">4個</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-sm leading-relaxed space-y-1 mb-4">
                                <p>
                                    タイヤ代：<span x-text="displayUnitPrice(item2).toLocaleString()"></span> 円
                                    （粗利 <span x-text="getProfitAmount(item2).toLocaleString()"></span> 円）
                                </p>
                                <p>工賃合計：<span x-text="laborSubtotal.toLocaleString()"></span> 円</p>
                                <p class="font-bold text-base mt-1">合計：<span x-text="totalWithLabor(item2).toLocaleString()"></span> 円</p>
                            </div>
                        </div>

                        <!-- 商品3 -->
                        <div class="p-4 border rounded bg-yellow-50 space-y-3">


                            <div class="flex gap-4">
                                <div class="w-[70%]">

                                    <input type="number" x-model.number="item3.cost" min="0" placeholder="商品Cの原価" class="w-full border rounded px-2 py-1">
                                </div>
                                <div class="w-[30%]">

                                    <select x-model.number="item3.quantity" class="w-full border rounded px-2 py-1">
                                        <option value="1">1個</option>
                                        <option value="2">2個</option>
                                        <option value="3">3個</option>
                                        <option value="4">4個</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-sm leading-relaxed space-y-1">
                                <p>
                                    タイヤ代：<span x-text="displayUnitPrice(item3).toLocaleString()"></span> 円
                                    （粗利 <span x-text="getProfitAmount(item3).toLocaleString()"></span> 円）
                                </p>
                                <p>工賃合計：<span x-text="laborSubtotal.toLocaleString()"></span> 円</p>
                                <p class="font-bold text-base mt-1">合計：<span x-text="totalWithLabor(item3).toLocaleString()"></span> 円</p>
                            </div>
                        </div>

                    </div>


                    <!-- 共通設定：粗利 -->
                    <div class="mt-6 border-t pt-4">
                        <h3 class="text-xl font-bold mb-2">②粗利設定
                            </h2>

                            <!-- 横並び：粗利A・粗利B -->
                            <div class="flex gap-4">
                                <!-- 粗利A（加算） -->
                                <div class="w-1/2">
                                    <select x-model="grossA" class="w-full border rounded px-2 py-1">
                                        <option :value="null">粗利（加算）</option>
                                        <template x-for="amount in [5000, 10000, 15000, 20000]" :key="amount">
                                            <option :value="amount" x-text="`${amount.toLocaleString()} 円`"></option>
                                        </template>
                                    </select>
                                </div>

                                <!-- 粗利B（掛け算） -->
                                <div class="w-1/2">
                                    <select x-model="grossB" class="w-full border rounded px-2 py-1">
                                        <option :value="null">粗利（乗算）</option>
                                        <template x-for="rate in [1.1, 1.2, 1.3, 1.4, 1.5]" :key="rate">
                                            <option :value="rate" x-text="rate.toFixed(1)"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                    </div>


                    <!-- ✅ 工賃設定フォーム -->
                    <div class="mt-6 border-t pt-4">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold mb-2">③工賃設定</h3>
                            <label class="inline-flex items-center mr-4">
                                <input type="radio" x-model="laborTaxMode" value="including" class="mr-1">
                                税込み
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" x-model="laborTaxMode" value="excluding" class="mr-1">
                                税抜き
                            </label>
                        </div>

                        <!-- 明細行（5:3:2 レイアウト） -->
                        <template x-for="(row, index) in laborItems" :key="index">
                            <div class="flex gap-2 mb-3">
                                <input type="text" x-model="row.name" class="w-[50%] border rounded px-2 py-1" placeholder="項目名">
                                <input type="number" x-model.number="row.price" min="0" class="w-[30%] border rounded px-2 py-1" placeholder="金額">
                                <select x-model.number="row.quantity" class="w-[20%] border rounded px-2 py-1">
                                    <option value="1">1個</option>
                                    <option value="2">2個</option>
                                    <option value="3">3個</option>
                                    <option value="4">4個</option>
                                </select>
                            </div>
                        </template>

                        <!-- 明細追加ボタン -->
                        <button type="button" @click="addLaborItem()" class="text-blue-600 text-sm">＋ 明細を追加</button>

                        <!-- 工賃小計 -->
                        <div class="mt-1 font-bold text-right text-gray-500">
                            工賃合計：<span x-text="laborSubtotal.toLocaleString()"></span> 円
                        </div>
                    </div>





                    <!-- アコーディオンメニュー -->
                    <div x-data="{ open: false }" class="mt-6 border-t pt-4">

                        <!-- トグル見出し -->
                        <div class="flex items-center justify-between cursor-pointer mb-4" @click="open = !open">
                            <h3 class="text-lg font-bold text-gray-800">PDF設定・コピー設定</h4>
                                <div class="text-xl">
                                    <span x-show="!open">＋</span>
                                    <span x-show="open">−</span>
                                </div>
                        </div>

                        <!-- アコーディオン内容 -->
                        <div x-show="open" x-transition>

                            <!-- メーカー選択 -->
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-700 mb-2">メーカー</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <select name="maker1" id="maker1" class="w-full px-4 py-2 border rounded-lg bg-red-50">
                                        <option value="" {{ request('maker1') == '' ? 'selected' : '' }}>商品A</option>
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
                                        <option value="" {{ request('maker2') == '' ? 'selected' : '' }}>商品B</option>
                                        <optgroup label="分類">
                                            <option value="国内メーカー" {{ request('maker2') == '国産メーカー' ? 'selected' : '' }}>国産メーカー</option>
                                            <option value="海外メーカー" {{ request('maker2') == '輸入メーカー' ? 'selected' : '' }}>輸入メーカー</option>
                                            <option value="アジアンタイヤ" {{ request('maker2') == 'アジアンタイヤ' ? 'selected' : '' }}>アジアンタイヤ</option>
                                        </optgroup>
                                        <optgroup label="国内メーカー">
                                            <option value="ブリヂストン" {{ request('maker2') == 'ブリヂストン' ? 'selected' : '' }}>ブリヂストン</option>
                                            <option value="ダンロップ" {{ request('maker2') == 'ダンロップ' ? 'selected' : '' }}>ダンロップ</option>
                                            <option value="ヨコハマ" {{ request('maker2') == 'ヨコハマ' ? 'selected' : '' }}>ヨコハマ</option>
                                            <option value="トーヨータイヤ" {{ request('maker2') == 'トーヨータイヤ' ? 'selected' : '' }}>トーヨータイヤ</option>
                                            <option value="セーバリング" {{ request('maker2') == 'セーバリング' ? 'selected' : '' }}>セーバリング</option>
                                            <option value="ファルケン" {{ request('maker2') == 'ファルケン' ? 'selected' : '' }}>ファルケン</option>
                                            <option value="ニットー" {{ request('maker2') == 'ニットー' ? 'selected' : '' }}>ニットー</option>
                                        </optgroup>
                                        <optgroup label="海外メーカー">
                                            <option value="グッドイヤー" {{ request('maker2') == 'グッドイヤー' ? 'selected' : '' }}>グッドイヤー</option>
                                            <option value="ミシュラン" {{ request('maker2') == 'ミシュラン' ? 'selected' : '' }}>ミシュラン</option>
                                            <option value="ピレリ" {{ request('maker2') == 'ピレリ' ? 'selected' : '' }}>ピレリ</option>
                                            <option value="コンチネンタル" {{ request('maker2') == 'コンチネンタル' ? 'selected' : '' }}>コンチネンタル</option>
                                        </optgroup>
                                        <optgroup label="アジアンタイヤ">
                                            <option value="ナンカン（台湾）" {{ request('maker2') == 'ナンカン（台湾）' ? 'selected' : '' }}>ナンカン（台湾）</option>
                                            <option value="ハンコック（韓国）" {{ request('maker2') == 'ハンコック（韓国）' ? 'selected' : '' }}>ハンコック（韓国）</option>
                                            <option value="クムホ（韓国）" {{ request('maker2') == 'クムホ（韓国）' ? 'selected' : '' }}>クムホ（韓国）</option>
                                            <option value="マキシス（台湾）" {{ request('maker2') == 'マキシス（台湾）' ? 'selected' : '' }}>マキシス（台湾）</option>
                                            <option value="ジーテックス（中国）" {{ request('maker2') == 'ジーテックス（中国）' ? 'selected' : '' }}>ジーテックス（中国）</option>
                                            <option value="トライアングル（中国）" {{ request('maker2') == 'トライアングル（中国）' ? 'selected' : '' }}>トライアングル（中国）</option>
                                        </optgroup>
                                    </select>
                                    <select name="maker3" id="maker3" class="w-full px-4 py-2 border rounded-lg bg-yellow-50">
                                        <option value="" {{ request('maker3') == '' ? 'selected' : '' }}>商品C</option>
                                        <optgroup label="分類">
                                            <option value="国内メーカー" {{ request('maker3') == '国産メーカー' ? 'selected' : '' }}>国産メーカー</option>
                                            <option value="海外メーカー" {{ request('maker3') == '輸入メーカー' ? 'selected' : '' }}>輸入メーカー</option>
                                            <option value="アジアンタイヤ" {{ request('maker3') == 'アジアンタイヤ' ? 'selected' : '' }}>アジアンタイヤ</option>
                                        </optgroup>
                                        <optgroup label="国内メーカー">
                                            <option value="ブリヂストン" {{ request('maker3') == 'ブリヂストン' ? 'selected' : '' }}>ブリヂストン</option>
                                            <option value="ダンロップ" {{ request('maker3') == 'ダンロップ' ? 'selected' : '' }}>ダンロップ</option>
                                            <option value="ヨコハマ" {{ request('maker3') == 'ヨコハマ' ? 'selected' : '' }}>ヨコハマ</option>
                                            <option value="トーヨータイヤ" {{ request('maker3') == 'トーヨータイヤ' ? 'selected' : '' }}>トーヨータイヤ</option>
                                            <option value="セーバリング" {{ request('maker3') == 'セーバリング' ? 'selected' : '' }}>セーバリング</option>
                                            <option value="ファルケン" {{ request('maker3') == 'ファルケン' ? 'selected' : '' }}>ファルケン</option>
                                            <option value="ニットー" {{ request('maker3') == 'ニットー' ? 'selected' : '' }}>ニットー</option>
                                        </optgroup>
                                        <optgroup label="海外メーカー">
                                            <option value="グッドイヤー" {{ request('maker3') == 'グッドイヤー' ? 'selected' : '' }}>グッドイヤー</option>
                                            <option value="ミシュラン" {{ request('maker3') == 'ミシュラン' ? 'selected' : '' }}>ミシュラン</option>
                                            <option value="ピレリ" {{ request('maker3') == 'ピレリ' ? 'selected' : '' }}>ピレリ</option>
                                            <option value="コンチネンタル" {{ request('maker3') == 'コンチネンタル' ? 'selected' : '' }}>コンチネンタル</option>
                                        </optgroup>
                                        <optgroup label="アジアンタイヤ">
                                            <option value="ナンカン（台湾）" {{ request('maker3') == 'ナンカン（台湾）' ? 'selected' : '' }}>ナンカン（台湾）</option>
                                            <option value="ハンコック（韓国）" {{ request('maker3') == 'ハンコック（韓国）' ? 'selected' : '' }}>ハンコック（韓国）</option>
                                            <option value="クムホ（韓国）" {{ request('maker3') == 'クムホ（韓国）' ? 'selected' : '' }}>クムホ（韓国）</option>
                                            <option value="マキシス（台湾）" {{ request('maker3') == 'マキシス（台湾）' ? 'selected' : '' }}>マキシス（台湾）</option>
                                            <option value="ジーテックス（中国）" {{ request('maker3') == 'ジーテックス（中国）' ? 'selected' : '' }}>ジーテックス（中国）</option>
                                            <option value="トライアングル（中国）" {{ request('maker3') == 'トライアングル（中国）' ? 'selected' : '' }}>トライアングル（中国）</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>


                            <!-- タイトル選択 -->
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-700 mb-2">タイトル</h4>
                                <div class="mb-6">
                                    <select name="selectTire" id="selectTire" class="w-full px-4 py-2 border rounded-lg">
                                        <option value="0" {{ request('selectTire') == '' ? 'selected' : '' }}>選択してください</option>
                                        <option value="夏タイヤ">夏タイヤのみ</option>
                                        <option value="夏タイヤAWセット">夏タイヤ AWセット</option>
                                        <option value="冬タイヤ">冬タイヤのみ</option>
                                        <option value="冬タイヤAWセット">冬タイヤ AWセット</option>
                                        <option value="オールシーズンタイヤ">オールシーズンタイヤのみ</option>
                                        <option value="オールシーズンタイヤAWセット">オールシーズンタイヤ AWセット</option>
                                        <option value="AWのみ">AWのみ</option>
                                    </select>
                                </div>
                            </div>

                            <!-- タイヤサイズ選択 -->
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-700 mb-2">タイヤサイズ</h4>
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
                                        placeholder="フリー入力" class="w-full px-4 py-2 border rounded-lg">
                                </div>
                            </div>


                            <!-- 宛名 -->
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-700 mb-2">宛名</h4>
                                <div class="flex gap-2">
                                    <input type="text" name="customer_name" id="customer_name" class="w-full px-4 py-2 border rounded-lg"
                                        placeholder="宛名を入力">
                                    <select name="honorific" id="honorific" class="px-4 py-2 border rounded-lg">
                                        <option value="様">様</option>
                                        <option value="御中">御中</option>
                                    </select>
                                </div>
                            </div>

                            <!-- コメント -->
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-700 mb-2">コメント</h4>
                                <textarea id="comment" name="comment" rows="4" class="w-full px-4 py-2 border rounded-lg">※総額には、工賃、廃棄タイヤ費用、消費税すべて含みます。
                                </textarea>
                            </div>

                        </div>


                    </div>




                    {{-- 発行者情報フォーム --}}
                    @include('components.company-info')




                    {{-- ボタン群 --}}
                    <div class="flex justify-center gap-4 mt-6">
                        <!-- PDFボタン -->
                        <button
                            type="submit"
                            @click="action = '{{ route('tirecalc.createPdf') }}'"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            PDF作成
                        </button>

                        <!-- コピー ボタン -->
                        <div x-data="taxCalculator()">
                            <button type="button"
                                class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700""
                            @click=" copyToClipboard">
                                コピー
                            </button>
                        </div>

                        <!-- 保存ボタン -->
                        @auth
                        <!-- ✅ ログインユーザー用ボタン -->
                        <button
                            type="submit"
                            @click="action = '{{ route('tirecalc.store') }}'"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                            保存
                        </button>
                        @endauth

                        @guest
                        <!-- 🚫 未ログインユーザー用ボタン（モーダルを開くだけ） -->
                        <button
                            type="button"
                            @click.prevent="showLoginModal = true"
                            class="bg-gray-300 text-white px-6 py-2 rounded cursor-pointer">
                            保存
                        </button>
                        @endguest

                    </div>

                </form>



                {{-- 保存モーダル --}}
                @include('components.save-modal')


                {{-- 保存済み一覧 --}}
                @auth
                @php
                $limit = auth()->user()->limit();
                $count = auth()->user()->tirecalcs()->count();
                $isOverLimit = $count >= $limit;
                @endphp
                <x-save-list :items="$tirecalcs" itemName="tirecalcs" :is-over-limit="$isOverLimit" routePrefix="tirecalc" />
                @endauth

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

                    laborTaxMode: 'excluding',

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
                            quantity: 1
                        });
                    },

                    get laborSubtotal() {
                        const subtotal = this.laborItems.reduce((sum, item) => {
                            const price = Number(item.price) || 0;
                            const quantity = Number(item.quantity) || 0;
                            return sum + (price * quantity);
                        }, 0);
                        return this.laborTaxMode === 'including' ? subtotal : Math.round(subtotal * 1.1);
                    },

                    applyGrossMargin(cost) {
                        const add = parseFloat(this.grossA);
                        const mul = parseFloat(this.grossB);
                        const safeAdd = isNaN(add) ? 0 : add;
                        const safeMul = isNaN(mul) ? 1 : mul;
                        return Math.round((cost + safeAdd) * safeMul);
                    },

                    displayUnitPrice(item) {
                        const cost = Number(item.cost) || 0;
                        const quantity = Number(item.quantity) || 0;
                        const base = cost * quantity;

                        const add = parseFloat(this.grossA);
                        const mul = parseFloat(this.grossB);
                        const safeAdd = !isNaN(add) ? add : 0;
                        const safeMul = !isNaN(mul) ? mul : 1;

                        const priceWithProfit = (base + safeAdd) * safeMul;
                        return this.taxMode === 'including' ? Math.round(priceWithProfit) : Math.round(priceWithProfit * 1.1);
                    },

                    getProfitAmount(item) {
                        const cost = Number(item.cost) || 0;
                        const quantity = Number(item.quantity) || 0;
                        const base = cost * quantity;

                        const add = parseFloat(this.grossA);
                        const mul = parseFloat(this.grossB);
                        const safeAdd = !isNaN(add) ? add : 0;
                        const safeMul = !isNaN(mul) ? mul : 1;

                        const finalPrice = (base + safeAdd) * safeMul;
                        return Math.round(finalPrice - base);
                    },

                    totalPrice(item) {
                        return this.displayUnitPrice(item) * item.quantity;
                    },

                    totalWithLabor(item) {
                        return this.displayUnitPrice(item) + this.laborSubtotal;
                    },

                    // クリップボードにコピーする関数
                    async copyToClipboard() {

                        let output = '';

                        const customer_name = document.getElementById('customer_name')?.value || '';
                        const honorific = document.getElementById('honorific')?.value || '';
                        output += `■ 宛名\n${customer_name} ${honorific}\n\n`;

                        const selectTire = document.getElementById('selectTire')?.value || '未選択';
                        output += `■ タイトル\n${selectTire}\n\n`;

                        const sizeGeneral = document.getElementById('sizeGeneral')?.value;
                        const sizeFree = document.getElementById('sizeFree')?.value;
                        output += `■ タイヤサイズ\n${sizeFree || sizeGeneral || '未入力'}\n\n`;

                        const maker1 = document.getElementById('maker1')?.value || '未選択';
                        const maker2 = document.getElementById('maker2')?.value || '未選択';
                        const maker3 = document.getElementById('maker3')?.value || '未選択';

                        output += `■ 商品1：${maker1}\n合計：${this.totalWithLabor(this.item1)} 円\n\n`;
                        output += `■ 商品2：${maker2}\n合計：${this.totalWithLabor(this.item2)} 円\n\n`;
                        output += `■ 商品3：${maker3}\n合計：${this.totalWithLabor(this.item3)} 円\n\n`;

                        output += `■ 工賃明細\n小計：${this.laborSubtotal} 円\n\n`;

                        const comment = document.getElementById('comment')?.value || '';
                        output += `■ コメント\n${comment.trim()}\n`;

                        try {
                            await navigator.clipboard.writeText(output);
                            alert('入力内容をクリップボードにコピーしました！');
                        } catch (e) {
                            alert('コピーに失敗しました');
                        }
                    }
                };


            }
        </script>



</x-app-layout>