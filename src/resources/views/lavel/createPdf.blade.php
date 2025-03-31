<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12pt;
            margin: 20mm;
        }

        .title {
            text-align: center;
            font-size: 20pt;
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 10px 0;
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            vertical-align: top;
            padding: 5px;
        }

        .subject {
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }

        .greeting {
            margin-bottom: 30mm;
        }

        <style>.footer {
            position: fixed;
            bottom: 20mm;
            left: 20mm;
            right: 20mm;
            border-top: 1px solid #000;
            padding-top: 10px;
            font-size: 10pt;
        }
    </style>

    </style>
</head>

<body>
    <div class="title">FAX 送付状</div>

    <table class="info-table">
        <tr>
            <td style="width: 60%;">
                <div>{{ $to ?? '＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿' }}　御中</div>
            </td>
            <td style="width: 40%;">
                <div>
                    送信日：
                    {{ $date_year ?? '　　' }}年
                    {{ $date_month ?? '　' }}月
                    {{ $date_day ?? '　' }}日
                </div>
                <div>
                    送信枚数：
                    {{ $page_count ?? '　' }}枚（当紙含む）
                </div>
            </td>
        </tr>
    </table>

    <div class="subject">
        件名：{{ $subject ?? '＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿' }}
    </div>

    <div class="greeting">
        {!! nl2br(e($message ?? '日頃よりお世話になっております。')) !!}
    </div>

    <div class="footer">
        <div>発信者：</div>
        <div>
            〒{{ $postal ?? '○○○-○○○○' }}　
            {{ $address ?? '○○○○○○○○○○○○○○○○○○○○○○○○○' }}
        </div>
        <div>
            TEL:{{ $tel ?? '000-000-0000' }} ／
            FAX:{{ $fax ?? '000-000-0000' }}
        </div>
    </div>
</body>

</html>