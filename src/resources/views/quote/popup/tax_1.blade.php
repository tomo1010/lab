<!-- ポップアップウィンドウ（自動車税月割表） -->
<div id="taxPopup1" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl overflow-auto max-h-full">
        <h2 class="text-lg font-semibold mb-4">自動車税（月割）</h2>

        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border px-2 py-1">排気量</th>
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
                    <td class="border px-2 py-1">1.0L</td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(22900, 'tax_1')">22900</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(20800, 'tax_1')">20800</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(18700, 'tax_1')">18700</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(16600, 'tax_1')">16600</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(14500, 'tax_1')">14500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(12500, 'tax_1')">12500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(10400, 'tax_1')">10400</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(8300, 'tax_1')">8300</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(6200, 'tax_1')">6200</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(4100, 'tax_1')">4100</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(2000, 'tax_1')">2000</button></td>
                </tr>

                <tr>
                    <td class="border px-2 py-1">1.5L</td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(27900, 'tax_1')">27900</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(25400, 'tax_1')">25400</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(22800, 'tax_1')">22800</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(20300, 'tax_1')">20300</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(17700, 'tax_1')">17700</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(15200, 'tax_1')">15200</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(12700, 'tax_1')">12700</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(10100, 'tax_1')">10100</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(7600, 'tax_1')">7600</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(5000, 'tax_1')">5000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(2500, 'tax_1')">2500</button></td>
                </tr>

                <tr>
                    <td class="border px-2 py-1">2.0L</td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(33000, 'tax_1')">33000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(30000, 'tax_1')">30000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(27000, 'tax_1')">27000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(24000, 'tax_1')">24000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(21000, 'tax_1')">21000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(18000, 'tax_1')">18000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(15000, 'tax_1')">15000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(12000, 'tax_1')">12000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(9000, 'tax_1')">9000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(6000, 'tax_1')">6000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(3000, 'tax_1')">3000</button></td>
                </tr>

                <tr>
                    <td class="border px-2 py-1">2.5L</td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(38000, 'tax_1')">38000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(34500, 'tax_1')">34500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(31000, 'tax_1')">31000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(27500, 'tax_1')">27500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(24000, 'tax_1')">24000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(20500, 'tax_1')">20500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(17000, 'tax_1')">17000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(13500, 'tax_1')">13500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(10000, 'tax_1')">10000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(6500, 'tax_1')">6500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(3000, 'tax_1')">3000</button></td>
                </tr>

                <tr>
                    <td class="border px-2 py-1">3.0L</td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(43500, 'tax_1')">43500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(39500, 'tax_1')">39500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(35500, 'tax_1')">35500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(31500, 'tax_1')">31500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(27500, 'tax_1')">27500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(23500, 'tax_1')">23500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(19500, 'tax_1')">19500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(15500, 'tax_1')">15500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(11500, 'tax_1')">11500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(7500, 'tax_1')">7500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(3500, 'tax_1')">3500</button></td>
                </tr>

                <tr>
                    <td class="border px-2 py-1">3.5L</td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(49500, 'tax_1')">49500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(45000, 'tax_1')">45000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(40500, 'tax_1')">40500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(36000, 'tax_1')">36000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(31500, 'tax_1')">31500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(27000, 'tax_1')">27000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(22500, 'tax_1')">22500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(18000, 'tax_1')">18000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(13500, 'tax_1')">13500</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(9000, 'tax_1')">9000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(4500, 'tax_1')">4500</button></td>
                </tr>

                <tr>
                    <td class="border px-2 py-1">4.0L</td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(57000, 'tax_1')">57000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(52000, 'tax_1')">52000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(47000, 'tax_1')">47000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(42000, 'tax_1')">42000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(37000, 'tax_1')">37000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(32000, 'tax_1')">32000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(27000, 'tax_1')">27000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(22000, 'tax_1')">22000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(17000, 'tax_1')">17000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(12000, 'tax_1')">12000</button></td>
                    <td class="border px-2 py-1"><button type="button" onclick="selectTax(6000, 'tax_1')">6000</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button"
            class="mt-4 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-full"
            onclick="closeTaxPopup('tax_1')">
            閉じる
        </button>
    </div>
</div>