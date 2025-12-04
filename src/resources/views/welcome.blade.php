<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            HOME
        </h2>
    </x-slot>

    {{-- 既存のスタイル（必要なら残す） --}}
    <style>
        .fax-container { font-size: 12pt; padding: 2rem; background-color: #fff; border: 1px solid #ddd; margin-top: 1rem; }
        .title { text-align: center; font-size: 20pt; font-weight: bold; border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 10px 0; margin-bottom: 20px; }
        .input-text { width: 100%; padding: 5px; font-size: 12pt; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .textarea   { width: 100%; height: 60px; font-size: 12pt; padding: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .footer { margin-top: 30px; border-top: 1px solid #000; padding-top: 10px; }
        .submit-btn { margin-top: 30px; text-align: center; }
        .submit-btn button { padding: 10px 20px; }
        .right-align-small { text-align: right; font-size: 10pt; color: #555; margin-bottom: 0.25rem; }
        .left-align { text-align: left; margin-top: 1rem; margin-bottom: 1rem; }
    </style>

    {{-- カード共通：高さ/枠/ホバー/フォーカスを統一 --}}
    <style>
        .app-card{
            display:flex; align-items:flex-start; gap:.75rem;
            border:1px solid #e5e7eb; border-radius:1rem; background:#fff;
            padding:1.25rem; height:100%;
            transition: box-shadow .2s ease, transform .2s ease;
            text-decoration: none;
        }
        .app-card:hover{ box-shadow:0 8px 20px rgba(0,0,0,.06); transform:translateY(-1px); }
        .app-card:focus-visible{ outline:2px solid #60a5fa; outline-offset:2px; }
        .app-card-title{ font-weight:600; color:#1f2937; }
        .app-card-desc{ font-size:.75rem; color:#6b7280; margin-top:.25rem; }
        /* Font Awesome用に調整 */
        .app-icon{ font-size:1.25rem; line-height:1.5rem; color:#374151; flex:0 0 auto; margin-top:.125rem; }
    </style>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-10">

        {{-- ヘッダー・導入 --}}
        <section>
            <div class="rounded-2xl border border-gray-200 bg-white p-6">
                <h3 class="text-lg font-semibold text-gray-800">クルマ屋ラボ</h3>
                <p class="mt-1 text-sm text-gray-600">
                    クイック見積り・タイヤ計算機・クイック請求・FAX送付状・施工証明書印刷・ラベル印刷など、各機能へ移動できます。
                </p>
            </div>
        </section>

        {{-- 業務ツール --}}
        <section>
            <h4 class="mb-3 text-sm font-semibold text-gray-600">業務ツール</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                {{-- クイック見積り --}}
                <a href="{{ route('quote.index') }}" class="app-card">
                    <i class="fa-solid fa-file-lines app-icon" aria-hidden="true"></i>
                    <div class="flex-1">
                        <div class="app-card-title">クイック見積り</div>
                        <div class="app-card-desc">新規作成／PDF出力</div>
                    </div>
                </a>

                {{-- タイヤ計算機 --}}
                <a href="{{ route('tirecalc.index') }}" class="app-card">
                    <i class="fa-solid fa-calculator app-icon" aria-hidden="true"></i>
                    <div class="flex-1">
                        <div class="app-card-title">タイヤ計算機</div>
                        <div class="app-card-desc">原価入力→粗利→工賃→合計／PDF出力</div>
                    </div>
                </a>

                {{-- 年齢計算機 --}}
                <a href="{{ route('agecalc.index') }}" class="app-card">
                    <i class="fa-solid fa-calendar-days app-icon" aria-hidden="true"></i>
                    <div class="flex-1">
                        <div class="app-card-title">年齢計算機</div>
                        <div class="app-card-desc">自動車保険用の年齢計算</div>
                    </div>
                </a>

                {{-- クイック請求書 --}}
                <a href="{{ route('invoice.index') }}" class="app-card">
                    <i class="fa-solid fa-file-invoice-dollar app-icon" aria-hidden="true"></i>
                    <div class="flex-1">
                        <div class="app-card-title">クイック請求書</div>
                        <div class="app-card-desc">新規作成／PDF出力</div>
                    </div>
                </a>

            </div>
        </section>

        {{-- 印刷ツール（グリッドに統一） --}}
        <section>
            <h4 class="mb-3 text-sm font-semibold text-gray-600">印刷ツール</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                {{-- FAX送付状（汎用） --}}
                <a href="{{ route('fax.send') }}" class="app-card">
                    <i class="fa-solid fa-fax app-icon" aria-hidden="true"></i>
                    <div class="flex-1">
                        <div class="app-card-title">FAX送付状（汎用）</div>
                        <div class="app-card-desc">新規作成／PDF出力</div>
                    </div>
                </a>

                {{-- FAX送付状（車両入替え） --}}
                <a href="{{ route('fax.change') }}" class="app-card">
                    <i class="fa-solid fa-right-left app-icon" aria-hidden="true"></i>
                    <div class="flex-1">
                        <div class="app-card-title">FAX送付状（車両入替え）</div>
                        <div class="app-card-desc">新規作成／PDF出力</div>
                    </div>
                </a>

                {{-- ラベル印刷 --}}
                <a href="{{ route('label.index') }}" class="app-card">
                    <i class="fa-solid fa-tag app-icon" aria-hidden="true"></i>
                    <div class="flex-1">
                        <div class="app-card-title">ラベル印刷</div>
                        <div class="app-card-desc">新規作成</div>
                    </div>
                </a>

                {{-- 施工証明書（アイコン追加） --}}
                <a href="{{ route('pdf.construction') }}" class="app-card">
                    <i class="fa-solid fa-shield-halved app-icon" aria-hidden="true"></i>
                    <div class="flex-1">
                        <div class="app-card-title">施工証明書</div>
                        <div class="app-card-desc">ボディコーティング施工証明書発行</div>
                    </div>
                </a>

            </div>
        </section>

        {{-- 比較・販促 --}}
        <section>
            <h4 class="mb-3 text-sm font-semibold text-gray-600">比較・販促</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                <a href="{{ route('car.index') }}" class="app-card">
                    <i class="fa-solid fa-car-side app-icon" aria-hidden="true"></i>
                    <div class="flex-1">
                        <div class="app-card-title">クルマ比較サイト</div>
                        <div class="app-card-desc">車種・スペック比較</div>
                    </div>
                </a>

                <a href="{{ route('baby.index') }}" class="app-card">
                    <i class="fa-solid fa-baby-carriage app-icon" aria-hidden="true"></i>
                    <div class="flex-1">
                        <div class="app-card-title">Baby in Car</div>
                        <div class="app-card-desc">赤ちゃんが乗ってますステッカー</div>
                    </div>
                </a>

            </div>
        </section>

        {{-- その他 --}}
        <section>
            <h4 class="mb-3 text-sm font-semibold text-gray-600">その他</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                <a href="https://kurumayalabo.com/" class="app-card">
                    <i class="fa-solid fa-book-open app-icon" aria-hidden="true"></i>
                    <div class="flex-1">
                        <div class="app-card-title">使い方・マニュアル</div>
                        <div class="app-card-desc">操作手順・よくある質問</div>
                    </div>
                </a>

                <a href="https://kurumayalabo.com/news/" class="app-card">
                    <i class="fa-solid fa-bullhorn app-icon" aria-hidden="true"></i>
                    <div class="flex-1">
                        <div class="app-card-title">お知らせ／障害情報</div>
                        <div class="app-card-desc">アップデートや不具合情報</div>
                    </div>
                </a>

            </div>
        </section>

        {{-- サブスクリプション --}}
        <section>
            @auth
                <h4 class="mb-3 text-sm font-semibold text-gray-600">アカウント・サブスク</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    <a href="{{ url('/subscribe') }}" class="app-card">
                        <i class="fa-solid fa-crown app-icon" aria-hidden="true"></i>
                        <div class="flex-1">
                            <div class="app-card-title">サブスクに加入</div>
                            <div class="app-card-desc">Checkout（Stripe）へ</div>
                        </div>
                    </a>

                    <a href="{{ url('/billing-portal') }}" class="app-card">
                        <i class="fa-regular fa-credit-card app-icon" aria-hidden="true"></i>
                        <div class="flex-1">
                            <div class="app-card-title">請求・支払い管理</div>
                            <div class="app-card-desc">カード変更／解約・再開</div>
                        </div>
                    </a>

                </div>
            @endauth

            @guest
                <div class="rounded-2xl border border-gray-200 bg-white p-5 text-center">
                    <p class="text-sm text-gray-700">
                        サブスク加入や保存機能のご利用にはログインが必要です。
                        <a href="{{ route('login') }}" class="underline hover:text-gray-900">ログイン</a> /
                        <a href="{{ route('register') }}" class="underline hover:text-gray-900">新規登録</a>
                    </p>
                </div>
            @endguest
        </section>

    </div>
</x-app-layout>
