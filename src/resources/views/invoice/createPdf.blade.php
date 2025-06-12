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

        <div class="right-align-small">発行日：{{ $invoice->date ?? '　　' }}</div>
        <div class="right-align-small">明細枚数：{{ $invoice->page_count ?? '　' }}枚 (本紙含む)</div>

        <div class="client">
            <div>
                <div>{{ $invoice->client_address ?? '' }}</div>
                <div class="client-name">{{ $invoice->client ?? '' }} {{ $invoice->to_suffix ?? '' }}</div>
            </div>

            以下の通りご請求申し上げます。<br><br>

            {{-- 請求明細表 --}}
            <table>
                <tr>
                    <th style="width: 70%;">項目</th>
                    <th>金額</th>
                </tr>

                @if ($invoice)
                @for ($i = 1; $i <= 5; $i++)
                    @php
                    $item=$invoice->{'item_' . $i};
                    $price = $invoice->{'price_' . $i};
                    @endphp
                    @if (!is_null($item) || (!is_null($price) && $price != 0))
                    <tr>
                        <td>{!! $item ?? '&nbsp;' !!}</td>
                        <td class="text-right">
                            {{ ($price && $price != 0) ? number_format($price) . ' 円' : '&nbsp;' }}
                        </td>
                    </tr>
                    @endif
                    @endfor

                    <tr class="total-row">
                        <td class="text-center">合計</td>
                        <td class="text-right">{{ number_format($invoice->total ?? 0) }} 円</td>
                    </tr>
                    @else
                    {{-- 請求書が存在しない場合の表示 --}}
                    <tr>
                        <td colspan="2" class="text-center text-gray-500">請求金額はありません</td>
                    </tr>
                    @endif
            </table>

            {{-- 備考欄 --}}
            <div class="message">
                <table class="remark-table">
                    <tr>
                        <th style="width: 35%;">備考</th>
                    </tr>
                    <tr>
                        <td>{{ $invoice->message ?? '　' }}</td>
                    </tr>
                </table>
            </div>

            @if ($invoice)
            {{-- 発行者情報 --}}
            <div class="billing">
                <div>
                    {!! ($invoice->postal ? '〒' . e($invoice->postal) : '') !!}
                    {!! $invoice->address ?? '&nbsp;' !!}
                </div>
                <div>{!! $invoice->name ?? '&nbsp;' !!}</div>
                <div>
                    {!! $invoice->invoice_number ? '登録番号: ' . e($invoice->invoice_number) : '&nbsp;' !!}
                </div>
                <div>
                    {!! $invoice->tel ? 'TEL:' . e($invoice->tel) : '' !!}
                    {!! $invoice->fax ? ' FAX:' . e($invoice->fax) : '' !!}
                    {!! (!$invoice->tel && !$invoice->fax) ? '&nbsp;' : '' !!}
                </div>
                <div>
                    {!! $invoice->mail ? 'Mail:' . e($invoice->mail) : '' !!}
                    {!! $invoice->url ? ' URL:' . e($invoice->url) : '' !!}
                    {!! (!$invoice->mail && !$invoice->url) ? '&nbsp;' : '' !!}
                </div>
            </div>

            {{-- 振込先情報 --}}
            @if (!empty($invoice->transfer_1))
            <div class="transfer">
                <strong>【振込先】</strong><br>
                {!! nl2br(e($invoice->transfer_1)) !!}<br>
                @if (!empty($invoice->transfer_2)) {!! nl2br(e($invoice->transfer_2)) !!}<br> @endif
                @if (!empty($invoice->transfer_3)) {!! nl2br(e($invoice->transfer_3)) !!}<br> @endif
            </div>
            @endif
            @else
            {{-- $invoiceがnullだった場合の表示 --}}
            <div class="billing text-gray-500">
                発行者情報が存在しません。
            </div>
            @endif

</body>

</html>