<script>

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







</script>