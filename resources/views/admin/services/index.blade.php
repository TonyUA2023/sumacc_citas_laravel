@extends('admin.layout')

@section('title', 'Servicios')

@section('content')
<div x-data="serviceManager()" class="max-w-5xl mx-auto px-4 py-10 space-y-10">

    @if(session('success'))
        <p class="bg-green-100 text-green-700 p-3 rounded-md mb-6 text-center font-medium">{{ session('success') }}</p>
    @endif

    <div class="flex justify-center mb-8">
        <button 
            @click="openCreateServiceModal()" 
            class="bg-wavraBlue text-white px-5 py-2 rounded-md shadow-sm hover:bg-blue-600 transition"
            aria-label="Crear nuevo servicio"
        >
            + Nuevo Servicio
        </button>
    </div>

    @foreach($categories as $category)
    <section class="border-b border-gray-200 pb-6 last:border-none">
        <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b border-gray-300 pb-2">{{ $category->name }}</h2>

        <div class="space-y-6">
            @forelse($category->services as $service)
            <div class="bg-white border border-gray-200 rounded-md shadow-sm p-5">

                <!-- Datos del servicio -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $service->name }}</h3>
                        <p class="text-gray-600 mb-1"><span class="font-semibold">Descripción:</span> {{ $service->description }}</p>
                        <p class="text-gray-600 text-sm mb-0.5"><span class="font-semibold">Frecuencia:</span> {{ $service->recommended_frequency }} días</p>
                        <p class="text-gray-600 text-sm mb-0.5"><span class="font-semibold">Duración base:</span> {{ $service->base_duration_minutes }} min</p>
                        <p class="text-gray-600 text-sm mb-0.5"><span class="font-semibold">Etiqueta Precio:</span> {{ $service->price_label }}</p>
                        <p class="text-gray-600 text-sm"><span class="font-semibold">Tagline:</span> {{ $service->tagline }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm mb-0.5"><span class="font-semibold">Exterior:</span> {{ $service->exterior_description }}</p>
                        <p class="text-gray-600 text-sm mb-4"><span class="font-semibold">Interior:</span> {{ $service->interior_description }}</p>
                        <div class="flex space-x-3">
                            <button 
                                @click="openEditServiceModal({{ $service->id }})" 
                                class="text-wavraBlue hover:text-blue-700 text-sm font-semibold focus:outline-none"
                                aria-label="Editar servicio {{ $service->name }}"
                            >
                                Editar
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
                                    class="text-red-600 hover:text-red-800 text-sm font-semibold focus:outline-none"
                                    aria-label="Eliminar servicio {{ $service->name }}"
                                >
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabla de precios -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border border-gray-200 rounded-md">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 border-b border-gray-200 font-semibold text-gray-700">Vehículo</th>
                                <th class="p-2 border-b border-gray-200 font-semibold text-gray-700 text-right">Precio (S/.)</th>
                                <th class="p-2 border-b border-gray-200 font-semibold text-gray-700 text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicleTypes as $vehicle)
                            @php
                                $priceEntry = $service->serviceVehiclePrices->firstWhere('vehicle_type_id', $vehicle->id);
                            @endphp
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="p-2 border-b border-gray-200 text-gray-800">{{ $vehicle->name }}</td>
                                <td class="p-2 border-b border-gray-200 text-gray-800 text-right">
                                    {{ $priceEntry ? number_format($priceEntry->price, 2) : '-' }}
                                </td>
                                <td class="p-2 border-b border-gray-200 text-center">
                                    <button 
                                        @click="openEditPriceModal({{ $service->id }}, {{ $vehicle->id }}, '{{ $priceEntry?->price ?? '' }}')" 
                                        class="text-wavraBlue hover:text-blue-700 focus:outline-none"
                                        title="Editar precio de {{ $vehicle->name }}"
                                        aria-label="Editar precio del vehículo {{ $vehicle->name }}"
                                    >
                                        ✏️
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            @empty
                <p class="text-gray-500 italic text-center">No hay servicios para esta categoría.</p>
            @endforelse
        </div>
    </section>
    @endforeach


    <!-- Modal Crear Servicio -->
    <div
        x-show="createServiceModalOpen"
        x-transition
        style="display: none"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50"
        aria-modal="true"
        role="dialog"
        aria-labelledby="modal-title-create"
    >
        <div
            @click.away="closeCreateServiceModal()"
            class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[85vh] overflow-y-auto p-6 mx-4"
        >
            <h2 id="modal-title-create" class="text-2xl font-bold text-wavraBlue mb-5">Crear Nuevo Servicio</h2>

            <form method="POST" action="{{ route('services.store') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Servicio</label>
                        <input type="text" id="name" name="name" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <select id="category_id" name="category_id" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition">
                            <option value="" disabled selected>Seleccione una categoría</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:ring-wavraBlue focus:border-wavraBlue transition"></textarea>
                    </div>

                    <div>
                        <label for="recommended_frequency" class="block text-sm font-medium text-gray-700 mb-1">Frecuencia Recomendada (días)</label>
                        <input type="number" id="recommended_frequency" name="recommended_frequency" min="0"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="tagline" class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                        <input type="text" id="tagline" name="tagline"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="base_duration_minutes" class="block text-sm font-medium text-gray-700 mb-1">Duración Base (minutos)</label>
                        <input type="number" id="base_duration_minutes" name="base_duration_minutes" min="0"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="starting_price" class="block text-sm font-medium text-gray-700 mb-1">Precio Inicial (S/.)</label>
                        <input type="number" step="0.01" id="starting_price" name="starting_price" min="0"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="price_label" class="block text-sm font-medium text-gray-700 mb-1">Etiqueta de Precio</label>
                        <input type="text" id="price_label" name="price_label"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div class="md:col-span-2">
                        <label for="exterior_description" class="block text-sm font-medium text-gray-700 mb-1">Descripción Exterior</label>
                        <textarea id="exterior_description" name="exterior_description" rows="2"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:ring-wavraBlue focus:border-wavraBlue transition"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="interior_description" class="block text-sm font-medium text-gray-700 mb-1">Descripción Interior</label>
                        <textarea id="interior_description" name="interior_description" rows="2"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:ring-wavraBlue focus:border-wavraBlue transition"></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" @click="closeCreateServiceModal()" class="px-5 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-5 py-2 bg-wavraBlue text-white rounded-md hover:bg-blue-600 transition">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Servicio -->
    <div
        x-show="editServiceModalOpen"
        x-transition
        style="display: none"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50"
        aria-modal="true"
        role="dialog"
        aria-labelledby="modal-title-edit"
    >
        <div 
            @click.away="closeEditServiceModal()" 
            class="bg-white rounded-md shadow-lg max-w-xl w-full max-h-[85vh] overflow-y-auto p-6 mx-4"
        >
            <h2 id="modal-title-edit" class="text-xl font-semibold mb-5 text-gray-900">Editar Servicio</h2>

            <form :action="`/admin/services/${editServiceId}`" method="POST" x-ref="editServiceForm" class="space-y-4">
                @csrf
                @method('PUT')

                <input type="text" name="name" x-model="editService.name" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                
                <select name="category_id" x-model="editService.category_id" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition">
                    <option value="">Selecciona categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <textarea name="description" x-model="editService.description" rows="3"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:ring-wavraBlue focus:border-wavraBlue transition"></textarea>

                <input type="number" name="recommended_frequency" x-model="editService.recommended_frequency" min="0"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition" />

                <input type="text" name="tagline" x-model="editService.tagline"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition" />

                <input type="number" name="base_duration_minutes" x-model="editService.base_duration_minutes" min="0"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition" />

                <input type="number" step="0.01" name="starting_price" x-model="editService.starting_price" min="0"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition" />

                <input type="text" name="price_label" x-model="editService.price_label"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition" />

                <textarea name="exterior_description" x-model="editService.exterior_description" rows="2"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:ring-wavraBlue focus:border-wavraBlue transition"></textarea>

                <textarea name="interior_description" x-model="editService.interior_description" rows="2"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:ring-wavraBlue focus:border-wavraBlue transition"></textarea>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" @click="closeEditServiceModal()" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-wavraBlue text-white rounded-md hover:bg-blue-600 transition">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Precio -->
    <div
        x-show="editPriceModalOpen"
        x-transition
        style="display: none"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        aria-modal="true"
        role="dialog"
        aria-labelledby="modal-title-price"
    >
        <div @click.away="closeEditPriceModal()" class="bg-white rounded-md shadow-lg max-w-sm w-full p-6 mx-4">
            <h2 id="modal-title-price" class="text-xl font-semibold mb-4 text-gray-900">Editar Precio</h2>

            <form @submit.prevent="savePrice" class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Precio (S/.)</label>
                <input 
                    type="number" step="0.01" min="0" x-model="editPriceValue" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-wavraBlue focus:border-wavraBlue transition"
                />

                <div class="flex justify-end space-x-3 pt-2 border-t border-gray-200">
                    <button type="button" @click="closeEditPriceModal()" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-wavraBlue text-white rounded-md hover:bg-blue-600 transition">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function serviceManager() {
        return {
            createServiceModalOpen: false,
            editServiceModalOpen: false,
            editPriceModalOpen: false,

            editServiceId: null,
            editService: {},

            editPriceServiceId: null,
            editPriceVehicleId: null,
            editPriceValue: '',

            openCreateServiceModal() {
                this.createServiceModalOpen = true;
            },
            closeCreateServiceModal() {
                this.createServiceModalOpen = false;
            },
            openEditServiceModal(serviceId) {
                this.editServiceId = serviceId;
                const service = @json($categories->flatMap->services->keyBy('id'));
                this.editService = service[serviceId] || {};
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

                let url = `/services/vehicle_prices/${this.editPriceServiceId}/${this.editPriceVehicleId}`;

                fetch(url, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ price: this.editPriceValue }),
                })
                .then(res => {
                    if (!res.ok) throw new Error('Error al guardar');
                    return res.json();
                })
                .then(data => {
                    if(data.success) {
                        this.closeEditPriceModal();
                        location.reload();
                    }
                })
                .catch(() => alert('Error al guardar el precio.'));
            }
        }
    }
</script>

@endsection