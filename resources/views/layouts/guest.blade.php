<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'Sistema de Gestión Electoral' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gradient-to-r from-blue-50 to-blue-100">
    <x-banner />

    <div class="min-h-screen">
        <div class="flex flex-col lg:flex-row">

            <main class="flex-1 min-h-screen">
                {{ $slot }}

            </main>
        </div>
    </div>

    @stack('modals')

    @livewireScripts
    @stack('js')
</body>

</html>
