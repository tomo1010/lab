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
        <img src="{{ public_path('template/baiyakuzumi.png') }}" width="100%" height="100%">
    </div>

    <!-- 入力されたデータ -->
    <div class="content">
        <p>{{ $customer }} 様</p>
    </div>

</body>

</html>