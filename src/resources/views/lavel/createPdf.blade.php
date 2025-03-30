<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: ipaexg;
            /* mpdf推奨フォント。なければ sans-serif に */
        }

        table {
            width: 210mm;
            height: 297mm;
            border-collapse: collapse;
            table-layout: fixed;
        }

        td {
            width: 105mm;
            height: 297mm;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            text-align: center;
            vertical-align: middle;
        }

        .sold {
            font-size: 36px;
            color: red;
            font-weight: bold;
            line-height: 1.4;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td>
                <div class="sold">売<br>約<br>済<br>み</div>
            </td>
            <td>
                <div class="sold">売<br>約<br>済<br>み</div>
            </td>
        </tr>
    </table>
</body>

</html>