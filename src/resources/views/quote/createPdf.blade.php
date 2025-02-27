<!DOCTYPE html>
<html>
<head>
    <title>見積書</title>
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
        <div class="header">自動車販売見積書</div>
        <br>

        <div class="section">
            <p><strong>お客様名:</strong> {{ $name }}</p>

        </div>

        <div class="section">
            <p><strong>車種:</strong> {{ $car ?? '' }}</p>
            <p><strong>排気量:</strong> {{ $displacement ?? '' }}</p>
            <p><strong>ミッション:</strong> {{ $transmission ?? '' }}</p>
            <p><strong>色:</strong> {{ $color ?? '' }}</p>
            <p><strong>駆動:</strong> {{ $drive ?? '' }}</p>
            <p><strong>年式:</strong> {{ $year ?? '' }}</p>
            <p><strong>走行距離:</strong> {{ $mileage ?? '' }}</p>
            <p><strong>車検日:</strong> {{ $inspection ?? '' }}</p>
        </div>

        <div class="section">
            <table class="table">
                <thead>
                    <tr>
                        <th>価格（税抜）</th>
                        <th>消費税</th>
                        <th>合計（税込）</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ number_format($price ?? 0) }} 円</td>
                        <td>{{ number_format($tax_total ?? 0) }} 円</td>
                        <td class="highlight">{{ number_format($total ?? 0) }} 円</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <p><strong>諸費用合計:</strong> {{ number_format($overhead_total ?? 0) }} 円</p>
            <p><strong>オプション合計:</strong> {{ number_format($option_total ?? 0) }} 円</p>
            <p><strong>下取り価格:</strong> {{ number_format($trade_price ?? 0) }} 円</p>
            <p><strong>値引き:</strong> {{ number_format($discount ?? 0) }} 円</p>
            <p><strong>お支払い総額:</strong> <span class="highlight">{{ number_format($payment ?? 0) }} 円</span></p>
        </div>

        <div class="footer">
            ※見積もり有効期限は発行から１週間
        </div>
    </div>
</body>
</html>
