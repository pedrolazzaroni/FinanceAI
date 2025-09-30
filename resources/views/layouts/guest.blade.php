<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FinanceAI') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

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
    </head>
    <body class="h-full bg-gradient-to-br from-primary-50 via-white to-primary-100 dark:from-primary-950 dark:via-primary-900 dark:to-primary-950 text-primary-900 dark:text-primary-100 antialiased overflow-hidden">
        <div class="h-full flex items-center justify-center p-4 relative">
            <!-- Background decorativo -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-24 -left-24 w-48 h-48 bg-primary-200/20 dark:bg-primary-800/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-primary-300/10 dark:bg-primary-700/10 rounded-full blur-3xl"></div>
                <div class="absolute top-1/3 left-1/4 w-32 h-32 bg-info/5 dark:bg-info/10 rounded-full blur-2xl"></div>
            </div>
            
            <div class="w-full max-w-md z-10">
                <!-- Logo -->
                <div class="text-center mb-8 fade-in">
                    <a href="/" class="inline-flex items-center gap-3 text-primary-900 dark:text-primary-100 hover-lift no-transition group">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-900 text-white text-xl font-semibold shadow-apple dark:bg-primary-100 dark:text-primary-900 group-hover:scale-105 transition-transform">F</span>
                        <span class="text-xl font-semibold tracking-tight">FinanceAI</span>
                    </a>
                </div>

                <!-- Formulário -->
                <div class="card-glass p-6 sm:p-8 shadow-apple-lg backdrop-blur-xl fade-in border border-primary-200/50 dark:border-primary-700/50" style="animation-delay: 0.1s;">
                    {{ $slot }}
                </div>

                <!-- Links auxiliares -->
                <div class="mt-6 text-center fade-in" style="animation-delay: 0.2s;">
                    <a href="/" class="text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-200 font-medium transition-colors hover-lift no-transition inline-flex items-center gap-2">
                        <x-icons.arrow-left class="w-4 h-4" />
                        Voltar ao início
                    </a>
                </div>
            </div>
        </div>

        <!-- Toggle de dark mode (canto superior direito) -->
        <div class="fixed top-4 right-4 z-50">
            <x-dark-mode-toggle />
        </div>
    </body>
</html>
