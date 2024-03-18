<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>車比較サイトランキング</title>
        <meta content="自動車スペックのデータベース。ミニバン比較ランキング、SUV比較ランキング、軽自動車比較ランキング、ファミリーカー比較ランキング、コンパクトカー比較ランキング" name="description">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    </head>

    <body>

        {{-- ナビゲーションバー --}}
        @include('car.commons.navbar')

        <div class="container">
            {{-- エラーメッセージ --}}
            @include('commons.error_messages')

            @yield('content')
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        {{-- ナビゲーションバー --}}
        @include('car.commons.footer')

    </body>
</html>