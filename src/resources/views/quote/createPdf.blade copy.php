<!DOCTYPE html>
<html>
<head>
    <title>見積書</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .container {
            width: 90%;
            margin: auto;
        }
        .header {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 15px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .highlight {
            font-weight: bold;
            color: red;
        }
        .footer {
            font-size: 12px;
            text-align: right;
            margin-top: 20px;
        }
        .details-table td {
            padding: 4px 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">御見積書</div>

        <div class="section">
            <table class="table details-table">
                <tbody>
                    <tr>
                        <td>車名</td><td>年式</td><td>走行距離</td><td>車検</td>
                    </tr>
                    <tr>
                        <td>{{ $car ?? '' }} {{ $displacement ?? '' }} {{ $transmission ?? '' }} {{ $color ?? '' }} {{ $drive ?? '' }}</td><td>{{ $year ?? '' }}</td><td>{{ $mileage ?? '' }} km</td><td>{{ $inspection ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>金額</th>
                        <th>消費税</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>車両本体価格</strong></td>
                        <td class="highlight">{{ number_format($price ?? 0) }} 円</td>                    
                        <td>{{ number_format(($price ?? 0) * 0.1/1.1) }} 円</td>
                    </tr>
                    <!--諸費用-->
                    <tr>
                        <td>自動車税</td>
                        <td>{{ number_format($tax_1 ?? 0) }} 円</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>重量税</td>
                        <td>{{ number_format($tax_2 ?? 0) }} 円</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>自賠責保険</td>
                        <td>{{ number_format($tax_3 ?? 0) }} 円</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>リサイクル料</td>
                        <td>{{ number_format($tax_5 ?? 0) }} 円</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>登録費用</td>
                        <td>{{ number_format($overhead_1 ?? 0) }} 円</td>
                        <td>{{ number_format(($overhead_1 ?? 0) * 0.1/1.1) }} 円</td>
                    </tr>
                    <tr>
                        <td>諸費用合計</td>
                        <td>{{ number_format($subtotal ?? 0) }} 円</td>
                    </tr>
                    <!--オプション-->
                    <tr>
                        <td>{{ $optionName_1 ?? '' }}</td>
                        <td>{{ number_format($option_1 ?? 0) }} 円</td>
                        <td>{{ number_format(($option_1 ?? 0) * 0.1/1.1) }} 円</td>
                    </tr>
                    <tr>
                        <td>{{ $optionName_2 ?? '' }}</td>
                        <td>{{ number_format($option_2 ?? 0) }} 円</td>
                        <td>{{ number_format(($option_2 ?? 0) * 0.1/1.1) }} 円</td>
                    </tr>
                    <tr>
                        <td>{{ $optionName_3 ?? '' }}</td>
                        <td>{{ number_format($option_3 ?? 0) }} 円</td>
                        <td>{{ number_format(($option_3 ?? 0) * 0.1/1.1) }} 円</td>
                    </tr>
                    <tr>
                        <td>{{ $optionName_4 ?? '' }}</td>
                        <td>{{ number_format($option_4 ?? 0) }} 円</td>
                        <td>{{ number_format(($option_4 ?? 0) * 0.1/1.1) }} 円</td>
                    </tr>
                    <tr>
                        <td>{{ $optionName_5 ?? '' }}</td>
                        <td>{{ number_format($option_5 ?? 0) }} 円</td>
                        <td>{{ number_format(($option_5 ?? 0) * 0.1/1.1) }} 円</td>
                    </tr>
                    <!--合計-->
                    <tr>
                        <td><strong>合計（税込）</strong></td>
                        <td colspan="2"><strong>{{ number_format($total ?? 0) }} 円</strong></td>
                    </tr>
                    <tr>
                        <td>下取り価格</td>
                        <td colspan="2">{{ number_format($trade_price ?? 0) }} 円</td>
                    </tr>
                    <tr>
                        <td>値引き</td>
                        <td colspan="2">{{ number_format($discount ?? 0) }} 円</td>
                    </tr>
                    <tr>
                        <td><strong>お支払い総額</strong></td>
                        <td  colspan="2" class="highlight">{{ number_format($payment ?? 0) }} 円</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>※見積もり有効期限は発行から１週間</p>
        </div>
    </div>
</body>
</html>
