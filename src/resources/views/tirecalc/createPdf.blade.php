<!DOCTYPE html>
<html>

<head>
    <title>タイヤ御見積書</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        @page {
            margin: 20px;
        }

        .container {
            width: 100%;
            padding: 10px;
        }

        .header {
            background-color: #d82c2c;
            color: white;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        .section {
            margin-bottom: 20px;
        }

        .info-table,
        .summary-table,
        .labor-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table td,
        .summary-table th,
        .summary-table td,
        .labor-table th,
        .labor-table td {
            border: none;
            padding: 6px;
            text-align: center;
        }

        .summary-table th {
            background-color: #f0f0f0;
        }

        .labor-table th {
            background-color: #fafafa;
        }

        .highlight {
            color: #d82c2c;
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        .mt-2 {
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">タイヤ御見積書</div>

        <div class="section flex">
            <div>
                <u>{{ $address ?? '　　　　　' }} {{ $honorific ?? '' }}</u>
            </div>
            <br>
            <div style="text-align: right;">
                <strong>発行日:</strong> {{ $date }}
            </div>

        </div>

        <div class="section">
            <p><strong>タイヤ:</strong> {{ $selectTire ?? '' }}</p>
            <p><strong>サイズ:</strong> {{ $sizeFree ?? $sizeGeneral ?? '未指定' }}</p>
        </div>

        @foreach ($items as $item)
        @php
        $cost = $item['cost'];
        $quantity = $item['quantity'];
        $base = $cost * $quantity;
        $add = is_numeric($grossA) ? $grossA : 0;
        $mul = is_numeric($grossB) ? $grossB : 1;
        $price = ($base + $add) * $mul;
        if ($taxMode === 'excluding') $price *= 1.1;

        $laborTotal = 0;
        foreach ($laborItems as $labor) {
        $laborTotal += $labor['price'] * $labor['quantity'];
        }
        if ($laborTaxMode === 'excluding') $laborTotal *= 1.1;

        $total = $price + $laborTotal;
        @endphp

        <div class="section">
            <h4>{{ $item['label'] }}</h4>
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>表示単価</th>
                        <th>工賃小計</th>
                        <th>合計</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ number_format($price) }} 円</td>
                        <td>{{ number_format($laborTotal) }} 円</td>
                        <td class="highlight">{{ number_format($total) }} 円</td>
                    </tr>
                </tbody>
            </table>

            @if (count($laborItems))
            <div class="mt-2"><strong>工賃内訳</strong></div>
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
                        <td>{{ $labor['name'] }}</td>
                        <td>{{ number_format($labor['price']) }} 円</td>
                        <td>{{ $labor['quantity'] }}</td>
                        <td>{{ number_format($subtotal) }} 円</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @endif
        </div>
        @endforeach

        <div class="section">
            <strong>備考：</strong> {{ $comment ?? '' }}
        </div>

        <div class="section right" style="font-size: 10px;">
            ※見積もり有効期限は発行から１週間です
        </div>
    </div>
</body>

</html>