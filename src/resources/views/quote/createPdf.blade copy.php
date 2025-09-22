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
            margin-bottom: 15mm; /* ← 元のtypo(15mmmm)を微修正 */
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
                @php
                    // 受け取り：$vehicle['car'|'color'|'transmission'|'drive'|'year'|'mileage'|'inspection_year'|'inspection_month']
                    $veh = $vehicle ?? [];
                    $inspectionText = '';
                    if (!empty($veh['inspection_year']) && !empty($veh['inspection_month'])) {
                        $inspectionText = $veh['inspection_year'] . '年 ' . $veh['inspection_month'] . '月';
                    } elseif (!empty($veh['inspection_year'])) {
                        $inspectionText = $veh['inspection_year'];
                    } elseif (!empty($veh['inspection_month'])) {
                        $inspectionText = $veh['inspection_month'] . '月';
                    }
                @endphp
                <tr>
                    <td>{{ ($veh['car'] ?? '') }} {{ ($veh['color'] ?? '') }} {{ ($veh['transmission'] ?? '') }} {{ ($veh['drive'] ?? '') }}</td>
                    <td>{{ ($veh['year'] ?? '') }}</td>
                    <td>{{ ($veh['mileage'] ?? '') }}</td>
                    <td>{{ $inspectionText }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!--フォントサイズ指定-->
    @php
        $small = 'style="font-size:10px;"';
        // number_format の短縮
        $nf = fn($v) => number_format((int)($v ?? 0));
        // 配列（コントローラから）：$tax_rows(name,amount), $fee_rows(name,amount), $option_rows(name,unit_price)
        $taxRows   = collect($tax_rows ?? []);
        $feeRows   = collect($fee_rows ?? []);
        $optRows   = collect($option_rows ?? []);

        // 諸費用ブロックのrowspan（明細行 + 合計行1つ）。最低1は確保
        $chargeDetailCount = $taxRows->count() + $feeRows->count();
        $chargeRowspan = max(1, $chargeDetailCount + 1);

        // オプションブロックのrowspan（明細行 + 合計行1つ）。最低1
        $optDetailCount = $optRows->count();
        $optRowspan = max(1, $optDetailCount + 1);
    @endphp

    <div class="section">
        <table class="table details-table">
            <tr>
                <th colspan="2">項目</th>
                <th>金額</th>
            </tr>
            <!-- 車輌本体価格① -->
            <tr>
                <td colspan="2">車輌本体価格①</td>
                <td style="text-align: right;"><strong>{{ $nf($price ?? 0) }}</strong></td>
            </tr>

            <!-- 諸費用（税金・保険料 + 販売諸費用 明細 → 合計②） -->
            <tr>
                <td class="narrow-column" rowspan="{{ $chargeRowspan }}">諸費用</td>
                @php
                    // 最初の明細行の内容をここで描画し、残りは後続<tr>で
                    $firstLine = null;
                    if ($taxRows->count() > 0) {
                        $firstLine = ['name' => $taxRows[0]['name'] ?? '', 'amount' => (int)($taxRows[0]['amount'] ?? 0)];
                        $taxRows = $taxRows->slice(1)->values();
                    } elseif ($feeRows->count() > 0) {
                        $firstLine = ['name' => $feeRows[0]['name'] ?? '', 'amount' => (int)($feeRows[0]['amount'] ?? 0)];
                        $feeRows = $feeRows->slice(1)->values();
                    } else {
                        $firstLine = ['name' => '', 'amount' => 0];
                    }
                @endphp
                <td class="align-left" {!! $small !!}>{{ $firstLine['name'] }}</td>
                <td style="text-align: right; font-size:10px;">{{ $firstLine['amount'] > 0 ? $nf($firstLine['amount']) : '' }}</td>
            </tr>

            @foreach($taxRows as $r)
                <tr>
                    <td class="align-left" {!! $small !!}>{{ $r['name'] ?? '' }}</td>
                    <td style="text-align: right; font-size:10px;">{{ ($r['amount'] ?? 0) > 0 ? $nf($r['amount']) : '' }}</td>
                </tr>
            @endforeach
            @foreach($feeRows as $r)
                <tr>
                    <td class="align-left" {!! $small !!}>{{ $r['name'] ?? '' }}</td>
                    <td style="text-align: right; font-size:10px;">{{ ($r['amount'] ?? 0) > 0 ? $nf($r['amount']) : '' }}</td>
                </tr>
            @endforeach

            <tr>
                <td>諸費用合計②</td>
                <td style="text-align: right;"><strong>{{ ($charges_total ?? 0) > 0 ? $nf($charges_total) : '' }}</strong></td>
            </tr>

            <!-- オプションその他（明細 → 合計③） -->
            <tr>
                <td class="narrow-column" rowspan="{{ $optRowspan }}">オプションその他</td>
                @php
                    $firstOpt = $optRows->first();
                    $optRows  = $optRows->slice(1)->values();
                @endphp
                <td {!! $small !!}>{{ $firstOpt['name'] ?? '' }}</td>
                <td style="text-align: right; font-size:10px;">
                    {{ isset($firstOpt['unit_price']) && (int)$firstOpt['unit_price'] > 0 ? $nf($firstOpt['unit_price']) : '' }}
                </td>
            </tr>
            @foreach($optRows as $r)
                <tr>
                    <td {!! $small !!}>{{ $r['name'] ?? '' }}</td>
                    <td style="text-align: right; font-size:10px;">{{ ($r['unit_price'] ?? 0) > 0 ? $nf($r['unit_price']) : '' }}</td>
                </tr>
            @endforeach
            <tr>
                <td>オプション合計③</td>
                <td style="text-align: right;"><strong>{{ ($option_total ?? 0) > 0 ? $nf($option_total) : '' }}</strong></td>
            </tr>

            <!-- 総合計 -->
            <tr>
                <td colspan="2">総 合 計（①＋②＋③）</td>
                <td class="highlight" style="text-align: right; font-size:16px;"><strong>{{ $nf($total ?? 0) }}</strong> 円</td>
            </tr>
        </table>
    </div>

    @if(($payment ?? 0) > 0)
        <div class="section">
            <table class="table details-table">
                <tbody>
                    <tr>
                        <td>下取り</td>
                        <td style="text-align: right;">{{ $nf($trade_price ?? 0) }} </td>
                    </tr>
                    <tr>
                        <td>値引き</td>
                        <td style="text-align: right;">{{ $nf($discount ?? 0) }} </td>
                    </tr>
                    <tr>
                        <td>お支払い合計</td>
                        <td class="highlight" style="text-align: right; font-size:16px;"><strong>{{ $nf($payment ?? 0) }}</strong> 円</td>
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
