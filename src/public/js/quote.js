// 合計を計算
function calculateTotal() {
    let price = document.getElementById('price').value;
    let tax = Math.floor(price * 0.10); // 消費税10%
    let total = parseInt(price) + tax;

    document.getElementById('tax_1').value = isNaN(tax) ? 0 : tax;
    document.getElementById('total').value = isNaN(total) ? 0 : total;
}


// ポップアップウインドウ操作（税金）
function openTaxPopup(taxType) {
    const popupId = taxType === 'tax_2' ? 'taxPopup2' : 'taxPopup3';
    document.getElementById(popupId).classList.remove('hidden');
    highlightCurrentMonth(popupId); // ポップアップを開くときに当月をハイライト    


}

function closeTaxPopup(taxType) {
    const popupId = taxType === 'tax_2' ? 'taxPopup2' : 'taxPopup3';
    document.getElementById(popupId).classList.add('hidden');
}

function selectTax(amount, taxType) {
    const inputId = taxType === 'tax_2' ? 'tax_2' : 'tax_3';
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