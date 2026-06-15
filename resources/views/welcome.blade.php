<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistema de Reserva de Salas</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-slate-700/20 rounded-full blur-3xl"></div>
            </div>

            <div class="relative flex flex-col items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8">
                @auth
                    <!-- Sección de Dashboard para usuarios autenticados -->
                    <div class="w-full max-w-6xl">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h1 class="text-3xl font-bold text-white mb-2">Bienvenido, {{ Auth::user()->name }}</h1>
                                <p class="text-slate-400">Gestiona tus reservas de salas de reunión</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-6 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition duration-300">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Card Stats -->
                            <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-lg p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-slate-400 text-sm">Reservas Activas</p>
                                        <p class="text-2xl font-bold text-white mt-1">0</p>
                                    </div>
                                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-lg p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-slate-400 text-sm">Salas Disponibles</p>
                                        <p class="text-2xl font-bold text-white mt-1">5</p>
                                    </div>
                                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-lg p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-slate-400 text-sm">Hora Actual</p>
                                        <p class="text-2xl font-bold text-white mt-1" id="current-time">--:--</p>
                                    </div>
                                    <svg class="w-10 h-10 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <a href="{{ route('dashboard') }}" class="block bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-6 rounded-lg transition duration-300 text-center">
                                Ir al Dashboard
                            </a>
                            <a href="#" class="block bg-slate-700 hover:bg-slate-600 text-white font-semibold py-4 px-6 rounded-lg transition duration-300 text-center">
                                Consultar Disponibilidad
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Sección de Login/Registro para usuarios NO autenticados -->
                    <div class="max-w-md w-full">
                        <!-- Logo Section -->
                        <div class="text-center mb-8">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 rounded-xl bg-blue-600 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h1 class="text-3xl font-bold text-white mb-2">Reserva de Salas</h1>
                            <p class="text-slate-400 text-sm">Gestiona tus reservas de forma ágil y eficiente</p>
                        </div>

                        <!-- Features Section -->
                        <div class="bg-slate-800/50 backdrop-blur border border-slate-700/50 rounded-lg p-6 mb-8">
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-600/20 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-300 text-sm">Reserva salas en tiempo real</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-600/20 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-300 text-sm">Visualiza disponibilidad</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-600/20 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-300 text-sm">Gestiona tus reservas</p>
                                </div>
                            </div>
                        </div>

                        <!-- Auth Buttons -->
                        <div class="space-y-3">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 text-center shadow-lg">
                                    Iniciar Sesión
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block w-full bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 text-center border border-slate-600">
                                    Crear Cuenta
                                </a>
                            @endif
                        </div>

                        <!-- Footer Text -->
                        <p class="text-center text-slate-500 text-xs mt-6">
                            Al acceder aceptas nuestros términos y condiciones
                        </p>
                    </div>
                @endauth
            </div>
        </div>

        <script>
            function updateTime() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const timeEl = document.getElementById('current-time');
                if (timeEl) {
                    timeEl.textContent = `${hours}:${minutes}`;
                }
            }
            updateTime();
            setInterval(updateTime, 1000);
        </script>
    </body>
</html>
