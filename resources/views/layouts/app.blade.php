<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Dark mode script (antes do CSS para evitar flash) -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Modal Manager -->
        <script src="{{ asset('js/modal-manager.js') }}"></script>
    </head>
    <body class="h-full bg-gradient-to-br from-primary-50 via-white to-primary-100 dark:from-primary-950 dark:via-primary-900 dark:to-primary-950 antialiased">
        <div class="min-h-full">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/90 dark:bg-primary-900/90 backdrop-blur-xl border-b border-primary-100 dark:border-primary-800 sticky top-16 z-40">
                    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 fade-in">
                {{ $slot }}
            </main>
        </div>

        <!-- Background decorativo -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
            <div class="absolute top-0 left-1/4 w-32 h-32 bg-primary-200/10 dark:bg-primary-800/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-48 h-48 bg-info/5 dark:bg-info/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-0 w-24 h-24 bg-success/5 dark:bg-success/10 rounded-full blur-2xl"></div>
        </div>
    </body>
</html>
