<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            発行者（会社）情報
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            各ページに表示される会社情報を編集できます。
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if (session()->has('success'))
        <p class="text-sm text-green-600">{{ session('success') }}</p>
        @endif

        <div>
            <x-input-label for="company_name" value="会社名" />
            <x-text-input id="company_name" type="text" class="mt-1 block w-full" wire:model.defer="company_name" />
        </div>

        <div class="flex flex-col md:flex-row md:space-x-4">
            <div class="md:w-1/3">
                <x-input-label for="company_postal" value="郵便番号" />
                <x-text-input id="company_postal" type="text" class="mt-1 block w-full" wire:model.defer="company_postal" />
            </div>
            <div class="md:w-2/3 mt-4 md:mt-0">
                <x-input-label for="company_address" value="住所" />
                <x-text-input id="company_address" type="text" class="mt-1 block w-full" wire:model.defer="company_address" />
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:space-x-4">
            <div class="md:w-1/2">
                <x-input-label for="company_tel" value="TEL" />
                <x-text-input id="company_tel" type="text" class="mt-1 block w-full" wire:model.defer="company_tel" />
            </div>
            <div class="md:w-1/2 mt-4 md:mt-0">
                <x-input-label for="company_handyphone" value="携帯電話" />
                <x-text-input id="company_handyphone" type="text" class="mt-1 block w-full" wire:model.defer="company_handyphone" />
            </div>
            <div class="md:w-1/2 mt-4 md:mt-0">
                <x-input-label for="company_fax" value="FAX" />
                <x-text-input id="company_fax" type="text" class="mt-1 block w-full" wire:model.defer="company_fax" />
            </div>
        </div>

        <div>
            <x-input-label for="company_mail" value="E-Mail" />
            <x-text-input id="company_mail" type="email" class="mt-1 block w-full" wire:model.defer="company_mail" />
        </div>

        <div>
            <x-input-label for="company_url" value="URL" />
            <x-text-input id="company_url" type="url" class="mt-1 block w-full" wire:model.defer="company_url" />
        </div>

        <div>
            <x-input-label for="company_registration_number" value="登録番号（インボイス）" />
            <x-text-input id="company_registration_number" type="text" class="mt-1 block w-full" wire:model.defer="company_registration_number" />
        </div>

        <div>
            <x-input-label value="振込先（最大3つ）" />
            <x-text-input type="text" class="mt-1 block w-full" wire:model.defer="company_transfer_1" />
            <x-text-input type="text" class="mt-1 block w-full" wire:model.defer="company_transfer_2" />
            <x-text-input type="text" class="mt-1 block w-full" wire:model.defer="company_transfer_3" />
        </div>

        <div>
            <x-input-label for="company_note" value="メモ" />
            <textarea id="company_note" rows="4" wire:model.defer="company_note" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button wire:click="save">保存</x-primary-button>

            {{-- メッセージ表示 --}}
            <div
                x-data="{ show: false }"
                x-on:show-message.window="show = true; setTimeout(() => show = false, 2000)"
                x-show="show"
                x-transition
                class="text-sm text-gray-600">
                保存されました
            </div>
        </div>
</section>