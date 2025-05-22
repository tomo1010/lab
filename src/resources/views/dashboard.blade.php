<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <!-- グレーのログアウトボタン -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>


                @php
                $subscription = auth()->user()->subscription('default');
                @endphp

                <div class="mt-6 space-y-6">
                    @if ($subscription && $subscription->active() && !$subscription->cancelled())
                    <!-- 加入中通知 -->
                    <div class="flex items-start bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg shadow-sm">
                        <svg class="w-6 h-6 mr-3 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <div>
                            <p class="font-semibold">プレミアムプランに加入中です！</p>
                            <p class="text-sm mt-1">引き続きすべての機能をご利用いただけます。</p>

                            <!-- サブスクキャンセルボタン -->
                            <form action="/cancel" method="POST" class="mt-3">
                                @csrf
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md font-semibold transition">
                                    サブスクリプションをキャンセルする
                                </button>
                            </form>
                        </div>
                    </div>

                    @elseif ($subscription && $subscription->onGracePeriod())
                    <!-- グレースピリオド通知 -->
                    <div class="flex items-start bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg shadow-sm">
                        <svg class="w-6 h-6 mr-3 text-yellow-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M12 20h.01" />
                        </svg>
                        <div>
                            <p class="font-semibold">プレミアムプランはキャンセル済みです</p>
                            <p class="text-sm mt-1">このプランは <strong>{{ $subscription->ends_at->format('Y年m月d日') }}</strong> に終了予定です。</p>
                            <form action="/resume" method="POST" class="mt-3">
                                @csrf
                                <button
                                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md transition font-semibold text-sm">
                                    キャンセルを取り消す
                                </button>
                            </form>
                        </div>
                    </div>

                    @else
                    <!-- 非加入通知 -->
                    <div class="flex items-start bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg shadow-sm">
                        <svg class="w-6 h-6 mr-3 text-blue-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-3-3v6m9-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold">プレミアムプラン未加入です</p>
                            <p class="text-sm mt-1">すべての機能を利用するにはプランへの加入が必要です。</p>
                            <a href="/subscribe"
                                class="inline-block mt-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold text-sm transition">
                                プレミアムプランに加入
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- サブスク管理リンク -->
                    <div class="text-sm text-gray-600">
                        <a href="{{ url('/billing-portal') }}" class="underline hover:text-blue-700">
                            サブスクリプション管理ページはこちら
                        </a>
                    </div>
                </div>



            </div>
        </div>
    </div>



</x-app-layout>