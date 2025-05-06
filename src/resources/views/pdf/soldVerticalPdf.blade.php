<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
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

        .background img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        .vertical-text {
            writing-mode: tb-rl;
            text-orientation: upright;
            font-size: 20pt;
            line-height: 1.8;
            position: absolute;
        }

        .customer-1 {
            top: 5cm;
            left: 4cm;
        }

        .customer-2 {
            top: 5cm;
            left: 8cm;
        }
    </style>
</head>

<body>
    <!-- 背景画像 -->
    <div class="background">
        <img src="{{ public_path('template/baiyakuzumi.png') }}" alt="背景画像">
    </div>

    <!-- 縦書きの顧客名表示 -->
    <div class="content vertical-text customer-1">
        {{ $customer_1 }} 様
    </div>

    <div class="content vertical-text customer-2">
        {{ $customer_2 }} 様
    </div>

</body>

</html>