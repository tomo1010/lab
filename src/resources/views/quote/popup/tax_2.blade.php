<!-- ポップアップウィンドウ（重量税月割表） -->
<div id="taxPopup2" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl overflow-auto max-h-full">
        <h2 class="text-lg font-semibold mb-4">重量税</h2>                                                                
        <table class='w-full border-collapse'>
            <tr>
                <th class="border px-2 py-1" rowspan='3'>車両重量</th>
                <th class="border px-2 py-1" colspan='4'>3年自家用（新車新規登録）</th>
            </tr>
            <tr>
                <th class="border px-2 py-1" colspan='1'>エコカー</th>
                <th class="border px-2 py-1" colspan='2'>エコカー（本則税率から軽減）</th>
                <th class="border px-2 py-1">エコカー外</th>
            </tr>
            <tr>
                <th class="border px-2 py-1">本則税率</th>
                <th class="border px-2 py-1">50％減</th>
                <th class="border px-2 py-1">25％減</th>
                <th class="border px-2 py-1">軽減なし</th>
            </tr>
            <tr>
                <td class='border px-2 py-1'>0.5t以下</td>
                <td class="border px-2 py-1"><button onclick="selectTax(7500, 'tax_2')">7500</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(3700, 'tax_2')">3700</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(5600, 'tax_2')">5600</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(12300, 'tax_2')">12300</button></td>
            </tr>
            <tr>
                <td class='border px-2 py-1'>～1t</td>
                <td class="border px-2 py-1"><button onclick="selectTax(15000, 'tax_2')">15000</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(7500, 'tax_2')">7500</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(11200, 'tax_2')">11200</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(24600, 'tax_2')">24600</button></td>
            </tr>
            <tr>
                <td class='border px-2 py-1'>～1.5t</td>
                <td class="border px-2 py-1"><button onclick="selectTax(22500, 'tax_2')">22500</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(11200, 'tax_2')">11200</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(16800, 'tax_2')">16800</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(36900, 'tax_2')">36900</button></td>
            </tr>
            <tr>
                <td class='border px-2 py-1'>～2t</td>
                <td class="border px-2 py-1"><button onclick="selectTax(30000, 'tax_2')">30000</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(15000, 'tax_2')">15000</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(22500, 'tax_2')">22500</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(49200, 'tax_2')">49200</button></td>
            </tr>
            <tr>
                <td class='border px-2 py-1'>～2.5t</td>
                <td class="border px-2 py-1"><button onclick="selectTax(37500, 'tax_2')">37500</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(18700, 'tax_2')">18700</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(28100, 'tax_2')">28100</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(61500, 'tax_2')">61500</button></td>
            </tr>
            <tr>
                <td class='border px-2 py-1'>～3t</td>
                <td class="border px-2 py-1"><button onclick="selectTax(45000, 'tax_2')">45000</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(22500, 'tax_2')">22500</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(33700, 'tax_2')">33700</button></td>
                <td class="border px-2 py-1"><button onclick="selectTax(73800, 'tax_2')">73800</button></td>
            </tr>
        </table>

                    </br>

                    <table class='w-full border-collapse'>
    <tr>
        <th class="border px-2 py-1" rowspan='3'>車両重量</th>
        <th class="border px-2 py-1" colspan='4'>2年自家用（継続検査、中古車新規登録）</th>
    </tr>
    <tr>
        <th class="border px-2 py-1" colspan='1'>エコカー</th>
        <th class="border px-2 py-1" colspan='3'>エコカー外</th>
    </tr>
    <tr>
        <th class="border px-2 py-1">本則税率</th>
        <th class="border px-2 py-1">右以外</th>
        <th class="border px-2 py-1">13年経過</th>
        <th class="border px-2 py-1">18年経過</th>
    </tr>
    <tr>
        <td class="border px-2 py-1">0.5t以下</td>
        <td class="border px-2 py-1"><button onclick="selectTax(5000, 'tax_2')">5000</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(8200, 'tax_2')">8200</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(11400, 'tax_2')">11400</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(12600, 'tax_2')">12600</button></td>
    </tr>
    <tr>
        <td class="border px-2 py-1">～1t</td>
        <td class="border px-2 py-1"><button onclick="selectTax(10000, 'tax_2')">10000</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(16400, 'tax_2')">16400</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(22800, 'tax_2')">22800</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(25200, 'tax_2')">25200</button></td>
    </tr>
    <tr>
        <td class="border px-2 py-1">～1.5t</td>
        <td class="border px-2 py-1"><button onclick="selectTax(15000, 'tax_2')">15000</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(24600, 'tax_2')">24600</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(34200, 'tax_2')">34200</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(37800, 'tax_2')">37800</button></td>
    </tr>
    <tr>
        <td class="border px-2 py-1">～2t</td>
        <td class="border px-2 py-1"><button onclick="selectTax(20000, 'tax_2')">20000</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(32800, 'tax_2')">32800</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(45600, 'tax_2')">45600</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(50400, 'tax_2')">50400</button></td>
    </tr>
    <tr>
        <td class="border px-2 py-1">～2.5t</td>
        <td class="border px-2 py-1"><button onclick="selectTax(25000, 'tax_2')">25000</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(41000, 'tax_2')">41000</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(57000, 'tax_2')">57000</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(63000, 'tax_2')">63000</button></td>
    </tr>
    <tr>
        <td class="border px-2 py-1">～3t</td>
        <td class="border px-2 py-1"><button onclick="selectTax(30000, 'tax_2')">30000</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(49200, 'tax_2')">49200</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(68400, 'tax_2')">68400</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(75600, 'tax_2')">75600</button></td>
    </tr>
</table>


                    </br>

                    <table class='w-full border-collapse'>
    <tr>
        <th class="border px-2 py-1" rowspan='3'></th>
        <th class="border px-2 py-1" colspan='5'>新車新規登録（軽自動車）</th>
    </tr>
    <tr>
        <th class="border px-2 py-1" colspan='1'>エコカー</th>
        <th class="border px-2 py-1" colspan='3'>エコカー（本則税率から軽減）</th>
        <th class="border px-2 py-1">エコカー外</th>
    </tr>
    <tr>
        <th class="border px-2 py-1">本則税率</th>
        <th class="border px-2 py-1">75％減</th>
        <th class="border px-2 py-1">50％減</th>
        <th class="border px-2 py-1">25％減</th>
        <th class="border px-2 py-1">軽減なし</th>
    </tr>
    <tr>
        <td class="border px-2 py-1">3年自家用</td>
        <td class="border px-2 py-1"><button onclick="selectTax(7500, 'tax_2')">7500</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(1800, 'tax_2')">1800</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(3700, 'tax_2')">3700</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(5600, 'tax_2')">5600</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(9900, 'tax_2')">9900</button></td>
    </tr>
    <tr>
        <td class="border px-2 py-1">2年自家用</td>
        <td class="border px-2 py-1"><button onclick="selectTax(5000, 'tax_2')">5000</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(1200, 'tax_2')">1200</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(2500, 'tax_2')">2500</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(3700, 'tax_2')">3700</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(6600, 'tax_2')">6600</button></td>
    </tr>
</table>


                    </br>

                    <table class='w-full border-collapse'>
    <tr>
        <th class="border px-2 py-1" rowspan='3'></th>
        <th class="border px-2 py-1" colspan='4'>継続検査、中古車新規登録（軽自動車）</th>
    <tr>    
        <th class="border px-2 py-1">エコカー</th>
        <th class="border px-2 py-1" colspan='3'>エコカー外</th>
    </tr>
    <tr>
        <th class="border px-2 py-1">本則税率</th>
        <th class="border px-2 py-1">右以外</th>
        <th class="border px-2 py-1">13年経過</th>
        <th class="border px-2 py-1">18年経過</th>
    </tr>
    <tr>
        <td class="border px-2 py-1">2年自家用</td>
        <td class="border px-2 py-1"><button onclick="selectTax(5000, 'tax_2')">5000</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(6600, 'tax_2')">6600</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(8200, 'tax_2')">8200</button></td>
        <td class="border px-2 py-1"><button onclick="selectTax(8800, 'tax_2')">8800</button></td>
    </tr>
</table>





                                <button type="button" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-full" onclick="closeTaxPopup('tax_2')">閉じる</button>
                            </div>
                        </div>