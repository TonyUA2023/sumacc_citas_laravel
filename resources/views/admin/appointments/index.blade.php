@extends('admin.layout')

@section('title', 'Listado de Citas')

@section('content')

<style>
/* Colores sólidos para estados en tabla */
.status-pendiente {
    background-color: #f97316; /* Naranja sólido */
    color: white;
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 0.375rem;
    display: inline-block;
    text-align: center;
    min-width: 80px;
}

.status-aceptado {
    background-color: #2563eb; /* Azul sólido */
    color: white;
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 0.375rem;
    display: inline-block;
    text-align: center;
    min-width: 80px;
}

.status-realizado {
    background-color: #16a34a; /* Verde sólido */
    color: white;
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 0.375rem;
    display: inline-block;
    text-align: center;
    min-width: 80px;
}

.status-rechazado {
    background-color: #dc2626; /* Rojo sólido */
    color: white;
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 0.375rem;
    display: inline-block;
    text-align: center;
    min-width: 80px;
}

/* Colores sólidos para estados en FullCalendar */
.fc-event.pendiente {
    background-color: #f97316 !important; /* Naranja sólido */
    border-color: #c6510f !important;
    color: white !important;
    font-weight: 600;
    height: auto !important;
    padding: 8px !important;
    font-size: 0.9rem;
    border-radius: 6px;
}

.fc-event.aceptado {
    background-color: #2563eb !important; /* Azul sólido */
    border-color: #1d4ed8 !important;
    color: white !important;
    font-weight: 600;
    height: auto !important;
    padding: 8px !important;
    font-size: 0.9rem;
    border-radius: 6px;
}

.fc-event.realizado {
    background-color: #16a34a !important; /* Verde sólido */
    border-color: #15803d !important;
    color: white !important;
    font-weight: 600;
    height: auto !important;
    padding: 8px !important;
    font-size: 0.9rem;
    border-radius: 6px;
}

.fc-event.rechazado {
    background-color: #dc2626 !important; /* Rojo sólido */
    border-color: #b91c1c !important;
    color: white !important;
    font-weight: 600;
    height: auto !important;
    padding: 8px !important;
    font-size: 0.9rem;
    border-radius: 6px;
}

/* Aumentar altura mínima de eventos */
.fc-timegrid-event {
    min-height: 50px !important;
}
</style>

<h1 class="text-2xl font-bold mb-6">Calendario Semanal de Citas</h1>
<div id="calendar" class="bg-white rounded shadow p-4 mb-8"></div>

<h1 class="text-2xl font-bold mb-6">Citas</h1>

@if(session('success'))
    <p class="bg-green-200 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</p>
@endif

<div x-data="appointmentManager()">

    <button @click="openCreateAppointmentModal()" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">
        Crear nueva cita
    </button>

    <!-- Tabla con citas -->
    <table class="min-w-full bg-white shadow-md rounded overflow-hidden mb-6">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="py-3 px-4 text-left">ID</th>
                <th class="py-3 px-4 text-left">Servicio</th>
                <th class="py-3 px-4 text-left">Cliente</th>
                <th class="py-3 px-4 text-left">Vehículo</th>
                <th class="py-3 px-4 text-left">Precio</th>
                <th class="py-3 px-4 text-left">Estado</th>
                <th class="py-3 px-4 text-left">Fecha Inicio</th>
                <th class="py-3 px-4 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr class="border-b">
                <td class="py-2 px-4">{{ $appointment->id }}</td>
                <td class="py-2 px-4">{{ $appointment->serviceVehiclePrice->service->name ?? 'N/A' }}</td>
                <td class="py-2 px-4">{{ $appointment->customer->name ?? 'N/A' }}</td>
                <td class="py-2 px-4">{{ $appointment->serviceVehiclePrice->vehicleType->name ?? 'N/A' }}</td>
                <td class="py-2 px-4">${{ number_format($appointment->total_price ?? 0, 2) }}</td>
                <td class="py-2 px-4 border border-gray-200">
                    <span class="
                        @if(strtolower($appointment->status) === 'pendiente') status-pendiente
                        @elseif(strtolower($appointment->status) === 'aceptado') status-aceptado
                        @elseif(strtolower($appointment->status) === 'realizado') status-realizado
                        @elseif(strtolower($appointment->status) === 'rechazado') status-rechazado
                        @else ''
                        @endif
                    ">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </td>
                <td class="py-2 px-4">{{ $appointment->appointment_date->format('d/m/Y H:i') }}</td>
                <td class="py-2 px-4 space-x-2">
                    <button @click="openEditAppointmentModal({{ $appointment->id }})" class="text-yellow-600 hover:underline">Editar</button>
                    <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar esta cita?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Crear Cita -->
    <div
        x-show="createAppointmentModalOpen"
        x-transition
        style="display: none"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div
            @click.away="closeCreateAppointmentModal()"
            class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto p-8 relative mx-4"
        >
            <h2 class="text-3xl font-extrabold text-wavraBlue mb-6">Crear Nueva Cita</h2>

            <form method="POST" action="{{ route('appointments.store') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="customer_id" class="block text-sm font-semibold text-gray-700 mb-1">Cliente</label>
                        <select id="customer_id" name="customer_id" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition">
                            <option value="">Seleccione un cliente</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="service_vehicle_price_id" class="block text-sm font-semibold text-gray-700 mb-1">Servicio / Vehículo</label>
                        <select id="service_vehicle_price_id" name="service_vehicle_price_id" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition">
                            <option value="">Seleccione servicio y vehículo</option>
                            @foreach($serviceVehiclePrices as $svp)
                                <option value="{{ $svp->id }}">{{ $svp->service->name }} / {{ $svp->vehicleType->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="appointment_date" class="block text-sm font-semibold text-gray-700 mb-1">Fecha y hora</label>
                        <input type="datetime-local" id="appointment_date" name="appointment_date" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Estado</label>
                        <select id="status" name="status" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition">
                            <option value="pendiente">Pendiente</option>
                            <option value="aceptado">Aceptado</option>
                            <option value="realizado">Realizado</option>
                            <option value="rechazado">Rechazado</option>
                        </select>
                    </div>

                    <div>
                        <label for="total_price" class="block text-sm font-semibold text-gray-700 mb-1">Precio Total</label>
                        <input type="number" step="0.01" id="total_price" name="total_price"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" @click="closeCreateAppointmentModal()" class="px-6 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-2 bg-wavraBlue text-white rounded-md hover:bg-blue-700 transition">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Cita -->
    <div
        x-show="editAppointmentModalOpen"
        x-transition
        style="display: none"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div
            @click.away="closeEditAppointmentModal()"
            class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto p-8 relative mx-4"
        >
            <h2 class="text-3xl font-extrabold text-wavraBlue mb-6">Editar Cita</h2>

            <form :action="`/admin/appointments/${editAppointmentId}`" method="POST" class="space-y-6" x-ref="editAppointmentForm">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="edit_customer_id" class="block text-sm font-semibold text-gray-700 mb-1">Cliente</label>
                        <select id="edit_customer_id" name="customer_id" x-model="editAppointment.customer_id" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition">
                            <option value="">Seleccione un cliente</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="edit_service_vehicle_price_id" class="block text-sm font-semibold text-gray-700 mb-1">Servicio / Vehículo</label>
                        <select id="edit_service_vehicle_price_id" name="service_vehicle_price_id" x-model="editAppointment.service_vehicle_price_id" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition">
                            <option value="">Seleccione servicio y vehículo</option>
                            @foreach($serviceVehiclePrices as $svp)
                                <option value="{{ $svp->id }}">{{ $svp->service->name }} / {{ $svp->vehicleType->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="edit_appointment_date" class="block text-sm font-semibold text-gray-700 mb-1">Fecha y hora</label>
                        <input type="datetime-local" id="edit_appointment_date" name="appointment_date" x-model="editAppointment.appointment_date" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>

                    <div>
                        <label for="edit_status" class="block text-sm font-semibold text-gray-700 mb-1">Estado</label>
                        <select id="edit_status" name="status" x-model="editAppointment.status" required
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition">
                            <option value="pendiente">Pendiente</option>
                            <option value="aceptado">Aceptado</option>
                            <option value="realizado">Realizado</option>
                            <option value="rechazado">Rechazado</option>
                        </select>
                    </div>

                    <div>
                        <label for="edit_total_price" class="block text-sm font-semibold text-gray-700 mb-1">Precio Total</label>
                        <input type="number" step="0.01" id="edit_total_price" name="total_price" x-model="editAppointment.total_price"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:ring-wavraBlue focus:border-wavraBlue transition" />
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" @click="closeEditAppointmentModal()" class="px-6 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition">
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

<!-- Modal Detalles del evento calendario -->
<div id="appointment-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full shadow-lg">
        <h3 id="modal-title" class="text-xl font-bold mb-4"></h3>
        <div id="modal-body" class="text-gray-700"></div>
        <button id="close-modal" class="mt-6 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cerrar</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Alpine.js state is already on div x-data

    const calendarEl = document.getElementById('calendar');
    const modal = document.getElementById('appointment-modal');
    const modalBody = document.getElementById('modal-body');
    const modalTitle = document.getElementById('modal-title');
    const closeModalBtn = document.getElementById('close-modal');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'es',
        nowIndicator: true,
        allDaySlot: false,
        slotMinTime: "07:00:00",
        slotMaxTime: "19:00:00",

        events: function(fetchInfo, successCallback, failureCallback) {
            fetch("{{ route('appointments.events') }}")
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos del backend para eventos:", data);
                    successCallback(data);
                })
                .catch(error => {
                    console.error('Error al cargar las citas del servidor:', error);
                    failureCallback(error);
                });
        },

        eventClassNames: function(arg) {
            return [(arg.event.extendedProps.status || '').toLowerCase()];
        },

        eventContent: function(arg) {
            const title = arg.event.title || '';
            const customer = arg.event.extendedProps.customer_name || '';
            const vehicle = arg.event.extendedProps.vehicle || '';
            const price = typeof arg.event.extendedProps.total_price === 'number' ? arg.event.extendedProps.total_price : 0;

            return { html: `
                <div>
                    <strong>${title}</strong><br/>
                    Cliente: ${customer}<br/>
                    Vehículo: ${vehicle}<br/>
                    Precio: $${price.toFixed(2)}
                </div>
            `};
        },

        eventClick: function(info) {
            const e = info.event;
            const price = typeof e.extendedProps.total_price === 'number' ? e.extendedProps.total_price : 0;

            modalTitle.textContent = `Cita ID: ${e.id}`;
            modalBody.innerHTML = `
                <p><strong>Servicio:</strong> ${e.title}</p>
                <p><strong>Cliente:</strong> ${e.extendedProps.customer_name || ''}</p>
                <p><strong>Vehículo:</strong> ${e.extendedProps.vehicle || ''}</p>
                <p><strong>Precio:</strong> $${price.toFixed(2)}</p>
                <p>
                    <label for="appointment-status" class="font-semibold">Estado:</label><br/>
                    <select id="appointment-status" class="border border-gray-300 rounded px-2 py-1 w-full">
                        <option value="pendiente" ${e.extendedProps.status === 'pendiente' ? 'selected' : ''}>Pendiente</option>
                        <option value="aceptado" ${e.extendedProps.status === 'aceptado' ? 'selected' : ''}>Aceptado</option>
                        <option value="realizado" ${e.extendedProps.status === 'realizado' ? 'selected' : ''}>Realizado</option>
                        <option value="rechazado" ${e.extendedProps.status === 'rechazado' ? 'selected' : ''}>Rechazado</option>
                    </select>
                </p>
                <p><strong>Fecha Inicio:</strong> ${e.start ? e.start.toLocaleString() : ''}</p>
                <p><strong>Fecha Fin:</strong> ${e.end ? e.end.toLocaleString() : ''}</p>
                <button id="save-status-btn" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar Cambios</button>
            `;

            // Listener para el botón guardar estado
            document.getElementById('save-status-btn').addEventListener('click', () => {
                const select = document.getElementById('appointment-status');
                const newStatus = select.value;

                fetch(`/admin/appointments/${e.id}/update-status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => {
                    if(!response.ok) throw new Error('Error al actualizar el estado');
                    return response.json();
                })
                .then(data => {
                    alert('Estado actualizado correctamente');
                    calendar.refetchEvents(); // refresca calendario para ver cambio
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                })
                .catch(error => {
                    alert('Error al actualizar estado');
                    console.error(error);
                });
            });

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    });

    calendar.render();

    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });
});
</script>

<script>
    function appointmentManager() {
        return {
            createAppointmentModalOpen: false,
            editAppointmentModalOpen: false,

            editAppointmentId: null,
            editAppointment: {},

            openCreateAppointmentModal() {
                this.createAppointmentModalOpen = true;
            },
            closeCreateAppointmentModal() {
                this.createAppointmentModalOpen = false;
            },

            openEditAppointmentModal(id) {
                this.editAppointmentId = id;
                const appointments = @json($appointments->keyBy('id'));
                this.editAppointment = appointments[id] || {};
                if(this.editAppointment.appointment_date) {
                    this.editAppointment.appointment_date = new Date(this.editAppointment.appointment_date).toISOString().slice(0,16);
                }
                this.editAppointmentModalOpen = true;
            },
            closeEditAppointmentModal() {
                this.editAppointmentModalOpen = false;
                this.editAppointmentId = null;
                this.editAppointment = {};
            }
        }
    }
</script>

@endsection