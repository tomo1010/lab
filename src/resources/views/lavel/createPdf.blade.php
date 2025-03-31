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
            /* A4の高さ - 上下マージン（30mm x 2） */
            box-sizing: border-box;
        }

        .title {
            text-align: center;
            font-size: 30pt;
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 20px 0;
            margin-bottom: 40px;
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
            padding-top: 30px;
            margin-bottom: 30mm;
        }

        .footer {
            position: absolute;
            bottom: 60px;
            /* wrapperのpaddingと合わせて */
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
            件名：{{ $subject ?? '' }}
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
    </div>
</body>

</html>