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
        .table th, .table td {
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
                <strong>宛名:</strong> {{ $address ?? '　　　　　' }} {{ $honorific ?? '' }}
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

        @foreach ($products as $index => $product)
            @if(($product['profitTotal'] ?? 0) != 0)
                <div class="section">
                    <h3>{{ $makers['maker' . ($index + 1)] ?? '商品' . chr(65 + $index) }}</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>タイヤ代</th>
                                <th>工賃</th>
                                <th>税抜合計</th>
                                <th>税込合計</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ number_format($product['profitTotal'] ?? 0) }} 円</td>
                                <td>{{ number_format($product['wagesTotal'] ?? 0) }} 円</td>
                                <td>{{ number_format($product['taxExcludedTotal'] ?? 0) }} 円</td>
                                <td class="highlight">{{ number_format($product['taxIncludedTotal'] ?? 0) }} 円</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach

        <div class="section">
            <strong>備考:</strong> {{ $comment }}
        </div>

        <div class="footer" style="text-align: right;">
            ※見積もり有効期限は発行から１週間
        </div>
    </div>
</body>
</html>
