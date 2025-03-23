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
            background-color: #f8f8f8;
        }
        @page {
            margin-top: 15mm;
            margin-bottom: 15mmmm;
            margin-left: 30mm;
            margin-right: 30mm;
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
            発行日: {{ $date }}
        </div>
    </div>

    <div class="section">
        <table class="table details-table">
            <tbody>
                <tr>
                    <th>車名</th><th>年式</th><th>走行距離(km)</th><th>車検</th>
                </tr>
                <tr>
                    <td>{{ $car ?? '' }} {{ $color ?? '' }} {{ $transmission ?? '' }} {{ $drive ?? '' }}</td>
                    <td>{{ $year ?? '' }}</td>
                    <td>{{ $mileage ?? '' }}</td>
                    <td>{{ $inspection ?? '' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

<!--フォントサイズ指定-->
@php
    $small = 'style="font-size:10px;"';
@endphp

    <div class="section">
        <table class="table details-table">
            <tr>
                <th colspan="2">項目</th>
                <th>金額</th>
            </tr>
            <tr>
                <td colspan="2">車輌本体価格①</td>
                <td style="text-align: right;"><strong>{{ number_format($price ?? 0) }}</strong></td>
            </tr>
            <tr>
                <td class="narrow-column" rowspan="8">諸費用</td>
                <td class="align-left" {!! $small !!}>自動車税（月割）</td>
                <td style="text-align: right; font-size:10px;">{{ $tax_1 > 0 ? number_format($tax_1) : '' }}</td>
            </tr>
            <tr>
                <td class="align-left" {!! $small !!}>重量税</td>
                <td style="text-align: right; font-size:10px;">{{ $tax_2 > 0 ? number_format($tax_2) : '' }} </td>
            </tr>
            <tr>
                <td class="align-left" {!! $small !!}>自賠責保険料</td>
                <td style="text-align: right; font-size:10px;">{{ $tax_3 > 0 ? number_format($tax_3) : '' }} </td>
            </tr>
            <tr>
                <td class="align-left" {!! $small !!}>環境性能割</td>
                <td style="text-align: right; font-size:10px;">{{ $tax_4 > 0 ? number_format($tax_4) : '' }} </td>
            </tr>
            <tr>
                <td class="align-left" {!! $small !!}>リサイクル預託金</td>
                <td style="text-align: right; font-size:10px;">{{ $tax_5 > 0 ? number_format($tax_5) : '' }} </td>
            </tr>
            <tr>
                <td class="align-left" {!! $small !!}>登録費用</td>
                <td style="text-align: right; font-size:10px;">{{ $overhead_1 > 0 ? number_format($overhead_1) : '' }} </td>
            </tr>
            <tr>
                <td class="align-left" {!! $small !!}>{{ $overheadName_11 ?? '' }}</td>
                <td style="text-align: right; font-size:10px;">{{ $overhead_11 > 0 ? number_format($overhead_11) : '' }} </td>
            </tr>
            <tr>
            <td>諸費用合計②</td>
                <td style="text-align: right;"><strong>{{ $overhead_total > 0 ? number_format($overhead_total) : '' }}</strong> </td>
            </tr>
            <tr>
                <td class="narrow-column" rowspan="6">オプションその他</td>
                <td {!! $small !!}>{{ $optionName_1 ?? '' }}</td>
                <td style="text-align: right; font-size:10px;">{{ $option_1 > 0 ? number_format($option_1) : '' }} </td>
            </tr>
            <tr>
                <td {!! $small !!}>{{ $optionName_2 ?? '' }}</td>
                <td style="text-align: right; font-size:10px;">{{ $option_2 > 0 ? number_format($option_2) : '' }} </td>
            </tr>
            <tr>
                <td {!! $small !!}>{{ $optionName_3 ?? '' }}</td>
                <td style="text-align: right; font-size:10px;">{{ $option_3 > 0 ? number_format($option_3) : '' }} </td>
            </tr>
            <tr>
                <td {!! $small !!}>{{ $optionName_4 ?? '' }}</td>
                <td style="text-align: right; font-size:10px;">{{ $option_4 > 0 ? number_format($option_4) : '' }} </td>
            </tr>
            <tr>
                <td {!! $small !!}>{{ $optionName_5 ?? '' }}</td>
                <td style="text-align: right; font-size:10px;">{{ $option_5 > 0 ? number_format($option_5) : '' }} </td>
            </tr>
            <tr>
                <td>オプション合計③</td>
                <td style="text-align: right;"><strong>{{ $option_total > 0 ? number_format($option_total) : '' }}</strong> </td>
            </tr>
            <tr>
                <td colspan="2">総 合 計（①＋②＋③）</td>
                <td class="highlight" style="text-align: right; font-size:16px;"><strong>{{ number_format($total ?? 0) }}</strong> 円</td>
            </tr>
        </table>
    </div>

    @if($payment ?? 0 > 0)
        <div class="section">
            <table class="table details-table">
                <tbody>
                    <tr>
                        <td>下取り</td>
                        <td style="text-align: right;">{{ number_format($trade_price ?? 0) }} </td>
                    </tr>
                    <tr>
                        <td>値引き</td>
                        <td style="text-align: right;">{{ number_format($discount ?? 0) }} </td>
                    </tr>
                    <tr>
                        <td>お支払い合計</td>
                        <td class="highlight" style="text-align: right; font-size:16px;"><strong>{{ number_format($payment ?? 0) }}</strong> 円</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    <div class="section">
        <strong>メモ:</strong>
        <p>{{ $memo }}</p>
    </div>

    <div class="footer">
        <p>※見積もり有効期限は発行から１週間</p>
    </div>
</body>
</html>
