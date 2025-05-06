<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0cm;
        }

        body {
            margin: 0cm;
            font-family: ipaexg, sans-serif;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .content {
            position: relative;
            z-index: 1;
            padding: 3cm;
        }

        .sender-info {
            margin-top: 2cm;
            font-size: 12px;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <!-- 背景画像 -->
    <div class="background">
        <img src="{{ public_path('template/construction.png') }}" width="100%" height="100%">
    </div>

    <!-- 入力されたデータ -->
    <div class="content">
        <p>発行日：{{ $date }}</p>
        <p>顧客名：{{ $customer }}</p>
        <p>備考：{{ $note }}</p>
        <p>施工年月日：{{ $date }}</p>
        <p>保証期間：{{ $guarantee ?? '' }}</p>
        <p>車種：{{ $carName }}</p>
        <p>車台番号：{{ $frameNumbar }}</p>

        <!-- 発信者情報 -->
        <div class="sender-info">
            <p>【発信者情報】</p>
            <p>〒{{ $postal }}</p>
            <p>{{ $address }}</p>
            <p>{{ $name }}</p>
            <p>TEL：{{ $tel }}　FAX：{{ $fax }}</p>
            <p>Email：{{ $mail }}</p>
            <p>URL：{{ $url }}</p>
        </div>
    </div>

</body>

</html>