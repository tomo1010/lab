<!DOCTYPE html>
<html>
<head>
    <title>見積書</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            padding: 0;
            background-color: #f8f8f8;
        }
        @page {
            margin: 20px;
        }
        .header {
            background-color: #d82c2c;
            color: white;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border-radius: 4px;
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
            font-weight: bold;
            color: red;
        }
        .footer {
            font-size: 10px;
            margin-top: 20px;
            text-align: right;
        }
        .details-table td {
            padding: 6px 12px;
        }
        .narrow-column {
            width: 80px;
        }
        .align-left {
            text-align: left !important;
        }
    </style>
</head>
<body>
    <div class="header">御見積書</div>
    <div class="section flex">
        <div style="text-align: right;">
            <strong>発行日:</strong> {{ $date }}
        </div>
    </div>

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
                <td colspan="2">車輌本体価格①（消費税込）</td>
                <td style="text-align: right;">{{ number_format($price ?? 0) }} 円</td>
            </tr>
            <tr>
                <td class="narrow-column" rowspan="8">諸費用②</td>
                <td class="align-left">自動車税（月割）</td>
                <td style="text-align: right;">{{ number_format($tax_1 ?? 0) }} 円</td>
            </tr>
            <tr>
                <td class="align-left">重量税</td>
                <td style="text-align: right;">{{ number_format($tax_2 ?? 0) }} 円</td>
            </tr>
            <tr>
                <td class="align-left">自賠責保険料</td>
                <td style="text-align: right;">{{ number_format($tax_3 ?? 0) }} 円</td>
            </tr>
            <tr>
                <td class="align-left">環境性能割</td>
                <td style="text-align: right;">{{ number_format($tax_4 ?? 0) }} 円</td>
            </tr>
            <tr>
                <td class="align-left">リサイクル預託金</td>
                <td style="text-align: right;">{{ number_format($tax_5 ?? 0) }} 円</td>
            </tr>
            <tr>
                <td class="align-left">登録費用</td>
                <td style="text-align: right;">{{ number_format($overhead_1 ?? 0) }} 円</td>
            </tr>
            <tr>
                <td class="align-left">車庫証明</td>
                <td style="text-align: right;">{{ number_format($overhead_2 ?? 0) }} 円</td>
            </tr>
            <tr>
                <td>小計②</td>
                <td style="text-align: right;">{{ number_format($overhead_total ?? 0) }} 円</td>
            </tr>
            <tr>
                <td class="narrow-column" rowspan="6">オプションその他</td>
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
                <td>小計③</td>
                <td style="text-align: right;">{{ number_format($option_total ?? 0) }} 円</td>
            </tr>
            <tr>
                <td colspan="2">総 合 計（①＋②＋③）</td>
                <td class="highlight" style="text-align: right;">{{ number_format($total ?? 0) }} 円</td>
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
                    <td class="highlight" style="text-align: right;">{{ number_format($payment ?? 0) }} 円</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <strong>備考:</strong>
    </div>

    <div class="footer">
        <p>※見積もり有効期限は発行から１週間</p>
    </div>
</body>
</html>
