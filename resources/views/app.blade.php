<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Website Desa Kertayasa') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="/favicon.ico">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
                rel="stylesheet">

        <!-- Meta Tags -->
        <meta name="description"
                content="Website resmi Pemerintah Desa Kertayasa, Kabupaten Kuningan, Jawa Barat. Portal informasi dan layanan digital desa.">
        <meta name="keywords" content="Desa Kertayasa, Kuningan, Pemerintah Desa, Layanan Publik, Transparansi">
        <meta name="author" content="Pemerintah Desa Kertayasa">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ config('app.url') }}">
        <meta property="og:title" content="{{ config('app.name', 'Website Desa Kertayasa') }}">
        <meta property="og:description"
                content="Website resmi Pemerintah Desa Kertayasa, Kabupaten Kuningan, Jawa Barat">
        <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ config('app.url') }}">
        <meta property="twitter:title" content="{{ config('app.name', 'Website Desa Kertayasa') }}">
        <meta property="twitter:description"
                content="Website resmi Pemerintah Desa Kertayasa, Kabupaten Kuningan, Jawa Barat">
        <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
        <!-- Vue.js App Container -->
        <div id="app"></div>

        <!-- Scripts -->
        <script>
                // Make Laravel data available to Vue
                window.Laravel = {
                        csrfToken: '{{ csrf_token() }}',
                        appUrl: '{{ config('app.url') }}',
                        appName: '{{ config('app.name') }}'
                };
        </script>
</body>

</html>
