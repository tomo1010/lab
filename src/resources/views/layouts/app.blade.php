<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8272433810922720"
        crossorigin="anonymous"></script>


    <title>{{ config('app.name', 'クルマ屋ラボ') }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Font Awesome 6.5.0（最新安定版） -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Slick -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('/js/cookie.js') }}"></script>

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased bg-gray-100">

    <div class="min-h-screen flex flex-col">
        <div class="fixed top-0 left-0 right-0 z-50 bg-white shadow">
            @include('layouts.navigation')
        </div>

        <div class="pt-[129px]"></div>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t py-4 text-center text-gray-600 text-sm">
            © 2021–2025
            <a href="https://www.kurumayalab.com" class="text-blue-600 hover:underline" target="_blank">
                https://www.kurumayalab.com
            </a>
            . All rights reserved.
        </footer>
    </div>

    @livewireScripts

    <!-- トップへ戻るボタン -->
    <button id="backToTop"
            class="fixed bottom-3 right-3 lg:bottom-6 lg:right-6 z-50 bg-blue-600 text-white w-10 h-10 lg:w-12 lg:h-12 rounded-full shadow-lg flex items-center justify-center hover:bg-blue-500 transition"
            onclick="window.scrollTo({ top: 0, behavior: 'smooth' })">
        ▲
    </button>
</body>

</html>