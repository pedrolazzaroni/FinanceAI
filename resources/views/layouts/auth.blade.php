<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts - Apple System -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-primary-50 via-white to-primary-100 dark:from-primary-950 dark:via-primary-900 dark:to-primary-950 antialiased min-h-screen flex items-center justify-center relative overflow-hidden">
    
    <!-- Background Effects -->
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-[-20%] left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-primary-300/20 blur-3xl"></div>
        <div class="absolute bottom-[-20%] right-[-10%] h-80 w-80 rounded-full bg-info/10 blur-3xl"></div>
        <div class="absolute top-1/3 left-[-10%] h-64 w-64 rounded-full bg-success/10 blur-3xl"></div>
    </div>
    
    <div class="w-full max-w-md">
        <div class="bg-white/80 dark:bg-primary-900/80 backdrop-blur-xl rounded-2xl shadow-2xl p-8 border border-white/20 dark:border-primary-800/50">
            {{ $slot }}
        </div>
    </div>
</body>
</html>