{{-- resources/views/quote/popup/tax_item.blade.php --}}
{{-- 汎用項目候補ポップアップ：openTaxPopup('tax_item') で開く --}}
<div id="taxPopupitem" class="fixed inset-0 z-50 hidden">
  {{-- 背景（クリックで閉じる） --}}
  <div class="absolute inset-0 bg-black/40" onclick="closeTaxPopup('tax_item')"></div>

  {{-- 本体 --}}
  <div class="relative mx-auto mt-24 w-11/12 max-w-md rounded-lg bg-white shadow-lg">
    {{-- ヘッダー --}}
    <div class="flex items-center justify-between border-b px-4 py-3">
      <h4 class="text-base font-semibold text-gray-800">項目を選択</h4>
      <button type="button"
              class="text-gray-500 hover:text-gray-700"
              onclick="closeTaxPopup('tax_item')"
              aria-label="Close">
        <i class="fas fa-times"></i>
      </button>
    </div>

    {{-- ボディ（候補ボタン） --}}
    <div class="p-4">
      {{-- よく使う候補（必要に応じて編集してください） --}}
      <div class="grid grid-cols-2 gap-2">
        <button type="button" class="px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 text-left"
                onclick="selectTaxItem('登録費用')">登録費用</button>
        <button type="button" class="px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 text-left"
                onclick="selectTaxItem('車庫証明')">車庫証明</button>
        <button type="button" class="px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 text-left"
                onclick="selectTaxItem('リサイクル資金管理')">リサイクル資金管理</button>
        <button type="button" class="px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 text-left"
                onclick="selectTaxItem('納車費用')">納車費用</button>
        <button type="button" class="px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 text-left"
                onclick="selectTaxItem('下取り車手続き代行費用')">下取り車手続き代行費用</button>
        <button type="button" class="px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 text-left"
                onclick="selectTaxItem('下取り車査定料')">下取り車査定料</button>
        <button type="button" class="px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 text-left"
                onclick="selectTaxItem('希望番号')">希望番号</button>
        <button type="button" class="px-3 py-2 rounded bg-gray-100 hover:bg-gray-200 text-left"
                onclick="selectTaxItem('燃料代')">燃料代</button>
      </div>

      {{-- 任意：自由入力から確定したい時の補助（必要なら使う） --}}
      {{-- <div class="mt-4 flex gap-2">
        <input type="text" id="taxItemCustomInput" class="flex-1 px-3 py-2 border rounded" placeholder="カスタム項目名">
        <button type="button" class="px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700"
                onclick="(function(){ const v=document.getElementById('taxItemCustomInput').value.trim(); if(v){ selectTaxItem(v); } })()">
          追加
        </button>
      </div> --}}

      <div class="mt-4 text-right">
        <button type="button"
                class="inline-flex items-center gap-2 px-3 py-2 rounded border hover:bg-gray-50"
                onclick="closeTaxPopup('tax_item')">
          閉じる
        </button>
      </div>
    </div>
  </div>
</div>
