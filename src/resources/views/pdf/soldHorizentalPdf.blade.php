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
            position: relative;
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

        .name-box {
            position: absolute;
            font-size: 40pt;
            font-weight: bold;
            text-align: center;
            width: 100%;
        }

        /* 1枚目の名前位置（上の枠） */
        .customer-1 {
            top: 385px;
            /* ※要調整 */
        }

        /* 2枚目の名前位置（下の枠） */
        .customer-2 {
            top: 885px;
            /* ※要調整 */
        }
    </style>
</head>

<body>
    <!-- 背景画像 -->
    <div class="background">
        <img src="{{ public_path('template/baiyakuzumi.png') }}" alt="背景画像">
    </div>

    <!-- 名前配置 -->
    <div class="name-box customer-1">
        {{ $customer_1 }} 様
    </div>
    <div class="name-box customer-2">
        {{ $customer_2 }} 様
    </div>
</body>

</html>