@extends('admin.layout')

@section('title', 'Listado de Clientes')

@section('content')
<h1 class="text-2xl font-bold mb-6">Clientes</h1>

@if(session('success'))
    <p class="bg-green-200 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</p>
@endif

<div x-data="customerManager()">

    <button @click="openCreateCustomerModal()" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">
        Crear nuevo cliente
    </button>

    <table class="min-w-full bg-white shadow-md rounded overflow-hidden">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="py-3 px-4 text-left">Nombre</th>
                <th class="py-3 px-4 text-left">Teléfono</th>
                <th class="py-3 px-4 text-left">Email</th>
                <th class="py-3 px-4 text-left">Dirección</th>
                <th class="py-3 px-4 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr class="border-b">
                <td class="py-2 px-4">{{ $customer->name }}</td>
                <td class="py-2 px-4">{{ $customer->phone_number }}</td>
                <td class="py-2 px-4">{{ $customer->email }}</td>
                <td class="py-2 px-4">{{ $customer->address }}</td>
                <td class="py-2 px-4 space-x-2">
                    <button @click="openEditCustomerModal({{ $customer->id }})" class="text-yellow-600 hover:underline">Editar</button>
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este cliente?')">
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
        {{ $customers->links() }}
    </div>

    <!-- Modal Crear Cliente -->
    <div
        x-show="createCustomerModalOpen"
        x-transition
        style="display: none"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div
            @click.away="closeCreateCustomerModal()"
            class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto p-8 relative mx-4"
        >
            <h2 class="text-3xl font-extrabold text-wavraBlue mb-6">Crear Nuevo Cliente</h2>

            <form method="POST" action="{{ route('customers.store') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                        <input type="text" id="name" name="name" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                        <input type="text" id="phone_number" name="phone_number"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">Dirección</label>
                        <textarea id="address" name="address" rows="3"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 resize-none focus:ring-wavraBlue focus:border-wavraBlue transition"></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" @click="closeCreateCustomerModal()" class="px-6 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-2 bg-wavraBlue text-white rounded-md hover:bg-blue-700 transition">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Cliente -->
    <div
        x-show="editCustomerModalOpen"
        x-transition
        style="display: none"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div
            @click.away="closeEditCustomerModal()"
            class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto p-8 relative mx-4"
        >
            <h2 class="text-3xl font-extrabold text-wavraBlue mb-6">Editar Cliente</h2>

            <form :action="`/admin/customers/${editCustomerId}`" method="POST" class="space-y-6" x-ref="editCustomerForm">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                        <input type="text" id="edit_name" name="name" x-model="editCustomer.name" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="edit_phone_number" class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                        <input type="text" id="edit_phone_number" name="phone_number" x-model="editCustomer.phone_number"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="edit_email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" id="edit_email" name="email" x-model="editCustomer.email"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div class="md:col-span-2">
                        <label for="edit_address" class="block text-sm font-semibold text-gray-700 mb-1">Dirección</label>
                        <textarea id="edit_address" name="address" rows="3" x-model="editCustomer.address"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 resize-none focus:ring-wavraBlue focus:border-wavraBlue transition"></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" @click="closeEditCustomerModal()" class="px-6 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition">
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
    function customerManager() {
        return {
            createCustomerModalOpen: false,
            editCustomerModalOpen: false,

            editCustomerId: null,
            editCustomer: {},

            openCreateCustomerModal() {
                this.createCustomerModalOpen = true;
            },
            closeCreateCustomerModal() {
                this.createCustomerModalOpen = false;
            },

            openEditCustomerModal(id) {
                this.editCustomerId = id;
                const customers = @json($customers->keyBy('id'));
                this.editCustomer = customers[id] || {};
                this.editCustomerModalOpen = true;
            },
            closeEditCustomerModal() {
                this.editCustomerModalOpen = false;
                this.editCustomerId = null;
                this.editCustomer = {};
            }
        }
    }
</script>
@endsection