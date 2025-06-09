<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12pt;
            margin: 30mm;
        }

        .wrapper {

            padding: 50px;
            height: 240mm;

        }

        .title {
            text-align: center;
            font-size: 20pt;
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 20px 0;
            margin-bottom: 20px;
        }

        .right-align-small {
            text-align: right;
            font-size: 10pt;
            color: #333;
            margin-bottom: 4px;
        }

        .client {
            margin-top: 20px;
            margin-bottom: 60px;
            font-size: 12pt;
            text-align: left;
            line-height: 1.8;
        }

        .billing {
            margin-top: 30px;
            text-align: right;
            font-size: 10pt;
            line-height: 1.4;
        }

        .message {
            margin-top: 30px;
        }

        .transfer {
            width: 90%;
            padding: 15px;
            margin: 20px auto 0;
            border: 1px solid #000;
            font-size: 12pt;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
            padding: 4px 4px;
            /* ← 狭めの余白に調整 */

        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row th,
        .total-row td {
            font-weight: bold;
            font-size: 14pt;
        }

        .remark-table {
            font-size: 10pt;
        }

        .remark-table td {
            font-weight: bold;
        }

        .client-name {
            font-size: 16pt;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="title">請求書</div>

        <div class="right-align-small">発行日：{{ $date ?? '　　' }}</div>
        <div class="right-align-small">明細枚数：{{ $page_count ?? '　' }}枚 (本紙含む)</div>

        <div class="client">
            <div>{{ $billingAddress }}</div>
            <div class="client-name">{{ $client }} {{ $to_suffix }}</div>
        </div>

        以下の通りご請求申し上げます。<br><br>

        {{-- 請求明細表 --}}
        <table>
            <tr>
                <th style="width: 70%;">項目</th>
                <th>金額</th>
            </tr>

            @for ($i = 1; $i <= 5; $i++)
                @php
                $item=request()->input("item_$i");
                $price = request()->input("price_$i");
                @endphp
                @if (!is_null($item) || (!is_null($price) && $price !== "0"))
                <tr>
                    <td>{{ $item ?? '　' }}</td>
                    <td class="text-right">{{ ($price !== "0" && $price !== null) ? number_format($price) . ' 円' : '' }}</td>
                </tr>
                @endif
                @endfor

                @php $total = request()->input('total'); @endphp
                <tr class="total-row">
                    <td class="text-center">合計</td>
                    <td class="text-right">
                        @if ($total !== "0" && $total !== null)
                        {{ number_format($total) }} 円
                        @endif
                    </td>
                </tr>
        </table>

        {{-- 備考欄 --}}
        <div class="message">
            <table class="remark-table">
                <tr>
                    <th style="width: 35%;">備考</th>
                </tr>
                <tr>
                    <td>{{ $message ?? '　' }}</td>
                </tr>
            </table>
        </div>

        {{-- 発行者情報 --}}
        <div class="billing">
            <div>{{ $postal ? '〒' . $postal : '' }} {{ $address ?? '' }}</div>
            <div>{{ $name ?? '' }}</div>
            <div>
                {{ $tel ? 'TEL:' . $tel : '' }}
                {{ $fax ? 'FAX:' . $fax : '' }}
            </div>
            <div>
                {{ $mail ? 'Mail:' . $mail : '' }}
                {{ $url ? 'URL:' . $url : '' }}
            </div>
        </div>

        {{-- 振込先情報 --}}
        @if (!empty($transfer_1))
        <div class="transfer">
            <strong>【振込先】</strong><br>
            {{ $transfer_1 }}<br>
            @if (!empty($transfer_2)) {{ $transfer_2 }}<br> @endif
            @if (!empty($transfer_3)) {{ $transfer_3 }}<br> @endif
        </div>
        @endif

    </div>
</body>

</html>