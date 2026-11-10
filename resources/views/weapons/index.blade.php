<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema de Control de Material Bélico</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-100 min-h-screen relative">
    <!-- Background Image with Overlay -->
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat opacity-20" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <div class="fixed inset-0 bg-gradient-to-br from-stone-900/30 via-stone-800/20 to-stone-900/40"></div>
    
    <!-- Content -->
    <div class="relative z-10">
    <!-- Header -->
    <header class="bg-gray-900 text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="/">
                        <img src="{{ asset('images/logo-ingavi.png') }}" alt="Sistema de Control de Material Bélico" class="w-8 h-8">
                    </a>
                    <a href="/"> 
                        <h1 class="text-2xl font-bold text-lime-700">Sistema de Control de Material Bélico</h1>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('weapons.report') }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Reportes
                    </a>
                    <a href="/admin" class="bg-lime-700 text-white px-4 py-2 rounded-lg hover:bg-lime-800 transition">
                        Panel de Administración
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Search Form Component -->
        <x-weapons.search-form />

        <!-- Weapon Details Component -->
        <x-weapons.weapon-details />

        <!-- Modals -->
        <x-weapons.assign-modal />
        <x-weapons.status-modal />
        <x-weapons.history-modal />
    </main>

    <!-- Scripts Stack -->
    @stack('scripts')
    </div>
</body>
</html>
