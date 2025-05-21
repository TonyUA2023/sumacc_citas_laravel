<!DOCTYPE html>
<html lang="es" x-data="{ sidebarExpanded: true, sidebarPinned: false }" @keydown.window.escape="if(!sidebarPinned) sidebarExpanded = false" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - @yield('title', 'Gestor de Citas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo/logoHead1.ico') }}" />
    <!-- Agregar Heroicons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.0/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 font-sans min-h-screen flex text-gray-800">

    <!-- Sidebar mejorado -->
    <aside
        class="sticky top-0 bg-white text-gray-800 shadow-lg h-screen flex flex-col transition-all duration-300 ease-in-out overflow-hidden border-r border-gray-200 z-20"
        :class="sidebarExpanded ? 'w-64' : 'w-20'"
        @mouseenter="if(!sidebarPinned) sidebarExpanded = true"
        @mouseleave="if(!sidebarPinned) sidebarExpanded = false"
    >
        <!-- Logo y toggle -->
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
            <div class="flex items-center space-x-2">
                <!-- Logo pequeño visible cuando sidebar comprimido -->
                <div 
                    class="h-10 w-10 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-md overflow-hidden transition-all duration-300"
                    x-show="!sidebarExpanded"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-75"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-75"
                >
                    <img
                        src="{{ asset('logo/logopng.png') }}"
                        alt="WAYRA Logo"
                        class="h-8 w-8 object-contain"
                    />
                </div>

                <!-- Logo grande visible cuando sidebar expandido -->
                <div
                    class="flex items-center space-x-2"
                    x-show="sidebarExpanded"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-x-4"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform -translate-x-4"
                >
                    <img
                        src="{{ asset('logo/logopng.png') }}"
                        alt="WAYRA Logo"
                        class="h-10 w-10 object-contain"
                    />
                    <span class="font-bold text-xl text-blue-600 whitespace-nowrap tracking-wide">
                        WAYRA
                    </span>
                </div>
            </div>

            <!-- Pin button -->
            <div class="flex items-center space-x-1">
                <button
                    @click="sidebarPinned = !sidebarPinned; sidebarExpanded = true"
                    class="focus:outline-none text-gray-500 hover:text-blue-600 transition-colors duration-200"
                    :class="{ 'text-blue-600': sidebarPinned }"
                    x-tooltip="'Fijar menú'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="{ 'text-blue-600 fill-blue-100': sidebarPinned }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7M5 10l7-7 7 7" />
                    </svg>
                </button>
                
                <button
                    @click="sidebarExpanded = !sidebarExpanded"
                    aria-label="Toggle sidebar"
                    class="focus:outline-none text-gray-500 hover:text-blue-600 transition-colors duration-200"
                >
                    <svg
                        :class="sidebarExpanded ? 'transform rotate-180' : ''"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 transition-transform duration-300"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Navegación mejorada -->
        <nav class="flex-grow px-3 py-6 space-y-1 overflow-y-auto scrollbar-thin">
            @php
                $links = [
                    [
                        'route' => 'admin.dashboard', 
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" /></svg>', 
                        'label' => 'Dashboard'
                    ],
                    [
                        'route' => 'appointments.index', 
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>', 
                        'label' => 'Citas'
                    ],
                    [
                        'route' => 'services.index', 
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>', 
                        'label' => 'Servicios'
                    ],
                    [
                        'route' => 'customers.index', 
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>', 
                        'label' => 'Clientes'
                    ],
                    [
                        'route' => 'vehicle_types.index', 
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>', 
                        'label' => 'Tipos Vehículo'
                    ],
                    [
                        'route' => 'a_la_carte_services.index', 
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>', 
                        'label' => 'Extras'
                    ],
                    [
                        'route' => 'service_categories.index', 
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>', 
                        'label' => 'Categorías'
                    ],
                ];
            @endphp

            @foreach($links as $link)
            <a 
                href="{{ route($link['route']) }}" 
                class="group flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-50 transition-all duration-200 relative overflow-hidden"
                :class="{'bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 shadow-md': '{{ request()->routeIs($link['route'].'*') }}' === '1'}"
                title="{{ $link['label'] }}"
            >
                <!-- Efecto de hover -->
                <span class="absolute inset-0 w-1 bg-blue-600 transform -translate-x-full group-hover:translate-x-0 transition-transform ease-in-out duration-300"
                      :class="{'bg-white': '{{ request()->routeIs($link['route'].'*') }}' === '1'}"></span>
                
                <!-- Icono -->
                <div 
                    class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10 transition-transform duration-300 ease-in-out"
                    :class="sidebarExpanded ? '' : 'transform scale-110'"
                >
                    {!! $link['icon'] !!}
                </div>

                <!-- Texto -->
                <span 
                    class="ml-3 whitespace-nowrap font-medium transition-opacity duration-300"
                    x-show="sidebarExpanded"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-x-4"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform translate-x-4"
                >
                    {{ $link['label'] }}
                </span>
                
                <!-- Indicador activo -->
                @if(request()->routeIs($link['route'].'*'))
                <span class="absolute right-2 w-2 h-2 rounded-full bg-white" x-show="sidebarExpanded"></span>
                @endif
            </a>
            @endforeach
        </nav>

        <!-- Logout button mejorado -->
        <div class="p-4 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <form action="{{ route('admin.logout') }}" method="POST" class="inline w-full">
                @csrf
                <button
                  type="submit"
                  class="w-full flex items-center justify-center space-x-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-2.5 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg"
                >
                  <!-- Icono siempre visible -->
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                  </svg>
                  <!-- Texto visible solo si sidebar está expandido -->
                  <span
                    class="font-medium"
                    x-show="sidebarExpanded"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform translate-x-4"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform translate-x-4"
                  >
                    Cerrar sesión
                  </span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Contenido principal -->
    <div class="flex-grow flex flex-col min-h-screen">
        <!-- Header mejorado -->
        <header class="bg-white text-gray-800 shadow-md p-0">
            <div class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-700 text-white shadow-lg">
                <div class="container mx-auto px-4 py-3 flex items-center justify-between">
                    <h2 class="text-lg font-medium text-blue-100">Sistema de Administración</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-blue-100">{{ date('d M, Y') }}</span>
                        <div class="w-px h-6 bg-blue-400"></div>
                        <div class="relative" x-data="{ dropdownOpen: false }">
                            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-blue-800 flex items-center justify-center text-white font-semibold border-2 border-blue-200">
                                    A
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-blue-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            
                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">Mi Perfil</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">Configuración</a>
                                <div class="border-t border-gray-200 my-1"></div>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Cerrar sesión</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-3 flex flex-wrap items-center justify-between">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-800">@yield('title', 'Gestor de Citas')</h1>
                    <nav class="ml-8 hidden md:flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-1 text-sm text-gray-500">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                            </li>
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <span class="text-gray-700 font-medium">@yield('title', 'Gestor de Citas')</span>
                            </li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Componente llamativo del header - Stats cards -->
                <div class="flex mt-4 lg:mt-0 space-x-4 overflow-x-auto pb-2" x-data="{ activeTab: 'today' }">
                    <div class="flex-shrink-0 bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow px-4 py-2 border-l-4 border-green-500">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-full bg-green-500 bg-opacity-20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-green-700">Citas Hoy</p>
                                <p class="text-lg font-bold text-green-900">{{ $todayAppointments ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex-shrink-0 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow px-4 py-2 border-l-4 border-blue-500">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-full bg-blue-500 bg-opacity-20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-blue-700">Total Clientes</p>
                                <p class="text-lg font-bold text-blue-900">{{ $totalCustomers ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex-shrink-0 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow px-4 py-2 border-l-4 border-purple-500">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-full bg-purple-500 bg-opacity-20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-purple-700">Total Citas</p>
                                <p class="text-lg font-bold text-purple-900">{{ $totalAppointments ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenido -->
        <main class="flex-grow p-6 bg-gray-50">
            @yield('content')
        </main>

        <!-- Footer mejorado -->
        <footer class="bg-white border-t border-gray-200">
            <div class="container mx-auto px-6 py-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-500 text-sm">
                        © {{ date('Y') }} WAYRA - Deep Down Detail.
                    </div>
                    <div class="mt-3 md:mt-0 text-gray-500 text-sm">
                        Desarrollado por 
                        <a href="https://www.facebook.com/JstackDigitalSolutions" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800 transition duration-150 underline">
                            Jstack Digital Solutions
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Botón para ir arriba -->
    <button 
        id="backToTop" 
        class="fixed bottom-5 right-5 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 shadow-lg transition-all duration-300 transform translate-y-20 opacity-0 z-50 focus:outline-none"
        onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <script>
        // Mostrar/ocultar botón "volver arriba"
        window.addEventListener('scroll', function() {
            const backToTop = document.getElementById('backToTop');
            if (window.scrollY > 300) {
                backToTop.classList.replace('translate-y-20', 'translate-y-0');
                backToTop.classList.replace('opacity-0', 'opacity-100');
            } else {
                backToTop.classList.replace('translate-y-0', 'translate-y-20');
                backToTop.classList.replace('opacity-100', 'opacity-0');
            }
        });
    </script>
</body>
</html>