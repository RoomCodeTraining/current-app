<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#0a0a0a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>@yield('title', 'Carte de visite') – {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@4.0.0/dist/tailwind.min.css" />
    @endif
    <style>
        .nav-bar { padding-bottom: env(safe-area-inset-bottom, 0); }
        @media (max-width: 767px) {
            main { padding-bottom: calc(6rem + env(safe-area-inset-bottom, 0)) !important; }
        }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen font-sans antialiased">
    <main class="{{ request()->routeIs('home') ? 'max-w-5xl md:min-h-[100dvh] md:flex md:items-center md:overflow-hidden' : '' }} mx-auto px-4 py-5 pb-24 md:pb-8 {{ request()->routeIs('home') ? 'md:py-8' : '' }}">
        @yield('content')
    </main>

    {{-- Navbar en bas : visible uniquement sur mobile / tablette --}}
    <nav class="nav-bar md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 dark:bg-[#161615]/95 border-t border-[#e3e3e0] dark:border-[#3E3E3A] backdrop-blur-sm">
        <div class="max-w-2xl mx-auto flex items-center justify-around h-14">
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center gap-0.5 min-w-[4.5rem] py-2 text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-white transition-colors {{ request()->routeIs('home') ? 'text-[#1b1b18] dark:text-white font-medium' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-xs">Accueil</span>
            </a>
            <a href="{{ route('modifier.index') }}" class="flex flex-col items-center justify-center gap-0.5 min-w-[4.5rem] py-2 text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-white transition-colors {{ request()->routeIs('modifier.*') ? 'text-[#1b1b18] dark:text-white font-medium' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                <span class="text-xs">{{ session('editing_card_id') ? 'Modifier' : 'Mes cartes' }}</span>
            </a>
        </div>
    </nav>
</body>
</html>
