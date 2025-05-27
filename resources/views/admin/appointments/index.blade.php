{{-- resources/views/admin/appointments/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Calendario de Citas')

@section('content')
<style>
    [x-cloak] { display: none !important; }

    /* Estilos personalizados para FullCalendar */
    .fc-theme-standard .fc-scrollgrid { border: 1px solid #e5e7eb; border-radius: 0.5rem; }
    .fc-theme-standard .fc-scrollgrid-section > td { border: none; }
    .fc-col-header-cell {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white; font-weight: 600; padding: 12px 8px;
    }
    .fc-timegrid-slot { height: 60px; border-color: #f3f4f6; }
    .fc-timegrid-axis {
        font-size: 0.875rem; color: #6b7280; background: #f9fafb;
    }

    /* Eventos por estado */
    .fc-event.pendiente { background: linear-gradient(135deg, #f97316, #ea580c) !important; }
    .fc-event.aceptado  { background: linear-gradient(135deg, #3b82f6, #2563eb) !important; }
    .fc-event.realizado{ background: linear-gradient(135deg, #10b981, #059669) !important; }
    .fc-event.rechazado{ background: linear-gradient(135deg, #ef4444, #dc2626) !important; }
    .fc-event { border: none !important; color: white !important; font-weight: 600;
        border-radius: 8px !important; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 4px 8px;
    }

    /* Tabla y badges */
    .status-badge { padding: .375rem .75rem; border-radius: 9999px; font-size: .75rem; font-weight: 600; display: inline-flex; align-items: center; min-width: 80px; justify-content: center; }
    .status-pendiente { background: #fef3c7; color: #d97706; border: 1px solid #fcd34d; }
    .status-aceptado  { background: #dbeafe; color: #1d4ed8; border: 1px solid #93c5fd; }
    .status-realizado{ background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
    .status-rechazado{ background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }

    .table-row:hover { background: #f8fafc; transform: translateY(-1px); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    .table-row { transition: all .2s ease-in-out; }

    .extras-badge { background: linear-gradient(135deg,#8b5cf6,#7c3aed); color:#fff; padding:.25rem .5rem; border-radius:.375rem; font-size:.75rem; font-weight:600; margin-left:.5rem; }

    .custom-scrollbar::-webkit-scrollbar { width:8px; height:8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background:#f1f5f9; border-radius:4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background:#94a3b8; }
</style>

<div x-data="appointmentManager()" class="space-y-8">

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Estadísticas -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Calendario de Citas</h1>
                <p class="text-gray-600">Gestiona y visualiza todas las citas programadas</p>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 w-full lg:w-auto">
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 rounded-lg border-l-4 border-orange-500">
                    <div class="text-2xl font-bold text-orange-700">{{ $appointments->where('status','pendiente')->count() }}</div>
                    <div class="text-sm text-orange-600">Pendientes</div>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg border-l-4 border-blue-500">
                    <div class="text-2xl font-bold text-blue-700">{{ $appointments->where('status','aceptado')->count() }}</div>
                    <div class="text-sm text-blue-600">Aceptadas</div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg border-l-4 border-green-500">
                    <div class="text-2xl font-bold text-green-700">{{ $appointments->where('status','realizado')->count() }}</div>
                    <div class="text-sm text-green-600">Realizadas</div>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg border-l-4 border-red-500">
                    <div class="text-2xl font-bold text-red-700">{{ $appointments->where('status','rechazado')->count() }}</div>
                    <div class="text-sm text-red-600">Rechazadas</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendario -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Vista Semanal</h2>
            <div class="flex items-center space-x-4 text-sm">
                <span class="flex items-center"><div class="w-4 h-4 rounded-full" style="background:linear-gradient(135deg,#f97316,#ea580c)"></div><span>Pendiente</span></span>
                <span class="flex items-center"><div class="w-4 h-4 rounded-full" style="background:linear-gradient(135deg,#3b82f6,#2563eb)"></div><span>Aceptado</span></span>
                <span class="flex items-center"><div class="w-4 h-4 rounded-full" style="background:linear-gradient(135deg,#10b981,#059669)"></div><span>Realizado</span></span>
                <span class="flex items-center"><div class="w-4 h-4 rounded-full" style="background:linear-gradient(135deg,#ef4444,#dc2626)"></div><span>Rechazado</span></span>
            </div>
        </div>
        <div id="calendar" class="rounded-lg overflow-hidden"></div>
    </div>

    <!-- Lista de Citas -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Lista de Citas</h2>
            <button @click="openCreateAppointmentModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Nueva Cita
            </button>
        </div>
        <div class="overflow-x-auto custom-scrollbar">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Servicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vehículo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($appointments as $appointment)
                    <tr class="table-row">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $appointment->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $appointment->serviceVehiclePrice->service->name ?? 'N/A' }}</span>
                                @if($appointment->appointmentExtras->count())
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach($appointment->appointmentExtras as $extra)
                                            <span class="extras-badge">{{ $extra->aLaCarteService->name ?? 'Extra' }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                    {{ strtoupper(substr($appointment->customer->name??'N',0,1)) }}
                                </div>
                                <div>
                                    <div class="font-medium">{{ $appointment->customer->name ?? 'N/A' }}</div>
                                    <div class="text-gray-500 text-xs">{{ $appointment->customer->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="flex items-center"><svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4"/></svg>{{ $appointment->serviceVehiclePrice->vehicleType->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">S/. {{ number_format($appointment->total_price,2) }}</td>
                        <td class="px-6 py-4"><span class="status-badge status-{{ strtolower($appointment->status) }}">{{ ucfirst($appointment->status) }}</span></td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $appointment->appointment_date->format('d/m/Y') }}</span>
                                <span class="text-gray-500 text-xs">{{ $appointment->appointment_date->format('H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium space-x-2">
                            <button @click="openEditAppointmentModal({{ $appointment->id }})" class="text-blue-600 hover:text-blue-900"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                            <form action="{{ route('appointments.destroy',$appointment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar esta cita?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modales Crear y Editar (sin cambios) --}}
    {{-- ... --}}
</div>

<!-- Modal Detalles -->
<div id="appointment-modal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50" role="dialog">
    <div class="bg-white rounded-lg shadow-xl max-w-lg w-full mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 id="modal-title" class="text-xl font-bold text-gray-900"></h3>
            <button id="close-modal" class="text-gray-400 hover:text-gray-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div id="modal-body" class="text-gray-700 space-y-3"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>
<script>
    const appointments = @json($appointments->keyBy('id'));
    function appointmentManager() {
        return {
            createAppointmentModalOpen: false,
            editAppointmentModalOpen: false,
            editAppointmentId: null,
            editAppointment: {},

            openCreateAppointmentModal() { this.createAppointmentModalOpen = true; },
            closeCreateAppointmentModal(){ this.createAppointmentModalOpen = false; },

            openEditAppointmentModal(id) {
                this.editAppointmentId = id;
                this.editAppointment = appointments[id]||{};
                if(this.editAppointment.appointment_date) {
                    this.editAppointment.appointment_date = new Date(this.editAppointment.appointment_date).toISOString().slice(0,16);
                }
                this.editAppointmentModalOpen = true;
            },
            closeEditAppointmentModal(){
                this.editAppointmentModalOpen=false;
                this.editAppointmentId=null;
                this.editAppointment={};
            },
        }
    }

    document.addEventListener('DOMContentLoaded', function(){
        const calendarEl    = document.getElementById('calendar');
        const modal         = document.getElementById('appointment-modal');
        const modalBody     = document.getElementById('modal-body');
        const modalTitle    = document.getElementById('modal-title');
        const closeModalBtn = document.getElementById('close-modal');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            locale:'es',
            nowIndicator:true,
            allDaySlot:false,
            slotMinTime:"07:00:00",
            slotMaxTime:"19:00:00",
            height:600,
            headerToolbar:{
                left:'prev,next today',
                center:'title',
                right:'timeGridWeek,timeGridDay'
            },
            events(fetchInfo, successCallback, failureCallback){
                fetch("{{route('appointments.events')}}")
                  .then(r=>r.json())
                  .then(data=>successCallback(data))
                  .catch(err=>failureCallback(err));
            },
            eventClassNames(arg){
                return [(arg.event.extendedProps.status||'').toLowerCase()];
            },
            eventContent(arg){
                const e = arg.event, props=e.extendedProps;
                const extras=props.extras||[];
                const extrasHtml = extras.length
                    ? `<div class="text-xs opacity-90 mt-1">+${extras.length} extra${extras.length>1?'s':''}</div>`
                    : '';
                return { html:`
                    <div class="p-1">
                        <div class="font-semibold text-xs">${e.title}</div>
                        <div class="text-xs opacity-90">${props.customer_name}</div>
                        <div class="text-xs opacity-90">${props.vehicle}</div>
                        <div class="text-xs font-semibold">S/. ${(+props.total_price||0).toFixed(2)}</div>
                        ${extrasHtml}
                    </div>
                `};
            },
            eventClick(info){
                const e=info.event, props=e.extendedProps;
                let extrasHtml='';
                if(props.extras?.length){
                    extrasHtml=`
                        <div class="bg-purple-50 p-3 rounded-lg mb-4">
                          <p class="font-semibold text-purple-800 mb-2">Servicios Extras:</p>
                          ${props.extras.map(x=>`
                            <div class="flex justify-between text-sm mb-1">
                              <span>${x.name}</span><span class="font-semibold">x${x.quantity}</span>
                            </div>
                          `).join('')}
                        </div>
                    `;
                }
                modalTitle.textContent=`Cita #${e.id}`;
                modalBody.innerHTML=`
                    <div class="space-y-4">
                      <div><p class="font-semibold text-gray-800">Cliente:</p><p class="text-gray-600">${props.customer_name}</p></div>
                      <div><p class="font-semibold text-gray-800">Dirección:</p><p class="text-gray-600">${props.customer_address}</p></div>
                      <div class="grid grid-cols-2 gap-4">
                        <div><p class="font-semibold text-gray-800">Teléfono:</p><p class="text-gray-600">${props.customer_phone}</p></div>
                        <div><p class="font-semibold text-gray-800">Correo:</p><p class="text-gray-600">${props.customer_email}</p></div>
                      </div>
                      <div><p class="font-semibold text-gray-800">Servicio:</p><p class="text-gray-600">${e.title}</p></div>
                      <div><p class="font-semibold text-gray-800">Vehículo:</p><p class="text-gray-600">${props.vehicle}</p></div>
                      ${extrasHtml}
                      <div><p class="font-semibold text-gray-800">Fecha:</p><p class="text-gray-600">${new Date(e.start).toLocaleDateString('es-PE')} ${new Date(e.start).toLocaleTimeString('es-PE',{hour:'2-digit',minute:'2-digit'})}</p></div>
                      <div><label for="appointment-status" class="block font-semibold text-gray-800 mb-2">Estado:</label>
                        <select id="appointment-status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                          <option value="pendiente"${props.status==='pendiente'?' selected':''}>Pendiente</option>
                          <option value="aceptado"${props.status==='aceptado'?' selected':''}>Aceptado</option>
                          <option value="realizado"${props.status==='realizado'?' selected':''}>Realizado</option>
                          <option value="rechazado"${props.status==='rechazado'?' selected':''}>Rechazado</option>
                        </select>
                      </div>
                      <div class="flex justify-end pt-4">
                        <button id="save-status-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Guardar Cambios</button>
                      </div>
                    </div>
                `;
                document.getElementById('save-status-btn').onclick = ()=>{
                    fetch(`/admin/appointments/${e.id}/update-status`,{
                        method:'PUT',
                        headers:{
                          'Content-Type':'application/json',
                          'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body:JSON.stringify({status:document.getElementById('appointment-status').value})
                    })
                    .then(r=>r.json())
                    .then(()=>{
                        calendar.refetchEvents();
                        modal.classList.replace('flex','hidden');
                    })
                    .catch(console.error);
                };
                modal.classList.replace('hidden','flex');
            }
        });

        calendar.render();
        closeModalBtn.addEventListener('click',()=>modal.classList.replace('flex','hidden'));
    });
</script>
@endsection