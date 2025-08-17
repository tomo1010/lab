<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>御見積書</title>
    <style>
        /* 日本語フォントの設定 (laravel-mpdfで日本語を表示させるための重要設定) */
        body {
            font-family: 'notosansjp', 'ipaexg', 'ipag', 'sans-serif';
            font-size: 10pt;
            color: #333;
            margin: 30px 40px;
            /* 上下左右の余白を調整 */
        }

        /* すべての要素にフォントを強制適用 */
        * {
            font-family: 'notosansjp', 'ipaexg', 'ipag', 'sans-serif' !important;
        }

        /* 全体を囲うコンテナ */
        .container {
            width: 100%;
        }

        /* 汎用スタイル */
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .mt-1 {
            margin-top: 4px;
        }

        .mt-2 {
            margin-top: 8px;
        }

        .mt-4 {
            margin-top: 16px;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .p-2 {
            padding: 8px;
        }

        .border {
            border: 1px solid #ccc;
        }

        .w-100 {
            width: 100%;
        }

        /* ヘッダー */
        .header-title {
            font-size: 20pt;
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #333;
            margin-bottom: 10px;
            /* 下の余白を追加 */
        }

        /* 発行日 */
        .issue-date {
            font-size: 8pt;
            color: #666;
            text-align: right;
            margin-bottom: 20px;
        }

        /* 宛名・発行者情報 */
        .info-table {
            width: 100%;
            margin-top: 20px;
        }

        .info-table td {
            vertical-align: top;
            padding: 5px;
        }

        /* ▼▼▼▼▼ ここから修正 ▼▼▼▼▼ */

        .customer-name {
            font-size: 14pt;
            font-weight: bold;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
            margin: 0 0 1em 0;
            /* 行間を1行分に拡大 */
        }

        .estimate-intro {
            margin: 0 0 1em 0;
            /* 行間を1行分に拡大 */
        }

        .preferences {
            margin-top: 0;
            /* 上の要素で行間を管理するためリセット */
        }

        .preferences p {
            margin: 0 0 0.8em 0;
            /* 行間を0.8行分に拡大 */
        }

        /* 最後の行の下には余白が不要なためリセット */
        .preferences p:last-of-type {
            margin-bottom: 0;
        }

        /* ▲▲▲▲▲ ここまで修正 ▲▲▲▲▲ */

        /* 商品セクション */
        .product-section {
            margin-bottom: 10px;
        }

        .product-title {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        .product-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            padding: 4px;
            /* 商品テーブルのTHの縦サイズを小さく */
        }

        .product-table .item-name {
            text-align: left;
        }

        .highlight {
            font-weight: bold;
            color: #d82c2c;
        }

        /* 明細表 */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .summary-table th,
        .summary-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        .summary-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .summary-table .item-name {
            text-align: left;
        }

        .highlight {
            font-weight: bold;
            color: #d82c2c;
        }

        /* 工賃内訳 */
        .labor-title {
            /*font-size: 8pt;*/
            font-weight: bold;
            margin: 0;
            line-height: 1;
        }

        .labor-table {
            width: 100%;
            border-collapse: collapse;
        }

        .labor-table th,
        .labor-table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
            font-size: 6pt;
        }

        .labor-table th {
            background-color: #fafafa;
        }

        .labor-table .labor-name {
            text-align: left;
        }

        /* 備考・会社情報 */
        .notes,
        .company-info-footer {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #eee;
            font-size: 9pt;
            line-height: 1.6;
        }

        /* 会社情報の連絡先 */
        .contact-info {
            display: flex;
            gap: 15px;
            /* 連絡先間のスペース */
            margin: 5px 0;
        }

        /* 上部の会社情報 */
        .company-info-header {
            font-size: 9pt;
            line-height: 1.4;
            margin-top: 10px;
            margin-bottom: 20px;
            text-align: left;
            /* 左寄せに変更 */
        }
    </style>
</head>

<body>
    <div class="container">

        <h1 class="header-title">御 見 積 書</h1>

        <div class="issue-date">発行日: {{ $date }}</div>

        <table class="info-table">
            <tr>
                <td style="width: 60%;">
                    <p class="customer-name">{{ $customer_name ?? '　　　　　' }} {{ $honorific ?? '' }}</p>
                    <br>
                    <p class="estimate-intro">下記の通りお見積申し上げます。</p>
                    <br>
                    <div class="preferences">
                        <p><strong>■ご希望サイズ:</strong> {{ $sizeFree ?? $sizeGeneral ?? '未指定' }}</p>
                        <p><strong>■ご希望タイヤ:</strong> {{ $selectTire ?? '' }}</p>
                        <br><br>
                    </div>
                </td>
                <td style="width: 40%; vertical-align: top;">
                    <div class="company-info-header">
                        <strong>{{ $company_name ?? '' }}</strong><br>
                        〒{{ $company_postal ?? '' }} {{ $company_address ?? '' }}<br>
                        <div class="contact-info">
                            <span>TEL: {{ $company_tel ?? '' }}</span>
                            <span>FAX: {{ $company_fax ?? '' }}</span>
                            <span>Email: {{ $company_email ?? '' }}</span>
                            <span>URL: {{ $company_url ?? '' }}</span>
                        </div>
                        登録番号: {{ $company_registration_number ?? '' }}<br>
                    </div>
                </td>
            </tr>
        </table>

        @foreach ($items as $item)
        @php
        // 商品価格の計算
        $cost = $item['cost'];
        $quantity = $item['quantity'];
        $base = $cost * $quantity;
        $add = is_numeric($grossA) ? $grossA : 0;
        $mul = is_numeric($grossB) ? $grossB : 1;
        $price = ($base + $add) * $mul;
        if ($taxMode === 'excluding') $price *= 1.1;

        // 工賃合計の計算
        $laborTotal = 0;
        foreach ($laborItems as $labor) {
        $laborTotal += $labor['price'] * $labor['quantity'];
        }
        if ($laborTaxMode === 'excluding') $laborTotal *= 1.1;

        // 商品代金と工賃の合計
        $total = $price + $laborTotal;

        // メーカー名取得
        $maker = null;
        if ($loop->index === 0) {
        $maker = $maker1 ?? '';
        } elseif ($loop->index === 1) {
        $maker = $maker2 ?? '';
        } elseif ($loop->index === 2) {
        $maker = $maker3 ?? '';
        }
        @endphp
        <div class="product-section">
            <div class="product-title">商品{{ $loop->iteration }}: {{ $maker }}</div>
            <table class="product-table">
                <thead>
                    <tr>
                        <th style="width: 33.33%;">商品</th>
                        <th style="width: 33.33%;">工賃</th>
                        <th style="width: 33.33%;">合計</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">{{ number_format($price) }} 円</td>
                        <td class="text-right">{{ number_format($laborTotal) }} 円</td>
                        <td class="text-right highlight">{{ number_format($total) }} 円</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endforeach

        {{-- 工賃内訳は商品ループの最後のときだけ表示 --}}
        @if (count($laborItems))
        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <tr>
                <td style="width: 30%; vertical-align: top; padding-top: 8px;">
                    <div class="labor-title">工賃内訳</div>
                </td>
                <td style="width: 70%;">
                    <table class="labor-table">
                        <thead>
                            <tr>
                                <th>項目名</th>
                                <th>単価</th>
                                <th>数量</th>
                                <th>小計</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laborItems as $labor)
                            @php
                            $subtotal = $labor['price'] * $labor['quantity'];
                            @endphp
                            <tr>
                                <td class="labor-name">{{ $labor['name'] }}</td>
                                <td class="text-right">{{ number_format($labor['price']) }} 円</td>
                                <td>{{ $labor['quantity'] }}</td>
                                <td class="text-right">{{ number_format($subtotal) }} 円</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right font-weight-bold">工賃合計（税込）</td>
                                <td class="text-right font-weight-bold">{{ number_format($laborTotal) }} 円</td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
        </table>
        @endif

        <!--<div class="notes">-->
        <br>
        <strong>備考</strong><br>
        {!! nl2br(e($comment ?? '')) !!}<br>
        ※見積もり有効期限は発行から１週間です。
        <!--</div>-->

        <div class="company-info-footer">
            <strong>＜振込先＞</strong><br>
            @if($company_transfer_1){{ $company_transfer_1 }}<br>@endif
            @if($company_transfer_2){{ $company_transfer_2 }}<br>@endif
            @if($company_transfer_3){{ $company_transfer_3 }}<br>@endif
            {{ $company_note ?? '' }}
        </div>

    </div>
</body>

</html>