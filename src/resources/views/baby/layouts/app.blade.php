<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Baby In Car</title>
        <meta content="赤ちゃんんが乗ってます　Baby in carステッカーのポータルサイト　マグネット　吸盤　kids in car　ベイビーインカー" name="description">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">-->
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body>


        <header class="mb-4">
            <nav class="bg-gray-800 text-white">
                <div class="max-w-7xl mx-auto px-4 py-2 flex justify-between items-center">
                    {{-- トップページへのリンク --}}
                    <a class="text-lg font-bold" href="/baby">Baby In Car</a>

                    <button type="button" class="md:hidden text-white focus:outline-none" id="navbar-toggle">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>

                    <div class="hidden md:flex space-x-4" id="nav-bar">
                        <ul class="flex space-x-4">
                            {{-- Add your navigation items here --}}
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

<script>
    document.getElementById('navbar-toggle').addEventListener('click', function() {
        const navBar = document.getElementById('nav-bar');
        navBar.classList.toggle('hidden');
        navBar.classList.toggle('flex');
    });
</script>


        <div class="container">
            @yield('content')
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>-->
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
    </body>
</html>