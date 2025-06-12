<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">請求書印刷</h2>
    </x-slot>


    <livewire:invoice-update-form :invoice="$invoice" />


    <!-- ログインユーザの制限処理 -->

    @php
    $limit = auth()->user()->limit();
    $count = auth()->user()->invoices()->count(); //ページ別の修正
    $isOverLimit = $count >= $limit;
    @endphp

    <!-- データ保存一覧　-->
    @auth
    <x-save-list :items="$invoices" itemName="invoice" :is-over-limit="$isOverLimit" routePrefix="invoice" />
    @endauth





    <script>
        const fields = ['postal', 'address', 'name', 'tel', 'fax', 'mail', 'url', 'transfer_1', 'transfer_2', 'transfer_3'];
        fields.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.addEventListener('input', function() {
                    if (document.getElementById('save_to_cookie').checked) {
                        setCookie(field, this.value, 30);
                    }
                });
            }
        });

        window.addEventListener('DOMContentLoaded', () => {
            fields.forEach(field => {
                const value = getCookie(field);
                if (value) {
                    document.getElementById(field).value = value;
                }
            });

            if (fields.some(field => getCookie(field))) {
                document.getElementById('save_to_cookie').checked = true;
            }
        });

        document.getElementById('save_to_cookie').addEventListener('change', function() {
            if (this.checked) {
                fields.forEach(field => {
                    const value = document.getElementById(field).value;
                    setCookie(field, value, 30);
                });
                alert('発信者情報をクッキーに保存しました。');
            } else {
                fields.forEach(field => deleteCookie(field));
                alert('クッキーから発信者情報を削除しました。');
            }
        });

        function setCookie(name, value, days) {
            const expires = new Date(Date.now() + days * 864e5).toUTCString();
            document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/`;
        }

        function getCookie(name) {
            return document.cookie.split('; ').reduce((r, v) => {
                const parts = v.split('=');
                return parts[0] === name ? decodeURIComponent(parts[1]) : r;
            }, '');
        }

        function deleteCookie(name) {
            setCookie(name, '', -1);
        }
    </script>
</x-app-layout>