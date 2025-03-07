        // 税金の合計
        function calculateTaxTotal() {
            let tax1 = parseFloat(document.getElementById('tax_1')?.value) || 0;
            let tax2 = parseFloat(document.getElementById('tax_2')?.value) || 0;
            let tax3 = parseFloat(document.getElementById('tax_3')?.value) || 0;
            let tax4 = parseFloat(document.getElementById('tax_4')?.value) || 0;
            let tax5 = parseFloat(document.getElementById('tax_5')?.value) || 0;

            let tax_total = tax1 + tax2 + tax3 + tax4 + tax5;
            document.getElementById('tax_total').value = tax_total;
        }

        // 諸費用の合計
        function calculateOverheadTotal() {
            let overhead1 = parseFloat(document.getElementById('overhead_1')?.value) || 0;
            let overhead2 = parseFloat(document.getElementById('overhead_2')?.value) || 0;

            let overhead_total = overhead1 + overhead2;
            document.getElementById('overhead_total').value = overhead_total;
        }

        // 税金と諸費用の合計
        function calculateTaxOverheadTotal() {
            let tax_total = parseFloat(document.getElementById('tax_total')?.value) || 0;
            let overhead_total = parseFloat(document.getElementById('overhead_total')?.value) || 0;

            let tax_overhead_total = tax_total + overhead_total;
            document.getElementById('tax_overhead_total').value = tax_overhead_total;
        }
