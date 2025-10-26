<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5EJXR5D575"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-5EJXR5D575');
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>車比較サイト</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="google-adsense-account" content="ca-pub-8272433810922720">
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

                    <div class="text-left text-sm leading-relaxed space-y-4 mt-4">
                        <p>
                            定番のミニバン。「ワンボックス」や「ファミリーカー」とも呼びます。
                        </p>
                        <p>
                            ３列シートに６人以上乗車、スライドドア搭載、荷物もたくさん積載で
                            ファミリーカーとして大人気。
                        </p>
                        <p>
                            小さな子どもが２人以上の家族ならチャイルドシートが２つでセカンドシートが満席。
                            さらにベビーカーや祖父母もとなると、<span class="underline">ミニバン一択</span>。
                        </p>
                        <p>
                            販売台数も多く、車両価格も高額なため、各メーカーがしのぎを削って優良車種を開発。
                            その結果、<span class="text-yellow-200 font-medium">基本的にはどの車種を選んでもハズレがありません。</span>
                        </p>
                    </div>

                </div>
                <!-- SUV -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #748300;">
                    <img src="{{ asset('img/car_genre_bunner/suv.png') }}" alt="SUV Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/suv" class="text-xl font-medium hover:underline">SUV</a>

                    <div class="text-left text-sm leading-relaxed space-y-4 mt-4">
                        <p>
                            大人気のSUV。クロカンとか四駆（ヨンク）とも言ったりします
                        </p>
                        <p>
                            車高が高く、タイヤが大きく、悪路走破性に優れた車種で、オフロード走行も可能。
                            近年ではオンロード性能も向上し、街乗りでも快適に使用できます。
                        </p>
                        <p>
                            軽自動車から高級SUVまで幅広いラインナップがあり、
                            <span class="underline">ファミリーカーとしても人気</span>です。
                        </p>
                    </div>

                </div>


                <!-- プチバン -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #EF6C70;">
                    <img src="{{ asset('img/car_genre_bunner/puchivan.png') }}" alt="Puchivan Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/puchivan" class="text-xl font-medium hover:underline">プチバン</a>

                    <div class="text-left text-sm leading-relaxed space-y-4 mt-4">
                        <p>
                            スライドドア搭載のコンパクトカーがプチバン。
                        </p>
                        <p>
                            ミニバンに近いのですが、２列シートで５人乗りもしくは４人乗りのコンパクトカーです。
                            <span class="underline">小さな子どもが１人の家族</span>におすすめ。
                        </p>
                        <p>
                            なんだかんだ小回りが効いて
                            <span class="text-yellow-200 font-medium">運転しやすく使い勝手が良いのがプチバンの最大の魅力</span>。
                        </p>
                    </div>
                </div>

                <!-- ハッチバック -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #FFAD35;">
                    <img src="{{ asset('img/car_genre_bunner/hatchback.png') }}" alt="Hatchback Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/hatchback" class="text-xl font-medium hover:underline">ハッチバック</a>
                    <div class="text-left text-sm leading-relaxed space-y-4 mt-4">
                        <p>
                            昔からあるコンパクトカーといえばハッチバック。 </p>
                        <p>
                            ２列シートで５人乗りのコンパクトカーで、トランクが後ろに開くタイプ。
                            初心者向けのエントリーカーもあれば、スポーティな走行性能を持つ車種もあります。
                        </p>
                        <p>
                            最近ではサイズの大きなハッチバックもあります。
                        </p>
                    </div>
                </div>

                <!-- ワゴン -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #90374E;">
                    <img src="{{ asset('img/car_genre_bunner/wagon.png') }}" alt="Wagon Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/wagon" class="text-xl font-medium hover:underline">ステーションワゴン</a>
                    <div class="text-left text-sm leading-relaxed space-y-4 mt-4">
                        <p>
                            ワゴンといえばステーションワゴン。
                        </p>
                        <p>
                            最近はミニバンやSUVに人気を奪われているものの、
                            <span class="underline">荷物をたくさん積める</span>という点では依然として人気があります。
                        </p>
                        <p>
                            不人気ジャンルなので各社とも選べる車種が少ないのが難点。
                        </p>
                    </div>
                </div>

                <!-- セダン -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #3E327B;">
                    <img src="{{ asset('img/car_genre_bunner/sedan.png') }}" alt="Sedan Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/sedan" class="text-xl font-medium hover:underline">セダン</a>
                    <div class="text-left text-sm leading-relaxed space-y-4 mt-4">
                        <p>
                            車の王道スタイルといえばセダン。
                        </p>
                        <p>
                            VIPな感じと落ち着いた大人の印象で、フォルムはやっぱりカッコいい。長距離を乗るならやはりセダンの右に出るジャンルは無いと思います。 </p>
                        <p>
                            残念なのは年々高額化して、なかなか手が出しにくくなっていることでしょうか
                        </p>
                    </div>
                </div>

                <!-- スポーツ -->
                <div class="text-center rounded-lg p-4 text-white shadow-lg" style="background-color: #FE4500;">
                    <img src="{{ asset('img/car_genre_bunner/sports.png') }}" alt="Sports Banner" class="w-[150px] h-[36px] object-contain mx-auto mb-4">
                    <a href="https://www.kurumayalab.com/car/sports" class="text-xl font-medium hover:underline">スポーツ</a>
                    <div class="text-left text-sm leading-relaxed space-y-4 mt-4">
                        <p>
                            コアなファンに愛されるスポーツカー。
                        </p>
                        <p>
                            一度は乗ってみたいと思う人も多いのではないでしょうか。
                        </p>
                        <p>
                            ただし、実用性は低く、荷物を積むスペースも限られています。

                        </p>

                    </div>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-10 text-center mt-10">車のスペック</h2>

            @php
            $iconPath = 'img/car_category_icon/';
            $iconFiles = array_diff(scandir(public_path($iconPath)), ['.', '..']);
            $categories = [
            'https://www.kurumayalab.com/car/minivan',
            'https://www.kurumayalab.com/car/suv',
            'https://www.kurumayalab.com/car/puchivan',
            'https://www.kurumayalab.com/car/hatchback',
            'https://www.kurumayalab.com/car/wagon',
            'https://www.kurumayalab.com/car/sedan',
            'https://www.kurumayalab.com/car/sports',
            ];
            @endphp

            <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 gap-8 mt-10">
                @foreach ($iconFiles as $icon)
                @php
                $randomCategory = $categories[array_rand($categories)];
                @endphp
                <div class="text-center rounded-lg p-4 bg-gray-100 shadow-lg">
                    <a href="{{ $randomCategory }}">
                        <img src="{{ asset($iconPath . $icon) }}" alt="{{ pathinfo($icon, PATHINFO_FILENAME) }} Icon" class="w-[200px] h-[50px] object-contain mx-auto">
                    </a>
                </div>
                @endforeach
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