<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .section {
            margin-bottom: 30px;
        }

        .title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .line {
            border-bottom: 1px solid #ccc;
            margin: 10px 0;
        }
    </style>
</head>

<body>
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
</body>

</html>