<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Palácio Mental') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&family=cinzel:400,500,600,700&family=playfair-display:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        <main class="flex-1">
            {{ $slot }}
        </main>

        <footer class="bg-palacio-roxo text-palacio-bege/80 text-center py-6 text-sm font-serif tracking-wider">
            Palácio Mental &middot; Fatec Praia Grande &middot; 2026
        </footer>
    </div>
</body>
</html>
