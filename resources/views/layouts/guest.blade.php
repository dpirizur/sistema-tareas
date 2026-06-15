<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-100 antialiased bg-slate-950">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-slate-700/10 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 flex flex-col items-center">
                <div>
                    <a href="/" wire:navigate>
                        <x-application-logo class="w-20 h-20 fill-current text-white" />
                    </a>
                </div>

                <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-slate-900/90 border border-slate-700 shadow-lg shadow-slate-900/40 overflow-hidden sm:rounded-3xl">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
