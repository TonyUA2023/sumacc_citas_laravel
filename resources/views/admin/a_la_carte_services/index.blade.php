@extends('admin.layout')

@section('title', 'Servicios a la Carta')

@section('content')
<h1 class="text-2xl font-bold mb-6">Servicios a la Carta</h1>

@if(session('success'))
    <p class="bg-green-200 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</p>
@endif

<div x-data="aLaCarteServiceManager()">

    <button @click="openCreateServiceModal()" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">
        Crear nuevo servicio a la carta
    </button>

    <table class="min-w-full bg-white shadow-md rounded overflow-hidden">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="py-3 px-4 text-left">Nombre</th>
                <th class="py-3 px-4 text-left">Descripción</th>
                <th class="py-3 px-4 text-left">¿Variable?</th>
                <th class="py-3 px-4 text-left">Precio (S/.)</th>
                <th class="py-3 px-4 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr class="border-b">
                <td class="py-2 px-4">{{ $service->name }}</td>
                <td class="py-2 px-4">{{ $service->description }}</td>
                <td class="py-2 px-4">{{ $service->is_variable ? 'Sí' : 'No' }}</td>
                <td class="py-2 px-4">{{ number_format($service->price, 2) }}</td>
                <td class="py-2 px-4 space-x-2">
                    <button @click="openEditServiceModal({{ $service->id }})" class="text-yellow-600 hover:underline">Editar</button>
                    <form action="{{ route('a_la_carte_services.destroy', $service->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este servicio?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $services->links() }}
    </div>

    <!-- Modal Crear Servicio -->
    <div
        x-show="createServiceModalOpen"
        x-transition
        style="display: none"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div
            @click.away="closeCreateServiceModal()"
            class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto p-8 relative mx-4"
        >
            <h2 class="text-3xl font-extrabold text-wavraBlue mb-6">Crear Servicio a la Carta</h2>

            <form method="POST" action="{{ route('a_la_carte_services.store') }}" class="space-y-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                        <input type="text" id="name" name="name" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 resize-none focus:ring-wavraBlue focus:border-wavraBlue transition"></textarea>
                    </div>

                    <div class="flex items-center space-x-4">
                        <label for="is_variable" class="text-sm font-semibold text-gray-700">¿Variable?</label>
                        <input type="checkbox" id="is_variable" name="is_variable" class="h-5 w-5" />
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Precio (S/.)</label>
                        <input type="number" step="0.01" id="price" name="price" min="0" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" @click="closeCreateServiceModal()" class="px-6 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-2 bg-wavraBlue text-white rounded-md hover:bg-blue-700 transition">
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
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div
            @click.away="closeEditServiceModal()"
            class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto p-8 relative mx-4"
        >
            <h2 class="text-3xl font-extrabold text-wavraBlue mb-6">Editar Servicio a la Carta</h2>

            <form :action="`/admin/a_la_carte_services/${editServiceId}`" method="POST" class="space-y-6" x-ref="editServiceForm">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                        <input type="text" id="edit_name" name="name" x-model="editService.name" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="edit_description" class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                        <textarea id="edit_description" name="description" rows="3" x-model="editService.description"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 resize-none focus:ring-wavraBlue focus:border-wavraBlue transition"></textarea>
                    </div>

                    <div class="flex items-center space-x-4">
                        <label for="edit_is_variable" class="text-sm font-semibold text-gray-700">¿Variable?</label>
                        <input type="checkbox" id="edit_is_variable" name="is_variable" x-model="editService.is_variable" class="h-5 w-5" />
                    </div>

                    <div>
                        <label for="edit_price" class="block text-sm font-semibold text-gray-700 mb-1">Precio (S/.)</label>
                        <input type="number" step="0.01" id="edit_price" name="price" min="0" x-model="editService.price" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" @click="closeEditServiceModal()" class="px-6 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-2 bg-wavraBlue text-white rounded-md hover:bg-blue-700 transition">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function aLaCarteServiceManager() {
        return {
            createServiceModalOpen: false,
            editServiceModalOpen: false,

            editServiceId: null,
            editService: {},

            openCreateServiceModal() {
                this.createServiceModalOpen = true;
            },
            closeCreateServiceModal() {
                this.createServiceModalOpen = false;
            },

            openEditServiceModal(id) {
                this.editServiceId = id;
                const services = @json($services->keyBy('id'));
                this.editService = services[id] || {};
                this.editServiceModalOpen = true;
            },
            closeEditServiceModal() {
                this.editServiceModalOpen = false;
                this.editServiceId = null;
                this.editService = {};
            }
        }
    }
</script>
@endsection