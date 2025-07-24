<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>御見積書</title>
    <style>
        /* 日本語フォントの設定 (laravel-mpdfで日本語を表示させるための重要設定) 
        body {
            font-family: 'ipaexg', 'ipag', 'sans-serif';
            font-size: 10pt;
            color: #333;
        }*/

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

        .customer-name {
            font-size: 14pt;
            font-weight: bold;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
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
        .labor-table {
            width: 70%;
            /* 少し小さく見せる */
            border-collapse: collapse;
            margin-top: 10px;
            margin-left: auto;
            /* 右寄せ */
        }

        .labor-table th,
        .labor-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
            font-size: 9pt;
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
    </style>
</head>

<body>
    <div class="container">

        <h1 class="header-title">御 見 積 書</h1>

        <table class="info-table">
            <tr>
                <td style="width: 60%;">
                    <p class="customer-name">{{ $customer_name ?? '　　　　　' }} {{ $honorific ?? '' }}</p>
                    <p class="mt-4">下記の通りお見積申し上げます。</p>
                    <p><strong>■ご希望サイズ:</strong> {{ $sizeFree ?? $sizeGeneral ?? '未指定' }}</p>
                    <p><strong>■ご希望タイヤ:</strong> {{ $selectTire ?? '' }}</p>
                </td>
                <td style="width: 40%; vertical-align: top; text-align: right;">
                    <p>発行日: {{ $date }}</p>
                </td>
            </tr>
        </table>

        <table class="summary-table">
            <thead>
                <tr>
                    <th style="width: 45%;">商品</th>
                    <th style="width: 20%;">商品代金(税込)</th>
                    <th style="width: 20%;">工賃(税込)</th>
                    <th style="width: 15%;">合計金額</th>
                </tr>
            </thead>
            <tbody>
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
                <tr>
                    <td class="item-name"><strong>【プラン{{ $loop->iteration }}】</strong> {{ $maker }}</td>
                    <td class="text-right">{{ number_format($price) }} 円</td>
                    <td class="text-right">{{ number_format($laborTotal) }} 円</td>
                    <td class="text-right highlight">{{ number_format($total) }} 円</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- 工賃内訳は商品ループの最後のときだけ表示 --}}
        @if (count($laborItems))
        <div class="mt-4">
            <strong class="font-weight-bold">■ 工賃内訳</strong>
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
        </div>
        @endif

        <div class="notes">
            <strong>■ 備考</strong><br>
            {!! nl2br(e($comment ?? '')) !!}<br>
            ※見積もり有効期限は発行から１週間です。
        </div>

        <div class="company-info-footer">
            <strong>{{ $company_name ?? '' }}</strong><br>
            〒{{ $company_postal ?? '' }} {{ $company_address ?? '' }}<br>
            TEL: {{ $company_tel ?? '' }} FAX: {{ $company_fax ?? '' }}<br>
            Email: {{ $company_email ?? '' }} URL: {{ $company_url ?? '' }}<br>
            登録番号: {{ $company_registration_number ?? '' }}<br>
            <hr style="border: none; border-top: 1px solid #eee; margin: 8px 0;">
            <strong>■ 振込先</strong><br>
            {{ $company_transfer_1 ?? '' }}<br>
            {{ $company_transfer_2 ?? '' }}<br>
            {{ $company_transfer_3 ?? '' }}<br>
            <hr style="border: none; border-top: 1px solid #eee; margin: 8px 0;">
            {!! nl2br(e($company_note ?? '')) !!}
        </div>

    </div>
</body>

</html>