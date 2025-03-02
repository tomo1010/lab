<!DOCTYPE html>
<html>
<head>
    <title>見積書</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
            background-color: #f8f8f8;
        }
        .container {
            width: 80%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background: red;
            color: #fff;
            border-radius: 4px;
        }
        .section {
            margin-bottom: 15px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: #fff;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .table th {
            background: #ccc;
            color: black;
        }
        .highlight {
            font-weight: bold;
            color: red;
        }
        .price-large {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        .footer {
            font-size: 12px;
            text-align: right;
            margin-top: 20px;
            color: #666;
        }
        .details-table td {
            padding: 6px 12px;
        }
        .narrow-column {
            width: 80px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">御見積書</div>
        <div style="text-align: right;"><strong>発行日:</strong> {{ $date }}</div>
        <div class="section">
            <table class="table details-table">
                <tbody>
                    <tr>
                        <th>車名</th><th>年式</th><th>走行距離</th><th>車検</th>
                    </tr>
                    <tr>
                        <td>{{ $car ?? '' }} {{ $displacement ?? '' }} {{ $transmission ?? '' }} {{ $color ?? '' }} {{ $drive ?? '' }}</td>
                        <td>{{ $year ?? '' }}</td>
                        <td>{{ $mileage ?? '' }} km</td>
                        <td>{{ $inspection ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="section">
            <table class="table details-table">
                <tr>
                    <th colspan="2">項目</th>
                    <th>金額</th>
                </tr>
                <tr>
                    <td colspan="2">車輌本体価格①（消費税込み）</td>
                    <td  style="text-align: right;">{{ number_format($price ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td class="narrow-column" rowspan="5">諸費用②</td>
                    <td>自動車税（月割）</td>
                    <td style="text-align: right;">{{ number_format($tax_1 ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td>重量税</td>
                    <td style="text-align: right;">{{ number_format($tax_2 ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td>自賠責保険料</td>
                    <td style="text-align: right;">{{ number_format($tax_3 ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td>リサイクル預託金</td>
                    <td style="text-align: right;">{{ number_format($tax_5 ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td>登録費用</td>
                    <td style="text-align: right;">{{ number_format($overhead_1 ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td class="narrow-column" rowspan="5">オプションその他③</td>
                    <td>{{ $optionName_1 ?? '' }}</td>
                    <td style="text-align: right;">{{ number_format($option_1 ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td>{{ $optionName_2 ?? '' }}</td>
                    <td style="text-align: right;">{{ number_format($option_2 ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td>{{ $optionName_3 ?? '' }}</td>
                    <td style="text-align: right;">{{ number_format($option_3 ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td>{{ $optionName_4 ?? '' }}</td>
                    <td style="text-align: right;">{{ number_format($option_4 ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td>{{ $optionName_5 ?? '' }}</td>
                    <td style="text-align: right;">{{ number_format($option_5 ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td colspan="2">総 合 計（①＋②＋③）</td>
                    <td class="price-large highlight" style="text-align: right;">{{ number_format($total ?? 0) }} 円</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <table class="table details-table">
                <tbody>
                <tr>
                    <td>下取り</td>
                    <td style="text-align: right;">{{ number_format($trade_price ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td>値引き</td>
                    <td style="text-align: right;">{{ number_format($discount ?? 0) }} 円</td>
                </tr>
                <tr>
                    <td>お支払い合計</td>
                    <td class="price-large highlight" style="text-align: right;">{{ number_format($payment ?? 0) }} 円</td> 
                </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <table class="table details-table">
                <tbody>
                    <tr>
                        <th>メモ</th>
                    </tr>
                    <tr>
                        <td></td>
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