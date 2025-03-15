
<!-- ポップアップウィンドウ（自動車税月割表） -->
<div class="mb-4">
    <label for="tax_1" class="block text-gray-700 font-semibold mb-1 flex items-center">
        自動車税（月割）
        <!-- ポップアップアイコンボタン -->
        <button type="button" onclick="openTaxPopup('tax_1')" class="ml-2 text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V7a1 1 0 112 0v2a1 1 0 11-2 0zm0 4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"/>
            </svg>
        </button>
    </label>
    <input type="number" name="tax_1" id="tax_1" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
    </div>

<!-- ポップアップウィンドウ（自動車税月割表） -->
<div id="taxPopup1" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl overflow-auto max-h-full">
        <h2 class="text-lg font-semibold mb-4">自動車税（月割）</h2>
        <table class="w-full border-collapse">
        <thead>
    <tr>
        <th class="border px-2 py-1" data-month="4">4月</th>
        <th class="border px-2 py-1" data-month="5">5月</th>
        <th class="border px-2 py-1" data-month="6">6月</th>
        <th class="border px-2 py-1" data-month="7">7月</th>
        <th class="border px-2 py-1" data-month="8">8月</th>
        <th class="border px-2 py-1" data-month="9">9月</th>
        <th class="border px-2 py-1" data-month="10">10月</th>
        <th class="border px-2 py-1" data-month="11">11月</th>
        <th class="border px-2 py-1" data-month="12">12月</th>
        <th class="border px-2 py-1" data-month="1">1月</th>
        <th class="border px-2 py-1" data-month="2">2月</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td class="border px-2 py-1"><button onclick="selectTax(40, 'tax_1')">4月 40円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(50, 'tax_1')">5月 50円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(60, 'tax_1')">6月 60円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(70, 'tax_1')">7月 70円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(80, 'tax_1')">8月 80円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(90, 'tax_1')">9月 90円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(100, 'tax_1')">10月 100円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(110, 'tax_1')">11月 110円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(120, 'tax_1')">12月 120円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(130, 'tax_1')">1月 10円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(140, 'tax_1')">2月 20円</button></td>
    </tr>
</tbody>
        </table>
        <button type="button" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-full" onclick="closeTaxPopup('tax_1')">閉じる</button>
    </div>
</div>



<!--bk-->
<div class="mb-4">
                <label for="tax_1" class="block text-gray-700 font-semibold mb-1">自動車税</label> 
                <input type="number" name="tax_1" id="tax_1" class="w-full px-4 py-2 border rounded-lg" oninput="calculateOverheadTotal()">
            </div>



<!-- ポップアップウィンドウ（自動車税月割表） -->
<div class="mb-4">
    <label for="tax_3" class="block text-gray-700 font-semibold mb-1 flex items-center">
        自賠責保険（月割）
        <!-- ポップアップアイコンボタン -->
        <button type="button" onclick="openTaxPopup('tax_3')" class="ml-2 text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V7a1 1 0 112 0v2a1 1 0 11-2 0zm0 4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"/>
            </svg>
        </button>
    </label>
    <input type="number" name="tax_3" id="tax_3" class="w-full px-4 py-2 border rounded-lg">
</div>

<!-- ポップアップウィンドウ（自賠責保険の月割表） -->
<div id="taxPopup3" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl overflow-auto max-h-full">
        <h2 class="text-lg font-semibold mb-4">自賠責保険（月割）</h2>
        <table class="w-full border-collapse">
        <thead>
    <tr>
        <th class="border px-2 py-1" data-month="4">4月</th>
        <th class="border px-2 py-1" data-month="5">5月</th>
        <th class="border px-2 py-1" data-month="6">6月</th>
        <th class="border px-2 py-1" data-month="7">7月</th>
        <th class="border px-2 py-1" data-month="8">8月</th>
        <th class="border px-2 py-1" data-month="9">9月</th>
        <th class="border px-2 py-1" data-month="10">10月</th>
        <th class="border px-2 py-1" data-month="11">11月</th>
        <th class="border px-2 py-1" data-month="12">12月</th>
        <th class="border px-2 py-1" data-month="1">1月</th>
        <th class="border px-2 py-1" data-month="2">2月</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td class="border px-2 py-1"><button onclick="selectTax(400, 'tax_3')">4月 400円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(500, 'tax_3')">5月 500円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(600, 'tax_3')">6月 600円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(700, 'tax_3')">7月 700円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(800, 'tax_3')">8月 800円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(900, 'tax_3')">9月 900円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(1000, 'tax_3')">10月 1000円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(1100, 'tax_3')">11月 1100円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(1200, 'tax_3')">12月 1200円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(1300, 'tax_3')">1月 100円</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(1400, 'tax_3')">2月 200円</button></td>


    </tr>
</tbody>
        </table>
        <button type="button" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-full" onclick="closeTaxPopup('tax_3')">閉じる</button>
    </div>
</div>