@extends('admin.layout')

@section('title', 'Servicios')

@section('styles')
<style>
    [x-cloak] { display: none !important; }
    .scrollbar-thin::-webkit-scrollbar {
        height: 4px;
        width: 4px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 2px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    .services-container {
        max-width: 100%;
        overflow-x: hidden;
    }
    .service-card {
        max-width: 100%;
        word-wrap: break-word;
    }
    .service-header {
        min-width: 0;
    }
    .service-title {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
@endsection

@section('content')
<div 
    x-data="serviceManager()" 
    x-init="init()" 
    class="services-container px-4 sm:px-6 lg:px-8 py-6"
>
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Gestión de Servicios</h1>
        <button 
            @click="openCreateServiceModal()" 
            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nuevo Servicio
        </button>
    </div>

    <!-- Categorías como pestañas -->
    <div class="mb-8 border-b border-gray-200">
        <div class="flex overflow-x-auto py-2 space-x-4 scrollbar-thin">
            <button 
                @click="selectedCategory = 'all'"
                :class="selectedCategory === 'all' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600'"
                class="px-4 py-2 font-medium whitespace-nowrap transition-colors duration-200"
            >
                Todos
            </button>
            @foreach($categories as $category)
                <button 
                    @click="selectedCategory = '{{ $category->id }}'"
                    :class="selectedCategory === '{{ $category->id }}' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600'"
                    class="px-4 py-2 font-medium whitespace-nowrap transition-colors duration-200"
                >
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Listado de servicios por categoría -->
    <div class="space-y-10">
        @foreach($categories as $category)
            <section 
                x-show="selectedCategory === 'all' || selectedCategory === '{{ $category->id }}'"
                x-transition 
                class="space-y-6"
            >
                <div class="flex items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">{{ $category->name }}</h2>
                    <div class="ml-4 h-px bg-gray-200 flex-grow"></div>
                    <span class="ml-3 bg-gray-100 text-gray-600 py-1 px-3 rounded-full text-sm">
                        {{ count($category->services) }} servicios
                    </span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @forelse($category->services as $service)
                        <div class="service-card bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-blue-50 to-white border-b border-gray-200 px-4 py-3">
                                <div class="flex justify-between items-start service-header">
                                    <div class="flex-1 min-w-0 pr-4">
                                        <h3 class="service-title text-lg font-bold text-gray-900">{{ $service->name }}</h3>
                                        @if($service->tagline)
                                            <p class="text-sm text-gray-600 mt-1">{{ $service->tagline }}</p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2 flex-shrink-0">
                                        <button 
                                            @click="openEditServiceModal({{ $service->id }})" 
                                            class="text-blue-600 hover:text-blue-800 p-1"
                                            title="Editar servicio"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form 
                                            method="POST" 
                                            action="{{ route('services.destroy', $service->id) }}" 
                                            onsubmit="return confirm('¿Eliminar este servicio?')" 
                                            class="inline"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="text-red-600 hover:text-red-800 transition-colors p-1"
                                                title="Eliminar servicio"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Cuerpo -->
                            <div class="p-4">
                                @if($service->description)
                                    <div class="mb-4">
                                        <p class="text-gray-700 text-sm">{{ $service->description }}</p>
                                    </div>
                                @endif
                                <div class="space-y-2 mb-4">
                                    @if($service->base_duration_minutes)
                                        <div class="flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-gray-700">Duración: <span class="font-medium">{{ $service->base_duration_minutes }} min</span></span>
                                        </div>
                                    @endif
                                    @if($service->recommended_frequency)
                                        <div class="flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-gray-700">Frecuencia: <span class="font-medium">Cada {{ $service->recommended_frequency }} días</span></span>
                                        </div>
                                    @endif
                                    @if($service->price_label)
                                        <div class="flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            <span class="text-gray-700">Precio: <span class="font-medium">{{ $service->price_label }}</span></span>
                                        </div>
                                    @endif
                                </div>
                                @if($service->exterior_description || $service->interior_description)
                                    <div class="mb-4 border rounded-md">
                                        <div x-data="{ open: false }">
                                            <button @click="open = !open" class="w-full flex justify-between items-center p-3 bg-gray-50 hover:bg-gray-100 text-left">
                                                <span class="font-medium text-sm">Detalles del servicio</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                            <div x-show="open" x-cloak class="p-3 text-sm border-t">
                                                @if($service->exterior_description)
                                                    <div class="mb-2">
                                                        <p class="font-medium text-gray-700">Exterior:</p>
                                                        <p class="text-gray-600">{{ $service->exterior_description }}</p>
                                                    </div>
                                                @endif
                                                @if($service->interior_description)
                                                    <div>
                                                        <p class="font-medium text-gray-700">Interior:</p>
                                                        <p class="text-gray-600">{{ $service->interior_description }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="border rounded-md overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-2 border-b">
                                        <h4 class="text-sm font-medium text-gray-700">Precios por vehículo</h4>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Vehículo</th>
                                                    <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Precio ($)</th>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($vehicleTypes as $vehicle)
                                                    @php
                                                        $priceEntry = $service->serviceVehiclePrices->firstWhere('vehicle_type_id', $vehicle->id);
                                                    @endphp
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-3 py-2 text-gray-700">{{ $vehicle->name }}</td>
                                                        <td class="px-3 py-2 text-right text-gray-700">
                                                            @if($priceEntry)
                                                                <span class="font-medium">{{ number_format($priceEntry->price, 2) }}</span>
                                                            @else
                                                                <span class="text-gray-400">No definido</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-3 py-2 text-center">
                                                            <button 
                                                                @click="openEditPriceModal({{ $service->id }}, {{ $vehicle->id }}, '{{ $priceEntry?->price ?? '' }}')" 
                                                                class="text-blue-600 hover:text-blue-800 p-1"
                                                                title="Editar precio"
                                                            >
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                </svg>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-gray-50 rounded-lg p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <p class="text-gray-500 text-lg">No hay servicios en esta categoría</p>
                            <button
                                @click="openCreateServiceModal()"
                                class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Crear nuevo servicio
                            </button>
                        </div>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>

    <!-- Modal Crear Servicio -->
    <div
        x-show="createServiceModalOpen"
        x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        aria-modal="true" role="dialog"
    >
        <div
            @click.away="closeCreateServiceModal()"
            class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 mx-4"
        >
            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-5">
                <h2 class="text-xl font-bold text-gray-900">Crear Nuevo Servicio</h2>
                <button @click="closeCreateServiceModal()" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('services.store') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Servicio *</label>
                        <input type="text" id="name" name="name" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                        <select id="category_id" name="category_id" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="" disabled selected>Seleccione una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="tagline" class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                        <input type="text" id="tagline" name="tagline"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        <p class="mt-1 text-xs text-gray-500">Breve descripción que aparecerá junto al nombre del servicio</p>
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                    </div>
                    <div>
                        <label for="recommended_frequency" class="block text-sm font-medium text-gray-700 mb-1">Frecuencia Recomendada</label>
                        <input type="text" id="recommended_frequency" name="recommended_frequency" min="0"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    </div>
                    <div>
                        <label for="base_duration_minutes" class="block text-sm font-medium text-gray-700 mb-1">Duración Base (minutos)</label>
                        <input type="number" id="base_duration_minutes" name="base_duration_minutes" min="0"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    </div>
                    <div>
                        <label for="starting_price" class="block text-sm font-medium text-gray-700 mb-1">Precio Inicial ($)</label>
                        <input type="number" step="0.01" id="starting_price" name="starting_price" min="0"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    </div>
                    <div>
                        <label for="price_label" class="block text-sm font-medium text-gray-700 mb-1">Etiqueta de Precio</label>
                        <input type="text" id="price_label" name="price_label"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                        <p class="mt-1 text-xs text-gray-500">Ej: "Desde $99" o "Precios variables"</p>
                    </div>
                    <div class="md:col-span-2">
                        <label for="exterior_description" class="block text-sm font-medium text-gray-700 mb-1">Descripción Exterior</label>
                        <textarea id="exterior_description" name="exterior_description" rows="2"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="interior_description" class="block text-sm font-medium text-gray-700 mb-1">Descripción Interior</label>
                        <textarea id="interior_description" name="interior_description" rows="2"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-5 border-t border-gray-200">
                    <button type="button" @click="closeCreateServiceModal()" class="px-5 py-2.5 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition">Cancelar</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Guardar Servicio</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Servicio -->
    <div
        x-show="editServiceModalOpen"
        x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        aria-modal="true" role="dialog"
    >
        <div 
            @click.away="closeEditServiceModal()" 
            class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 mx-4"
        >
            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-5">
                <h2 class="text-xl font-bold text-gray-900">Editar Servicio</h2>
                <button @click="closeEditServiceModal()" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form :action="`{{ url('/admin/services') }}/${editServiceId}`" method="POST" x-ref="editServiceForm" class="space-y-5">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Servicio *</label>
                        <input type="text" id="edit_name" name="name" x-model="editService.name" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    </div>
                    <div>
                        <label for="edit_category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                        <select id="edit_category_id" name="category_id" x-model="editService.category_id" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">Selecciona categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="edit_tagline" class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                        <input type="text" id="edit_tagline" name="tagline" x-model="editService.tagline"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    </div>
                    <div class="md:col-span-2">
                        <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea id="edit_description" name="description" x-model="editService.description" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                    </div>
                    <div>
                        <label for="edit_recommended_frequency" class="block text-sm font-medium text-gray-700 mb-1">Frecuencia Recomendada</label>
                        <input type="text" id="edit_recommended_frequency" name="recommended_frequency" x-model="editService.recommended_frequency" min="0"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    </div>
                    <div>
                        <label for="edit_base_duration_minutes" class="block text-sm font-medium text-gray-700 mb-1">Duración Base (minutos)</label>
                        <input type="number" id="edit_base_duration_minutes" name="base_duration_minutes" x-model="editService.base_duration_minutes" min="0"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    </div>
                    <div>
                        <label for="edit_starting_price" class="block text-sm font-medium text-gray-700 mb-1">Precio Inicial ($)</label>
                        <input type="number" step="0.01" id="edit_starting_price" name="starting_price" x-model="editService.starting_price" min="0"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    </div>
                    <div>
                        <label for="edit_price_label" class="block text-sm font-medium text-gray-700 mb-1">Etiqueta de Precio</label>
                        <input type="text" id="edit_price_label" name="price_label" x-model="editService.price_label"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    </div>
                    <div class="md:col-span-2">
                        <label for="edit_exterior_description" class="block text-sm font-medium text-gray-700 mb-1">Descripción Exterior</label>
                        <textarea id="edit_exterior_description" name="exterior_description" x-model="editService.exterior_description" rows="2"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="edit_interior_description" class="block text-sm font-medium text-gray-700 mb-1">Descripción Interior</label>
                        <textarea id="edit_interior_description" name="interior_description" x-model="editService.interior_description" rows="2"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-5 border-t border-gray-200">
                    <button type="button" @click="closeEditServiceModal()" class="px-5 py-2.5 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition">Cancelar</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Actualizar Servicio</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Precio -->
    <div
        x-show="editPriceModalOpen"
        x-cloak
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        aria-modal="true" role="dialog"
    >
        <div 
            @click.away="closeEditPriceModal()" 
            class="bg-white rounded-lg shadow-xl max-w-md w-full p-6 mx-4"
        >
            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-5">
                <h2 class="text-xl font-bold text-gray-900">Editar Precio</h2>
                <button @click="closeEditPriceModal()" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form @submit.prevent="savePrice" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Precio ($)</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input 
                            type="number" step="0.01" min="0" x-model="editPriceValue" required
                            class="pl-10 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        />
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-5 border-t border-gray-200">
                    <button type="button" @click="closeEditPriceModal()" class="px-5 py-2.5 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition">Cancelar</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Guardar Precio</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function serviceManager() {
    return {
        services: @json($categories->flatMap->services->keyBy('id')),
        vehicleTypes: @json($vehicleTypes->keyBy('id')),
        createServiceModalOpen: false,
        editServiceModalOpen: false,
        editPriceModalOpen: false,
        selectedCategory: 'all',
        editServiceId: null,
        editService: {},
        editPriceServiceId: null,
        editPriceVehicleId: null,
        editPriceValue: '',
        init() {
            this.$nextTick(() => console.log('Service Manager initialized'));
        },
        openCreateServiceModal() {
            this.createServiceModalOpen = true;
        },
        closeCreateServiceModal() {
            this.createServiceModalOpen = false;
        },
        openEditServiceModal(serviceId) {
            this.editServiceId = serviceId;
            this.editService = JSON.parse(JSON.stringify(this.services[serviceId] || {}));
            this.editServiceModalOpen = true;
        },
        closeEditServiceModal() {
            this.editServiceModalOpen = false;
            this.editServiceId = null;
            this.editService = {};
        },
        openEditPriceModal(serviceId, vehicleId, price) {
            this.editPriceServiceId = serviceId;
            this.editPriceVehicleId = vehicleId;
            this.editPriceValue = price;
            this.editPriceModalOpen = true;
        },
        closeEditPriceModal() {
            this.editPriceModalOpen = false;
            this.editPriceServiceId = null;
            this.editPriceVehicleId = null;
            this.editPriceValue = '';
        },
        savePrice() {
            if (!this.editPriceServiceId || !this.editPriceVehicleId) return;
            const url = `/services/vehicle_prices/${this.editPriceServiceId}/${this.editPriceVehicleId}`;
            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ price: this.editPriceValue }),
            })
            .then(res => { if (!res.ok) throw new Error('Error al guardar'); return res.json(); })
            .then(data => {
                if (data.success) {
                    this.closeEditPriceModal();
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar el precio.');
            });
        }
    }
}
</script>
@endsection