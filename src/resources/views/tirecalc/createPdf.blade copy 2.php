<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>御見積書</title>
    <style>
        /* 日本語フォントの設定 (laravel-mpdfで日本語を表示させるための重要設定) */
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #333;
            margin: 30px 40px; /* 上下左右の余白を調整 */
        }

        /* 全体を囲うコンテナ */
        .container {
            width: 100%;
        }

        /* 汎用スタイル */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-weight-bold { font-weight: bold; }
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-4 { margin-top: 16px; }
        .mb-2 { margin-bottom: 8px; }
        .p-2 { padding: 8px; }
        .border { border: 1px solid #ccc; }
        .w-100 { width: 100%; }

        /* ヘッダー */
        .header-title {
            font-size: 20pt;
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #333;
            margin-bottom: 10px; /* 下の余白を追加 */
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
        .customer-name {
            font-size: 14pt;
            font-weight: bold;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }

        /* 見積申し上げ文 */
        .estimate-intro {
            margin: 25px 0; /* 上下のスペースを広く */
        }

        /* 希望サイズ・タイヤ */
        .preferences {
            display: flex;
            gap: 5px; /* スペースをさらに狭く */
            margin-top: 10px;
        }
        .preference-item {
            flex: 1;
        }

        /* 商品セクション */
        .product-section {
            margin-bottom: 20px;
        }
        .product-title {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .product-table th, .product-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        .product-table th {
            background-color: #f2f2f2;
            font-weight: bold;
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
        .summary-table th, .summary-table td {
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
        .labor-section {
            margin-top: 20px;
        }
        .labor-title {
            font-size: 9pt; /* 備考と同じサイズ */
            font-weight: bold;
            margin-bottom: 10px;
        }
        .labor-table {
            width: 70%; /* 少し小さく見せる */
            border-collapse: collapse;
            margin-top: 10px;
            margin-left: auto; /* 右寄せ */
        }
        .labor-table th, .labor-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
            font-size: 8pt; /* 文字サイズを小さく */
        }
        .labor-table th {
            background-color: #fafafa;
        }
        .labor-table .labor-name {
            text-align: left;
        }

        /* 備考・会社情報 */
        .notes, .company-info-footer {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #eee;
            font-size: 9pt;
            line-height: 1.6;
        }

        /* 会社情報の連絡先 */
        .contact-info {
            display: flex;
            gap: 15px; /* 連絡先間のスペース */
            margin: 5px 0;
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
                    <p class="estimate-intro">下記の通りお見積申し上げます。</p>
                    <div class="preferences">
                        <div class="preference-item">
                            <strong>■ご希望サイズ:</strong> {{ $sizeFree ?? $sizeGeneral ?? '未指定' }}
                        </div>
                        <div class="preference-item">
                            <strong>■ご希望タイヤ:</strong> {{ $selectTire ?? '' }}
                        </div>
                    </div>
                </td>
                <td style="width: 40%; vertical-align: top; text-align: right;">
                    <!-- 発行日は上に移動済み -->
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
        <div class="labor-section">
            <div class="labor-title">■ 工賃内訳</div>
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
            <div class="contact-info">
                <span>TEL: {{ $company_tel ?? '' }}</span>
                <span>FAX: {{ $company_fax ?? '' }}</span>
                <span>Email: {{ $company_email ?? '' }}</span>
                <span>URL: {{ $company_url ?? '' }}</span>
            </div>
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