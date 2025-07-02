<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">請求書 詳細</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-8 border rounded shadow mt-6 text-sm">
        <div class="text-2xl font-bold text-center mb-6 border-y py-2">請求書</div>

        <div class="mb-4 text-right text-xs text-gray-600">
            発行日：{{ $invoice->date }}<br>
            明細枚数：{{ $invoice->page_count }}枚
        </div>

        <div class="mb-4">
            <label class="block font-semibold">請求先：</label>
            {{ $invoice->client }} {{ $invoice->to_suffix }}<br>
            {{ $invoice->client_address }}
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">請求内容：</label>
            <div class="space-y-2">
                @foreach ($invoice->items as $item)
                <div class="flex justify-between border-b pb-1">
                    <span>{{ $item['name'] }}</span>
                    <span>{{ number_format($item['price']) }}円</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="mb-4 text-right font-bold">
            合計金額：{{ number_format($invoice->total) }}円
        </div>

        <div class="mb-4">
            <label class="block font-semibold">備考：</label>
            <p class="whitespace-pre-wrap">{{ $invoice->message }}</p>
        </div>

        {{-- 発行者情報も必要であればここに表示 --}}
        <!-- 会社情報（折りたたみ・Userテーブルから表示） -->
        @php $user = $invoice->user; @endphp

        <div x-data="{ open: true }" class="mt-6 border-t pt-4">

            <div class="flex items-center justify-between mb-2 cursor-pointer" @click="open = !open">
                <div class="text-lg font-semibold">発行者（会社情報）</div>
                <div class="text-xl">
                    <span x-show="!open">＋</span>
                    <span x-show="open">−</span>
                </div>
            </div>

            <div x-show="open" x-transition class="text-sm space-y-3 text-gray-700">
                <div>
                    <strong>〒</strong> {{ $user->postal }}<br>
                    <strong>住所：</strong> {{ $user->address }}<br>
                    <strong>会社名：</strong> {{ $user->company_name }}
                </div>

                <div class="flex flex-col md:flex-row md:space-x-4">
                    <div class="md:w-1/2">
                        <strong>TEL：</strong> {{ $user->tel }}
                    </div>
                    <div class="md:w-1/2">
                        <strong>FAX：</strong> {{ $user->fax }}
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:space-x-4">
                    <div class="md:w-1/2">
                        <strong>E-Mail：</strong> {{ $user->company_mail }}
                    </div>
                    <div class="md:w-1/2">
                        <strong>URL：</strong>
                        <a href="{{ $user->url }}" class="text-blue-600 hover:underline" target="_blank">{{ $user->url }}</a>
                    </div>
                    <div class="md:w-1/2">
                        <strong>インボイス番号：</strong> {{ $user->registration_number }}
                    </div>
                </div>

                <div>
                    <strong>振込先１：</strong> {{ $user->transfer_1 }}<br>
                    @if ($user->transfer_2)<strong>振込先２：</strong> {{ $user->transfer_2 }}<br>@endif
                    @if ($user->transfer_3)<strong>振込先３：</strong> {{ $user->transfer_3 }}<br>@endif
                </div>

                <div>
                    <strong>備考：</strong> {{ $user->note }}
                </div>
            </div>
        </div>

    </div>
</x-app-layout>