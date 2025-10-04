<!-- 会社情報（折りたたみ） -->
<div x-data="{ open: false }" class="mt-6 border-t pt-4">

    <!-- トグル見出し -->
    <div class="flex items-center justify-between mb-2 cursor-pointer" @click="open = !open">
        <div class="text-lg font-semibold">会社情報</div>
        <div class="text-xl">
            <span x-show="!open">＋</span>
            <span x-show="open">−</span>
        </div>
    </div>

    <!-- 折りたたみ内容 -->
    <div x-show="open" x-transition>
        <div class="mb-2">
            〒：
            <input type="text" name="company_postal" id="company_postal"
                class="w-24 border rounded px-2 py-1 {{ auth()->check() ? 'bg-gray-100 text-gray-500' : '' }}"
                placeholder="123-4567"
                value="{{ old('company_postal', auth()->check() ? auth()->user()->company_postal : '') }}"
                {{ auth()->check() ? 'readonly' : '' }}>

            <input type="text" name="company_address" id="company_address"
                class="w-full border rounded px-2 py-1 mt-2 {{ auth()->check() ? 'bg-gray-100 text-gray-500' : '' }}"
                placeholder="住所を入力してください"
                value="{{ old('company_address', auth()->check() ? auth()->user()->company_address : '') }}"
                {{ auth()->check() ? 'readonly' : '' }}>

            <input type="text" name="company_name" id="company_name"
                class="w-full border rounded px-2 py-1 mt-2 {{ auth()->check() ? 'bg-gray-100 text-gray-500' : '' }}"
                placeholder="名前を入力してください"
                value="{{ old('company_name', auth()->check() ? auth()->user()->company_name : '') }}"
                {{ auth()->check() ? 'readonly' : '' }}>
        </div>

        <div class="mb-4 flex flex-col md:flex-row md:space-x-4">
            <div class="md:w-1/2">
                TEL：
                <input type="tel" name="company_tel" id="company_tel"
                    class="w-full border rounded px-2 py-1 {{ auth()->check() ? 'bg-gray-100 text-gray-500' : '' }}"
                    placeholder="123-456-7890"
                    value="{{ old('company_tel', auth()->check() ? auth()->user()->company_tel : '') }}"
                    {{ auth()->check() ? 'readonly' : '' }}>
            </div>

            <div class="md:w-1/2 mt-2 md:mt-0">
                FAX：
                <input type="tel" name="company_fax" id="company_fax"
                    class="w-full border rounded px-2 py-1 {{ auth()->check() ? 'bg-gray-100 text-gray-500' : '' }}"
                    placeholder="03-1234-5678"
                    value="{{ old('company_fax', auth()->check() ? auth()->user()->company_fax : '') }}"
                    {{ auth()->check() ? 'readonly' : '' }}>
            </div>
        </div>

        <div class="mb-4 flex flex-col md:flex-row md:space-x-4">
            <div class="md:w-1/2">
                E-Mail：
                <input type="email" name="company_mail" id="company_mail"
                    class="w-full border rounded px-2 py-1 {{ auth()->check() ? 'bg-gray-100 text-gray-500' : '' }}"
                    placeholder="example@example.com" autocomplete="email"
                    value="{{ old('company_mail', auth()->check() ? auth()->user()->company_mail : '') }}"
                    {{ auth()->check() ? 'readonly' : '' }}>
            </div>

            <div class="md:w-1/2 mt-2 md:mt-0">
                URL：
                <input type="text" name="company_url" id="company_url"
                    class="w-full border rounded px-2 py-1 {{ auth()->check() ? 'bg-gray-100 text-gray-500' : '' }}"
                    placeholder="https://example.com" autocomplete="url"
                    value="{{ old('company_url', auth()->check() ? auth()->user()->company_url : '') }}"
                    {{ auth()->check() ? 'readonly' : '' }}>
            </div>

            <div class="md:w-1/2 mt-2 md:mt-0">
                インボイス番号：
                <input type="text" name="company_registration_number" id="company_registration_number"
                    class="w-full border rounded px-2 py-1 {{ auth()->check() ? 'bg-gray-100 text-gray-500' : '' }}"
                    placeholder="T+13桁"
                    value="{{ old('company_registration_number', auth()->check() ? auth()->user()->company_registration_number : '') }}"
                    {{ auth()->check() ? 'readonly' : '' }}>
            </div>
        </div>

        <div class="mb-4">
            <label class="block mb-1">振込先</label>

            <input type="text" name="company_transfer_1" id="company_transfer_1"
                class="w-full border rounded px-2 py-1 mb-2 {{ auth()->check() ? 'bg-gray-100 text-gray-500' : '' }}"
                placeholder="○○銀行 ○○支店　普通　口座 1234567"
                value="{{ old('company_transfer_1', auth()->check() ? auth()->user()->company_transfer_1 : '') }}"
                {{ auth()->check() ? 'readonly' : '' }}>

            <input type="text" name="company_transfer_2" id="company_transfer_2"
                class="w-full border rounded px-2 py-1 mb-2 {{ auth()->check() ? 'bg-gray-100 text-gray-500' : '' }}"
                placeholder="○○銀行 ○○支店　普通　口座 1234567"
                value="{{ old('company_transfer_2', auth()->check() ? auth()->user()->company_transfer_2 : '') }}"
                {{ auth()->check() ? 'readonly' : '' }}>

            <input type="text" name="company_transfer_3" id="company_transfer_3"
                class="w-full border rounded px-2 py-1 {{ auth()->check() ? 'bg-gray-100 text-gray-500' : '' }}"
                placeholder="○○銀行 ○○支店　普通　口座 1234567"
                value="{{ old('company_transfer_3', auth()->check() ? auth()->user()->company_transfer_3 : '') }}"
                {{ auth()->check() ? 'readonly' : '' }}>
        </div>

        <div class="mb-4">
            <label class="block mb-1">備考</label>

            <input type="text" name="company_note" id="company_note"
                class="w-full border rounded px-2 py-1 mb-2 {{ auth()->check() ? 'bg-gray-100 text-gray-500' : '' }}"
                placeholder="営業時間など備考欄"
                value="{{ old('company_note', auth()->check() ? auth()->user()->company_note : '') }}"
                {{ auth()->check() ? 'readonly' : '' }}>
        </div>

        {{-- クッキー保存スクリプト（ゲスト） --}}
        @guest
        <div class="mt-4 text-sm">
            <label class="inline-flex items-center">
                <input type="checkbox" id="save_to_cookie" class="mr-2">
                会社情報を保存
            </label>
        </div>

        <script>
            const fields = [
                'company_postal', 'company_address', 'company_name', 'company_tel', 'company_fax',
                'company_registration_number', 'company_mail', 'company_url',
                'company_transfer_1', 'company_transfer_2', 'company_transfer_3', 'company_note'
            ];

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
        @endguest

    </div>

</div>