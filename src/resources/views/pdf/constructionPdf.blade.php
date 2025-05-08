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

        .certificate-upper,
        .certificate-lower {
            width: 100%;
            position: absolute;
            left: 0;
            padding-left: 0cm;
            padding-right: 2cm;
            font-size: 12pt;
            line-height: 1.6;
        }

        /* 上段用（A4の上半分） */
        .certificate-upper {
            top: 0;
            padding-top: 5cm;
            padding-left: 5cm;
        }

        /* 下段用（A4の下半分） */
        .certificate-lower {
            top: 14.85cm;
            /* A4高さ29.7cmの半分 */
            padding-top: 3.5cm;
            padding-left: 5cm;
        }

        .info-table-wrapper-upper,
        .info-table-wrapper-lower {
            display: table;
            margin-top: 1cm;
        }

        .info-table-upper,
        .info-table-lower,
        .sender-info-upper table,
        .sender-info-lower table {
            width: 60%;
            border-collapse: collapse;
            font-size: 11pt;
        }

        .info-table-upper td,
        .info-table-lower td,
        .sender-info-upper td,
        .sender-info-lower td {
            padding: 0.3em 1em 0.3em 0;
            vertical-align: top;
        }

        .sender-info-upper {
            margin-top: 1cm;
            margin-left: -2cm;
            /* ← 左マージン追加 */

        }

        .sender-info-lower {
            margin-top: 1.2cm;
            margin-left: -2cm;
        }
    </style>
</head>

<body>

    <!-- 上段 -->
    <div class="certificate-upper">
        <div class="info-table-wrapper-upper">
            <table class="info-table-upper">
                <tr>
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

        <div class="sender-info-upper">
            <table>
                <tr>
                    <td>〒{{ $postal }}<br>{{ $address }}</td>
                </tr>
                <tr>
                    <td colspan="2">{{ $name }}</td>
                </tr>
                <tr>
                    <td colspan="2">TEL：{{ $tel }}　FAX：{{ $fax }}<br>
                        Email：{{ $mail }}　URL：{{ $url }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- 下段 -->
    <div class="certificate-lower">
        <div class="info-table-wrapper-lower">
            <table class="info-table-lower">
                <tr>
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

        <div class="sender-info-lower">
            <table>
                <tr>
                    <td>〒{{ $postal }}<br>{{ $address }}</td>
                </tr>
                <tr>
                    <td colspan="2">{{ $name }}</td>
                </tr>
                <tr>
                    <td colspan="2">TEL：{{ $tel }}　FAX：{{ $fax }}<br>
                        Email：{{ $mail }}　URL：{{ $url }}</td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>