<!DOCTYPE html>
<html lang="es" x-data="{ sidebarExpanded: true }" @keydown.window.escape="sidebarExpanded = false" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Admin - @yield('title', 'Gestor de Citas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-wavraGrayLight font-sans min-h-screen flex text-wavraDark">

    <!-- Sidebar -->
    <aside
    class="sticky top-0 bg-white text-wavraDark shadow h-screen flex flex-col transition-width duration-300 ease-in-out overflow-hidden border-r border-gray-200"
    :class="sidebarExpanded ? 'w-64' : 'w-20'"
    @mouseenter="sidebarExpanded = true" 
    @mouseleave="sidebarExpanded = false"
>
        <!-- Logo y toggle -->
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-300">
            <div class="flex items-center space-x-2">
                <img 
                    src="{{ asset('images/logo-icon.png') }}" 
                    alt="WAVRA Logo" 
                    class="h-8 w-8"
                    x-show="!sidebarExpanded"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-75"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-75"
                >
                <span
                    class="font-bold text-xl text-wavraBlue whitespace-nowrap"
                    x-show="sidebarExpanded"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-5"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-5"
                >
                    WAYRA
                </span>
            </div>

            <button
                @click="sidebarExpanded = !sidebarExpanded"
                aria-label="Toggle sidebar"
                class="focus:outline-none text-wavraBlue hover:text-wavraDark"
            >
                <svg 
                    :class="sidebarExpanded ? 'transform rotate-180' : ''"
                    xmlns="http://www.w3.org/2000/svg" 
                    class="h-6 w-6 transition-transform duration-300" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </div>

        <!-- Navegación -->
        <nav class="flex-grow px-2 py-4 space-y-1">
            @php
                $links = [
                    ['route' => 'admin.dashboard', 'icon' => 'M3 12l2-2 4 4 8-8 4 4', 'label' => 'Dashboard'],
                    ['route' => 'appointments.index', 'icon' => 'M8 7V3M16 7V3M3 11h18M5 19h14a2 2 0 002-2v-5H3v5a2 2 0 002 2z', 'label' => 'Citas'],
                    ['route' => 'services.index', 'icon' => 'M12 6v6l4 2', 'label' => 'Servicios'],
                    ['route' => 'customers.index', 'icon' => 'M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4z M6 20v-2a4 4 0 014-4h4a4 4 0 014 4v2', 'label' => 'Clientes'],
                    ['route' => 'vehicle_types.index', 'icon' => 'M3 11h18v7a2 2 0 01-2 2h-14a2 2 0 01-2-2v-7z M7.5 18.5a2.5 2.5 0 105 0 2.5 2.5 0 00-5 0z M16.5 18.5a2.5 2.5 0 105 0 2.5 2.5 0 00-5 0z', 'label' => 'Tipos Vehículo'],
                    ['route' => 'a_la_carte_services.index', 'icon' => 'M12 4v16m8-8H4', 'label' => 'Extras'],
                    ['route' => 'service_categories.index', 'icon' => 'M4 6h16 M4 12h16 M4 18h16', 'label' => 'Categorías'],
                ];
            @endphp

            @foreach($links as $link)
            <a 
                href="{{ route($link['route']) }}" 
                class="group flex items-center px-3 py-2 rounded-md text-wavraDark hover:bg-wavraBlue hover:text-white transition relative"
                :class="{'bg-wavraBlue text-white font-semibold': '{{ request()->routeIs($link['route'].'*') }}' === '1'}"
                title="{{ $link['label'] }}"
            >
                <svg 
                    class="flex-shrink-0 h-6 w-6 mr-3 group-hover:text-white transition"
                    fill="none" 
                    stroke="currentColor" 
                    stroke-width="2" 
                    viewBox="0 0 24 24" 
                    stroke-linecap="round" 
                    stroke-linejoin="round"
                >
                    <path d="{{ $link['icon'] }}" />
                </svg>

                <span 
                    class="flex-grow truncate whitespace-nowrap overflow-hidden"
                    x-show="sidebarExpanded"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-4"
                >
                    {{ $link['label'] }}
                </span>
            </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-gray-300">
            <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-800 text-white py-2 rounded">Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <!-- Contenido principal -->
    <div class="flex-grow flex flex-col min-h-screen">
        <!-- Header -->
        <header class="bg-white text-wavraDark shadow p-4 flex items-center justify-between">
            <h1 class="text-xl font-semibold">@yield('title', 'Gestor de Citas')</h1>
            <div>
                <!-- Usuario, notificaciones -->
            </div>
        </header>

        <!-- Contenido -->
        <main class="flex-grow p-6 bg-wavraGrayLight">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white text-wavraGray p-4 text-center text-sm">
            © {{ date('Y') }} WAYRA - Deep Down Detail
        </footer>
    </div>

</body>
</html>