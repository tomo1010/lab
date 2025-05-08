<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
            background: url("{{ public_path('template/construction.png') }}") no-repeat center center;
            background-image-resize: 6;
        }

        body {
            margin: 0;
            font-family: ipaexg, sans-serif;
        }

        .content {
            padding: 3cm;
            font-size: 12pt;
            line-height: 1.6;
        }

        .info-table-wrapper {
            display: table;
            margin-top: 3cm;
            margin-left: 3cm;
            margin-right: 2cm;
        }

        .info-table,
        .sender-info table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
        }

        .info-table td,
        .sender-info td {
            padding: 0.3em 1em 0.3em 0;
            vertical-align: top;
        }

        .sender-info {
            margin-top: 1cm;
        }
    </style>
</head>

<body>
    <div class="content">
        <!-- 情報テーブル -->
        <div class="info-table-wrapper">
            <table class="info-table">
                <tr>
                    <td>発行日：{{ $date }}</td>
                    <td>施工年月日：{{ $date }}</td>
                </tr>
                <tr>
                    <td>顧客名：{{ $customer }}</td>
                    <td>車種：{{ $carName }}</td>
                </tr>
                <tr>
                    <td colspan="2">保証期間：{{ $guarantee ?? '' }}</td>
                </tr>
                <tr>
                    <td>車台番号：{{ $frameNumbar }}</td>
                    <td>ボディカラー：</td>
                </tr>
                <tr>
                    <td colspan="2">備考：{{ $note }}</td>
                </tr>
            </table>
        </div>

        <!-- 施工社情報 -->
        <div class="sender-info">
            <table>
                <tr>
                    <td>〒{{ $postal }}<br>{{ $address }}</td>
                </tr>
                <tr>
                    <td colspan="2">{{ $name }}</td>
                </tr>
                <tr>
                    <td colspan="2">TEL：{{ $tel }}　FAX：{{ $fax }}</td>
                </tr>
                <tr>
                    <td>Email：{{ $mail }}　URL：{{ $url }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>