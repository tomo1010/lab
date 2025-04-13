<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>車比較サイト</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white font-sans leading-relaxed">

    <!-- ヘッダー -->
    <header class="bg-gray-100 py-10">
        <div class="max-w-screen-xl mx-auto text-center">
            <h1 class="text-3xl font-semibold text-gray-900">車の比較サイト</h1>
            <p class="mt-2 text-lg text-gray-600">あなたのニーズにぴったりな車を見つけましょう</p>
        </div>
    </header>

    <!-- 車のジャンルセクション -->
    <section class="py-16">
        <div class="max-w-screen-xl mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-10 text-center">車のジャンル</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <!-- ミニバン -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #2981C0;">
                    <img src="{{ asset('img/car_genre_bunner/minivan.png') }}" alt="Minivan Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/minivan" class="text-xl font-medium hover:underline">ミニバン</a>
                </div>

                <!-- SUV -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #748300;">
                    <img src="{{ asset('img/car_genre_bunner/suv.png') }}" alt="SUV Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/suv" class="text-xl font-medium hover:underline">SUV</a>
                </div>

                <!-- プチバン -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #EF6C70;">
                    <img src="{{ asset('img/car_genre_bunner/puchivan.png') }}" alt="Puchivan Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/puchivan" class="text-xl font-medium hover:underline">プチバン</a>
                </div>

                <!-- ハッチバック -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #FFAD35;">
                    <img src="{{ asset('img/car_genre_bunner/hatchback.png') }}" alt="Hatchback Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/hatchback" class="text-xl font-medium hover:underline">ハッチバック</a>
                </div>

                <!-- ワゴン -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #90374E;">
                    <img src="{{ asset('img/car_genre_bunner/wagon.png') }}" alt="Wagon Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/wagon" class="text-xl font-medium hover:underline">ワゴン</a>
                </div>

                <!-- セダン -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #3E327B;">
                    <img src="{{ asset('img/car_genre_bunner/sedan.png') }}" alt="Sedan Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/sedan" class="text-xl font-medium hover:underline">セダン</a>
                </div>

                <!-- スポーツ -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #FE4500;">
                    <img src="{{ asset('img/car_genre_bunner/sports.png') }}" alt="Sports Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/sports" class="text-xl font-medium hover:underline">スポーツ</a>
                </div>
            </div>
        </div>
    </section>

    <!-- フッター -->
    <footer class="bg-gray-100 py-10">
        <div class="max-w-screen-xl mx-auto text-center">
            <p class="text-gray-600">© 2025 車比較サイト</p>
        </div>
    </footer>

</body>

</html>