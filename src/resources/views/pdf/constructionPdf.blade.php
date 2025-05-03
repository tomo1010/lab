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
    </style>

</head>

<body>
    <!-- 背景画像 -->
    <div class="background">
        <img src="{{ public_path('template/construction.png') }}" width="100%" height="100%">
    </div>

    <!-- 入力されたデータ -->
    <div class="content">
        <h1>施工証明書</h1>
        <p>発行日：{{ $date }}</p>
        <p>顧客名：{{ $customer }}</p>
        <p>備考：{{ $note }}</p>
    </div>

</body>

</html>