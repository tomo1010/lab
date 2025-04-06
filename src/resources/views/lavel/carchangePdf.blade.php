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
            font-size: 30pt;
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

        .recipient {
            margin-top: 20px;
            font-size: 12pt;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 80px;
        }

        .subject {
            border-bottom: 1px solid #000;
            margin-top: 20px;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }

        .greeting {
            padding-top: 30px;
            margin-bottom: 30mm;
        }

        .footer {
            position: absolute;
            bottom: 60px;
            left: 60px;
            right: 60px;
            border-top: 1px solid #000;
            padding-top: 10px;
            font-size: 10pt;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="title">FAX 送付状<br>車両入替えのご依頼</div>

        <div class="right-align-small">
            送信日：
            {{ $send_date ?? '　　' }}
        </div>

        <div class="right-align-small">
            送信枚数：
            {{ $page_count ?? '　' }}枚 (当紙含む)
        </div>

        <div class="recipient">
            <div>{{ $to ?? '＿＿＿＿＿＿＿＿＿＿＿＿＿' }}　{{ $to_suffix ?? '様' }}
            </div>
        </div>

        <!-- 車両入替え情報（タイトル行なし・シンプル表示） -->
        <table width="100%" border="1" cellspacing="0" cellpadding="10" style="margin-bottom: 16px;">
            <tr>
                <td width="30%">お客様名</td>
                <td>{{ $subject }}</td>
            </tr>
            <tr>
                <td>納車予定日</td>
                <td>{{ $carchenge_date ? \Carbon\Carbon::parse($carchenge_date)->format('Y年 n/j') : '' }}</td>
            </tr>
            <tr>
                <td>車両金額</td>
                <td>{{ $carchenge_price ? $carchenge_price . ' 万円' : '' }}</td>
            </tr>
            <tr>
                <td>乗換え前の車両</td>
                <td>{{ $beforecar }}</td>
            </tr>
        </table>






        <div class="greeting">
            {!! nl2br(e($message ?? '日頃よりお世話になっております。')) !!}
        </div>

        <div class="footer">
            <div>発信者：</div>
            <div>
                {{ $postal ? '〒' . $postal : '' }}
                {{ $address ?? '' }}
            </div>
            <div>
                {{ $name ?? '' }}
            </div>
            <div>
                {{ $tel ? 'TEL:' . $tel : '' }}
                {{ $tel ? 'FAX:' . $fax : '' }}
            </div>
            <div>
                {{ $mail ? 'Mail:' . $mail : '' }}
                {{ $url ? 'URL:' . $url : '' }}
            </div>
        </div>
    </div>
</body>

</html>