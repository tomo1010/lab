<!DOCTYPE html>
<html>

<head>
    <title>タイヤ御見積書</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
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
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .highlight {
            color: red;
            font-weight: bold;
        }

        .footer {
            font-size: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">タイヤ御見積書</div>
        <br>
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
            <p><strong>タイヤ:</strong> {{ $selectTire }}</p>
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
            <div class="title">{{ $item['label'] }}</div>
            <div>表示単価：{{ number_format($price) }} 円</div>
            <div>工賃小計：{{ number_format($laborTotal) }} 円</div>
            <div><strong>合計：{{ number_format($total) }} 円</strong></div>

            <div class="line"></div>
            <div><strong>工賃明細</strong></div>
            <ul>
                @foreach ($laborItems as $labor)
                <li>
                    {{ $labor['name'] }}：{{ number_format($labor['price']) }}円 × {{ $labor['quantity'] }}個
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach

        <br>
        <div class="section">
            <strong>備考:</strong> {{ $comment }}
        </div>

        <div class="footer" style="text-align: right;">
            ※見積もり有効期限は発行から１週間
        </div>
    </div>
</body>

</html>