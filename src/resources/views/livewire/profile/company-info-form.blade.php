<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            発行者（会社）情報
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            請求書に表示される発行者情報を編集できます。
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
                <x-input-label for="postal" value="郵便番号" />
                <x-text-input id="postal" type="text" class="mt-1 block w-full" wire:model.defer="postal" />
            </div>
            <div class="md:w-2/3 mt-4 md:mt-0">
                <x-input-label for="address" value="住所" />
                <x-text-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="address" />
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:space-x-4">
            <div class="md:w-1/2">
                <x-input-label for="tel" value="TEL" />
                <x-text-input id="tel" type="text" class="mt-1 block w-full" wire:model.defer="tel" />
            </div>
            <div class="md:w-1/2 mt-4 md:mt-0">
                <x-input-label for="fax" value="FAX" />
                <x-text-input id="fax" type="text" class="mt-1 block w-full" wire:model.defer="fax" />
            </div>
        </div>

        <div>
            <x-input-label for="company_mail" value="E-Mail" />
            <x-text-input id="company_mail" type="email" class="mt-1 block w-full" wire:model.defer="company_mail" />
        </div>

        <div>
            <x-input-label for="url" value="URL" />
            <x-text-input id="url" type="url" class="mt-1 block w-full" wire:model.defer="url" />
        </div>

        <div>
            <x-input-label for="registration_number" value="登録番号（インボイス）" />
            <x-text-input id="registration_number" type="text" class="mt-1 block w-full" wire:model.defer="registration_number" />
        </div>

        <div>
            <x-input-label value="振込先（最大3つ）" />
            <x-text-input type="text" class="mt-1 block w-full" wire:model.defer="transfer_1" />
            <x-text-input type="text" class="mt-1 block w-full" wire:model.defer="transfer_2" />
            <x-text-input type="text" class="mt-1 block w-full" wire:model.defer="transfer_3" />
        </div>

        <div>
            <x-input-label for="note" value="メモ" />
            <textarea id="note" rows="4" wire:model.defer="note" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
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