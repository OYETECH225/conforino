@props([
    'seo' => [],
    'jsonLd' => null,
])

<!doctype html>
<html lang="fr" class="touch-pan-y overflow-x-clip overflow-y-auto overscroll-x-none">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $seo['title'] ?? "CONFOR'INO" }}</title>
    @if(!empty($seo['description']))
        <meta name="description" content="{{ $seo['description'] }}">
    @endif
    <meta name="robots" content="{{ $seo['robots'] ?? 'noindex,follow' }}">
    <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="CONFOR'INO">
    <meta property="og:title" content="{{ $seo['title'] ?? "CONFOR'INO" }}">
    @if(!empty($seo['description']))
        <meta property="og:description" content="{{ $seo['description'] }}">
    @endif
    <meta property="og:url" content="{{ $seo['canonical'] ?? url()->current() }}">
    @if(!empty($seo['ogImage']))
        <meta property="og:image" content="{{ $seo['ogImage'] }}">
    @endif

    <link rel="icon" href="{{ asset('favicon-32x32.png') }}" sizes="32x32" type="image/png">
    <link rel="icon" href="{{ asset('favicon-192x192.png') }}" sizes="192x192" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;1,9..144,400;1,9..144,500&display=swap" rel="stylesheet">

    @if(!empty($jsonLd))
        <script type="application/ld+json">{!! $jsonLd !!}</script>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @filamentStyles
    @livewireStyles
</head>
<body class="touch-pan-y overflow-x-clip overflow-y-auto overscroll-x-none bg-white text-navy">
    <a href="#contenu" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-turquoise focus:text-white focus:px-4 focus:py-2">
        Aller au contenu
    </a>

    <x-landing-header :settings="$settings" />

    <main id="contenu">
        {{ $slot }}
    </main>

    <x-landing-footer :settings="$settings" />

    <x-cookie-banner :settings="$settings" />

    @filamentScripts
    @livewireScripts
    @vite('resources/js/app.js')
</body>
</html>
