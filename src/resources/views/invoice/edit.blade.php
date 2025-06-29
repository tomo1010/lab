<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">請求書印刷</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6">

        <livewire:invoice-update-form :invoice="$invoice" wire:key="invoice-update" />

    </div>

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

</x-app-layout>