@extends('admin.layout')

@section('title', 'Calendario de Citas')

@section('content')
<h1 class="text-3xl font-bold mb-8">Calendario de Citas</h1>

<div x-data="appointmentCalendar()" class="space-y-6">

    <!-- Selector de fechas (Semana actual con botones para cambiar semana) -->
    <div class="flex justify-between items-center mb-4 max-w-6xl mx-auto px-4">
        <button @click="prevWeek()" class="bg-gray-300 hover:bg-gray-400 rounded px-4 py-2">Anterior</button>
        <h2 class="text-xl font-semibold" x-text="weekRange"></h2>
        <button @click="nextWeek()" class="bg-gray-300 hover:bg-gray-400 rounded px-4 py-2">Siguiente</button>
    </div>

    <!-- Calendario -->
    <div class="overflow-x-auto max-w-6xl mx-auto px-4">
        <table class="w-full border border-gray-300 border-collapse table-auto">
            <thead>
                <tr>
                    <th class="border border-gray-300 p-2 w-20 text-center">Hora</th>
                    <template x-for="day in days" :key="day.date">
                        <th class="border border-gray-300 p-2 text-center" x-text="day.display"></th>
                    </template>
                </tr>
            </thead>
            <tbody>
                <template x-for="hour in hours" :key="hour">
                    <tr>
                        <td class="border border-gray-300 p-2 text-center font-semibold" x-text="hourLabel(hour)"></td>
                        <template x-for="day in days" :key="day.date">
                            <td class="border border-gray-300 p-1 align-top" style="min-height: 70px;">
                                <template x-for="appointment in getAppointmentsAt(day.date, hour)" :key="appointment.id">
                                    <div
                                        class="rounded p-2 mb-1 cursor-pointer"
                                        :class="{
                                            'bg-yellow-300': appointment.status === 'pendiente',
                                            'bg-blue-300 text-white': appointment.status === 'aceptado',
                                            'bg-green-400 text-white': appointment.status === 'realizado'
                                        }"
                                        @click="openEditModal(appointment)"
                                        x-text="appointmentSummary(appointment)"
                                        title="Click para editar o cambiar estado"
                                    ></div>
                                </template>
                            </td>
                        </template>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- Modal para crear o editar cita -->
    <div
        x-show="modalOpen"
        x-transition
        style="display: none"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div @click.away="closeModal()" class="bg-white rounded-lg p-6 max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-bold mb-4" x-text="modalTitle"></h2>

            <form @submit.prevent="saveAppointment" class="space-y-4">
                <div>
                    <label class="block font-semibold mb-1">Cliente</label>
                    <select x-model="form.customer_id" class="w-full border rounded px-3 py-2" required>
                        <template x-for="customer in customers" :key="customer.id">
                            <option :value="customer.id" x-text="customer.name"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Fecha</label>
                    <input type="date" x-model="form.appointment_date" class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Hora</label>
                    <select x-model="form.appointment_hour" class="w-full border rounded px-3 py-2" required>
                        <template x-for="hour in hours" :key="hour">
                            <option :value="hour" x-text="hourLabel(hour)"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Estado</label>
                    <select x-model="form.status" class="w-full border rounded px-3 py-2" required>
                        <option value="pendiente">Pendiente</option>
                        <option value="aceptado">Aceptado</option>
                        <option value="realizado">Realizado</option>
                    </select>
                </div>

                <div class="flex justify-between items-center">
                    <button type="button" @click="closeModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function appointmentCalendar() {
        return {
            today: new Date(),
            currentMonday: null,
            days: [],
            hours: [7,9,11,13,15,17],
            $appointments = $appointments->map(function($a) {
                return [
                    'id' => $a->id,
                    'customer_name' => $a->customer->name ?? 'N/A',
                    'appointment_date' => $a->appointment_date->format('Y-m-d'),
                    'appointment_hour' => (int) $a->appointment_date->format('H'), // Solo hora en entero
                    'status' => $a->status,
                    'customer_id' => $a->customer_id,
                ];
            });
            modalOpen: false,
            modalTitle: '',
            form: {
                id: null,
                customer_id: '',
                appointment_date: '',
                appointment_hour: 7,
                status: 'pendiente'
            },
            customers: @json($customers),

            init() {
                this.currentMonday = this.getMonday(new Date());
                this.updateDays();
            },
            getMonday(d) {
                d = new Date(d);
                var day = d.getDay(),
                    diff = d.getDate() - day + (day === 0 ? -6 : 1);
                return new Date(d.setDate(diff));
            },
            updateDays() {
                this.days = [];
                for(let i=0; i<7; i++) {
                    let d = new Date(this.currentMonday);
                    d.setDate(d.getDate() + i);
                    this.days.push({
                        date: d.toISOString().split('T')[0],
                        display: d.toLocaleDateString(undefined, { weekday: 'short', day: 'numeric', month: 'short' })
                    });
                }
                this.updateWeekRange();
            },
            updateWeekRange() {
                const start = new Date(this.currentMonday);
                const end = new Date(this.currentMonday);
                end.setDate(end.getDate() + 6);
                this.weekRange = `${start.toLocaleDateString()} - ${end.toLocaleDateString()}`;
            },
            prevWeek() {
                this.currentMonday.setDate(this.currentMonday.getDate() - 7);
                this.updateDays();
            },
            nextWeek() {
                this.currentMonday.setDate(this.currentMonday.getDate() + 7);
                this.updateDays();
            },
            hourLabel(hour) {
                const ampm = hour >= 12 ? 'pm' : 'am';
                const h = hour % 12 === 0 ? 12 : hour % 12;
                return `${h}:00 ${ampm}`;
            },
            getAppointmentsAt(date, hour) {
                return this.appointments.filter(a => a.appointment_date === date && a.appointment_hour === hour);
            },
            appointmentSummary(appointment) {
                return `${appointment.customer_name} (${appointment.status})`;
            },
            openEditModal(appointment) {
                this.modalOpen = true;
                this.modalTitle = 'Editar Cita';
                this.form.id = appointment.id;
                this.form.customer_id = appointment.customer_id;
                this.form.appointment_date = appointment.appointment_date;
                this.form.appointment_hour = appointment.appointment_hour;
                this.form.status = appointment.status;
            },
            closeModal() {
                this.modalOpen = false;
                this.modalTitle = '';
                this.form = {
                    id: null,
                    customer_id: '',
                    appointment_date: '',
                    appointment_hour: 7,
                    status: 'pendiente'
                };
            },
            saveAppointment() {
                let url = this.form.id ? `/appointments/${this.form.id}` : '/appointments';
                let method = this.form.id ? 'PUT' : 'POST';

                let appointmentDateTime = new Date(this.form.appointment_date);
                appointmentDateTime.setHours(this.form.appointment_hour, 0, 0, 0);

                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        customer_id: this.form.customer_id,
                        appointment_date: appointmentDateTime.toISOString(),
                        status: this.form.status
                    })
                }).then(res => {
                    if (!res.ok) throw new Error('Error guardando cita');
                    return res.json();
                }).then(data => {
                    alert('Cita guardada correctamente');
                    location.reload();
                }).catch(() => alert('Error guardando cita'));
            }
        }
    }
</script>
@endsection