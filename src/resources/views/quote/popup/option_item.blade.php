<!-- オプション汎用候補ポップアップ -->
<div id="taxPopupoption_item" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <!-- 背景 -->
    <div class="absolute inset-0 bg-black bg-opacity-40" onclick="closeTaxPopup('option_item')"></div>

    <!-- 本体 -->
    <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md p-6 z-10">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">オプション候補を選択</h3>
            <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeTaxPopup('option_item')">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="grid grid-cols-2 gap-2">
            <button type="button" class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200 text-left" onclick="selectOptionItem('フロアマット')">フロアマット</button>
            <button type="button" class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200 text-left" onclick="selectOptionItem('サイドバイザー')">サイドバイザー</button>
            <button type="button" class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200 text-left" onclick="selectOptionItem('ナビゲーション')">ナビゲーション</button>
            <button type="button" class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200 text-left" onclick="selectOptionItem('バックカメラ')">バックカメラ</button>
            <button type="button" class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200 text-left" onclick="selectOptionItem('ETC')">ETC</button>
            <button type="button" class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200 text-left" onclick="selectOptionItem('ドライブレコーダー')">ドライブレコーダー</button>
            <button type="button" class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200 text-left" onclick="selectOptionItem('ボディコーティング')">ボディコーティング</button>
            <button type="button" class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200 text-left" onclick="selectOptionItem('下回り防錆')">下回り防錆</button>
        </div>

        <div class="mt-4 text-right">
            <button type="button" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300" onclick="closeTaxPopup('option_item')">閉じる</button>
        </div>
    </div>
</div>