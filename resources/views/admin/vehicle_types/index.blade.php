@extends('admin.layout')

@section('title', 'Tipos de Vehículo')

@section('content')

<div x-data="vehicleTypeManager()" class="space-y-6">

    <h1 class="text-2xl font-bold mb-6">Tipos de Vehículo</h1>

    @if(session('success'))
        <p class="bg-green-200 text-green-800 p-2 rounded mb-4">{{ session('success') }}</p>
    @endif

    <button @click="openCreateModal()" class="bg-wavraBlue text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">
        Crear Nuevo Tipo
    </button>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($vehicleTypes as $type)
        <div class="bg-white rounded shadow p-4 flex flex-col justify-between">
            <div class="flex items-center space-x-3 mb-4">
                <span class="text-4xl">{{ $type->icon ?? '🚗' }}</span>
                <h2 class="text-xl font-semibold">{{ $type->name }}</h2>
            </div>

            <div class="flex space-x-3">
                <button 
                    @click="openEditModal({{ $type->id }}, '{{ addslashes($type->name) }}', '{{ addslashes($type->icon) }}')" 
                    class="px-3 py-1 bg-wavraBlue text-white rounded hover:bg-blue-700">
                    Editar
                </button>

                <form method="POST" action="{{ route('vehicle_types.destroy', $type->id) }}" onsubmit="return confirm('¿Eliminar este tipo de vehículo?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-800">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal Crear -->
    <div
        x-show="createModalOpen"
        x-transition
        style="display: none"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div @click.away="closeCreateModal()" class="bg-white rounded p-6 w-full max-w-md shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Crear Nuevo Tipo de Vehículo</h2>

            <form method="POST" action="{{ route('vehicle_types.store') }}">
                @csrf
                <input 
                    type="text" 
                    name="name" 
                    placeholder="Nombre del tipo de vehículo" 
                    required 
                    class="w-full border rounded px-3 py-2 mb-4"
                >

                <input 
                    type="text" 
                    name="icon" 
                    placeholder="Icono (emoji o clase CSS)" 
                    class="w-full border rounded px-3 py-2 mb-4"
                >

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="closeCreateModal()" class="px-4 py-2 border rounded hover:bg-gray-100">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-wavraBlue text-white rounded hover:bg-blue-700">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar -->
    <div
        x-show="editModalOpen"
        x-transition
        style="display: none"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div @click.away="closeEditModal()" class="bg-white rounded p-6 w-full max-w-md shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Editar Tipo de Vehículo</h2>

            <form :action="`/admin/vehicle_types/${editId}`" method="POST">
                @csrf
                @method('PUT')
                <input 
                    type="text" 
                    name="name" 
                    x-model="editName"
                    required 
                    class="w-full border rounded px-3 py-2 mb-4"
                >

                <input 
                    type="text" 
                    name="icon" 
                    x-model="editIcon"
                    class="w-full border rounded px-3 py-2 mb-4"
                >

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="closeEditModal()" class="px-4 py-2 border rounded hover:bg-gray-100">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-wavraBlue text-white rounded hover:bg-blue-700">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function vehicleTypeManager() {
        return {
            createModalOpen: false,
            editModalOpen: false,
            editId: null,
            editName: '',
            editIcon: '',

            openCreateModal() {
                this.createModalOpen = true;
            },
            closeCreateModal() {
                this.createModalOpen = false;
            },
            openEditModal(id, name, icon) {
                this.editId = id;
                this.editName = name;
                this.editIcon = icon;
                this.editModalOpen = true;
            },
            closeEditModal() {
                this.editModalOpen = false;
                this.editId = null;
                this.editName = '';
                this.editIcon = '';
            },
        }
    }
</script>

@endsection