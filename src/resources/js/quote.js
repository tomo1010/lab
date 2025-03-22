        // 諸費用の合計
        function calculateOverheadTotal() {
            let tax1 = parseFloat(document.getElementById('tax_1')?.value) || 0;
            let tax2 = parseFloat(document.getElementById('tax_2')?.value) || 0;
            let tax3 = parseFloat(document.getElementById('tax_3')?.value) || 0;
            let tax4 = parseFloat(document.getElementById('tax_4')?.value) || 0;
            let tax5 = parseFloat(document.getElementById('tax_5')?.value) || 0;
            let overhead1 = parseFloat(document.getElementById('overhead_1')?.value) || 0;
            let overhead11 = parseFloat(document.getElementById('overhead_11')?.value) || 0;

            let overhead_total = tax1 + tax2 + tax3 + tax4 + tax5 + overhead1 + overhead11;
            document.getElementById('overhead_total').value = overhead_total;
        }

        // オプションの合計
        function calculateOptionTotal() {
            let option1 = parseFloat(document.getElementById('option_1')?.value) || 0;
            let option2 = parseFloat(document.getElementById('option_2')?.value) || 0;
            let option3 = parseFloat(document.getElementById('option_3')?.value) || 0;
            let option4 = parseFloat(document.getElementById('option_4')?.value) || 0;
            let option5 = parseFloat(document.getElementById('option_5')?.value) || 0;

            let option_total = option1 + option2 + option3 + option4 + option5;
            document.getElementById('option_total').value = option_total;
        }


        // 合計金額
       function calculateTotal() {
            let price = parseFloat(document.getElementById('price')?.value) || 0;
            let overhead_total = parseFloat(document.getElementById('overhead_total')?.value) || 0;
            let option_total = parseFloat(document.getElementById('option_total')?.value) || 0;

            let total = price + overhead_total + option_total;
            document.getElementById('total').value = total;

            calculateTaxOverheadTotal();
        }


        document.addEventListener("DOMContentLoaded", function () {
            let inputs = ['price', 'tax_1', 'tax_2', 'tax_3', 'tax_4', 'tax_5', 'overhead_1', 'overhead_11', 'option_1', 'option_2', 'option_3', 'option_4', 'option_5'];
            inputs.forEach(id => {
                let element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', function () {
                        if (id.startsWith('overhead_')) {
                            calculateOverheadTotal();
                        } else if (id.startsWith('option_')) {
                            calculateOptionTotal();
                        }

                        if (id === 'price') {
                            updatePriceDisplay(); // 金額を万円に変換
                        }

                        calculateTotal();
                    });
                }
            });
        });


        // 支払い総額
        function calculatePayment() {
            let total = parseFloat(document.getElementById('total')?.value) || 0;
            let trade_price = parseFloat(document.getElementById('trade_price')?.value) || 0;
            let discount = parseFloat(document.getElementById('discount')?.value) || 0;
            
            let payment = total - trade_price - discount;
            document.getElementById('payment').value = payment;
        }
        
        document.addEventListener("DOMContentLoaded", function () {
            let inputs = ['price', 'tax_1', 'tax_2', 'tax_3', 'tax_4', 'tax_5', 'overhead_1', 'overhead_11', 'option_1', 'option_2', 'option_3', 'option_4', 'option_5', 'trade_price', 'discount'];
            inputs.forEach(id => {
            let element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', calculatePayment);
            }
            });
        });


        ////保存・PDFボタン処理
        //function setFormAction(action) {
        //const form = document.getElementById('quoteForm');
        //if (action === 'save') {
        //    form.action = "{{ route('quotes.store') }}";
        //} else if (action === 'pdf') {
        //    form.action = "{{ route('quotes.createPdf') }}";
        //}
        //document.getElementById('action').value = action;
        //}




// ポップアップウインドウ操作（税金）
function openTaxPopup(taxType) {
    const popupId = `taxPopup${taxType.replace('tax_', '')}`;
    document.getElementById(popupId).classList.remove('hidden');
    highlightCurrentMonth(popupId); // ポップアップを開くときに当月をハイライト    
}

function closeTaxPopup(taxType) {
    const popupId = `taxPopup${taxType.replace('tax_', '')}`;
    document.getElementById(popupId).classList.add('hidden');
}

function selectTax(amount, taxType) {
    const inputId = taxType;
    document.getElementById(inputId).value = amount;
    closeTaxPopup(taxType); // クリック後ポップアップを閉じる
}


function highlightCurrentMonth(popupId) {
    // 現在の月を取得（1月 = 1, 2月 = 2, ..., 12月 = 12）
    const currentMonth = new Date().getMonth() + 1;
    
    // すべてのthのハイライトをリセット
    document.querySelectorAll(`#${popupId} th[data-month]`).forEach(th => {
        th.classList.remove('bg-yellow-300', 'text-black');
    });

    // 該当するthにハイライトを適用
    const currentTh = document.querySelector(`#${popupId} th[data-month="${currentMonth}"]`);
    if (currentTh) {
        currentTh.classList.add('bg-yellow-300', 'text-black');
    }
    
}

// ポップアップから選択しても他の合計関数が動くようにする処理
function selectTax(amount, taxType) {
    const input = document.getElementById(taxType);
    if (input) {
        input.value = amount;

        // `input` イベントを手動で発火させる
        input.dispatchEvent(new Event('input', { bubbles: true }));

        // フォーム送信を防ぐ
        if (event) {
            event.preventDefault();
        }
    }
    closeTaxPopup(taxType);
}



// 車検日から残り月数を計算
document.addEventListener('DOMContentLoaded', function() {
    function calculateMonths() {
        const yearSelect = document.getElementById('inspection_year');
        const monthSelect = document.getElementById('inspection_month');
        const resultSpan = document.getElementById('inspection_result');

        const selectedYearOption = yearSelect.options[yearSelect.selectedIndex];
        const selectedYear = selectedYearOption.dataset.year ? parseInt(selectedYearOption.dataset.year) : null;
        const selectedMonth = monthSelect.value ? parseInt(monthSelect.value) : null;

        if (selectedYear && selectedMonth) {
            const today = new Date();
            const selectedDate = new Date(selectedYear, selectedMonth - 1, 1); // 1日を基準にする

            const diffInMonths = (selectedDate.getFullYear() - today.getFullYear()) * 12 + (selectedDate.getMonth() - today.getMonth());

            if (diffInMonths >= 0) {
                resultSpan.textContent = `残り${diffInMonths}ヶ月`;
            } else {
                resultSpan.textContent = "過去の日付";
            }
        } else {
            resultSpan.textContent = "";
        }
    }

    document.getElementById('inspection_year').addEventListener('change', calculateMonths);
    document.getElementById('inspection_month').addEventListener('change', calculateMonths);
});


// 金額を万円に変換

    function updatePriceDisplay() {
        const priceInput = document.getElementById('price');
        const convertedDisplay = document.getElementById('price_converted');

        const value = parseFloat(priceInput.value);
        if (!isNaN(value)) {
            const manYen = (value / 10000).toFixed(1).replace(/\.0$/, ''); // 少数点0は消す
            convertedDisplay.textContent = `${manYen}万円`;
        } else {
            convertedDisplay.textContent = '';
        }
    }