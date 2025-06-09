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
            border: 1px solid #000;
            padding: 60px;
            position: relative;
            height: 240mm;
            box-sizing: border-box;
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

        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
            margin-bottom: 40px;
        }

        .client {
            margin-top: 20px;
            margin-bottom: 60px;
            font-size: 12pt;
            text-align: left;
            flex: 1;
            line-height: 1.8;
        }

        .billing {
            margin-top: 30px;
            text-align: right;
            font-size: 10pt;
            flex: 1;
            line-height: 1.8;
        }

        .message {
            margin-top: 30px;
        }

        .transfer {
            width: 90%;
            padding: 15px;
            margin: 20px auto;
            border: 1px solid #000;
            margin-top: 20px;
            font-size: 12pt;
            flex: 1;
            line-height: 1.8;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="title">請求書</div>

        <div class="right-align-small">
            発行日：{{ $date ?? '　　' }}
        </div>

        <div class="right-align-small">
            明細枚数：{{ $page_count ?? '　' }}枚 (本紙含む)
        </div>

        <div class="client">
            <div>{{ $billingAddress }}</div>
            <div><span style="font-size: 16pt;">{{ $client }} {{ $to_suffix }}</span></div>
        </div>

        以下の通りご請求申し上げます。<br><br>

        <div class="invoie">
            <table style="width: 100%; font-size: 12pt; border: 1px solid #000; border-collapse: collapse;">
                <tr>
                    <th style="width: 35%; padding: 4px 15px; border: 1px solid #000; text-align: center; background-color: #f0f0f0;">
                        項目
                    </th>
                    <th style="padding: 4px 15px; border: 1px solid #000; text-align: center; background-color: #f0f0f0;">
                        金額
                    </th>
                </tr>

                {{-- 項目と金額の入力フィールドをループで生成 --}}
                @for ($i = 1; $i <= 5; $i++)
                    @php
                    $item=request()->input("item_$i");
                    $price = request()->input("price_$i");
                    @endphp
                    @if (!is_null($item) || (!is_null($price) && $price !== "0"))
                    <tr>
                        <td style="width: 35%; white-space: nowrap; padding: 15px; border: 1px solid #000;">
                            {{ $item ?? '　' }}
                        </td>
                        <td style="padding: 15px; border: 1px solid #000; text-align: right;">
                            {{ ($price !== "0" && $price !== null) ? number_format($price) . ' 円' : '' }}
                        </td>
                    </tr>
                    @endif
                    @endfor

                    @php
                    $total = request()->input('total');
                    @endphp
                    <tr>
                        <td style="width: 35%; white-space: nowrap; padding: 15px; border: 1px solid #000; font-weight: bold; text-align: center; font-size: 14pt; background-color: #f0f0f0;">
                            合計
                        </td>
                        <td style="padding: 15px; border: 1px solid #000; font-weight: bold; text-align: right; font-size: 14pt;">
                            @if ($total !== "0" && $total !== null)
                            {{ number_format($total) }} 円
                            @endif
                        </td>
                    </tr>
            </table>
        </div>



        <div class="message">
            <table style="width: 100%; font-size: 10pt; border: 1px solid #000; border-collapse: collapse;">
                <tr>
                    <th style="width: 35%; padding: 4px 15px; border: 1px solid #000; text-align: center; background-color: #f0f0f0;">
                        備考
                    </th>
                </tr>
                <tr>
                    <td style="padding: 15px; border: 1px solid #000; font-weight: bold; font-size: 10pt;"> {{ $message ?? '　' }} </td>
                </tr>
            </table>
        </div>


        <div class="billing">
            <div>
                {{ $postal ? '〒' . $postal : '' }}
                {{ $address ?? '' }}
            </div>
            <div>
                {{ $name ?? '' }}
            </div>
            <div>
                {{ $tel ? 'TEL:' . $tel : '' }}
                {{ $fax ? 'FAX:' . $fax : '' }}
            </div>
            <div>
                {{ $mail ? 'Mail:' . $mail : '' }}
                {{ $url ? 'URL:' . $url : '' }}
            </div>
        </div>

        <div class="transfer">
            @if (!empty($transfer_1))
            <strong>【振込先】　</strong><br>
            {{ $transfer_1 }}<br>

            @if (!empty($transfer_2))
            {{ $transfer_2 }}<br>
            @endif

            @if (!empty($transfer_3))
            {{ $transfer_3 }}<br>
            @endif
            @endif
        </div>




</body>

</html>