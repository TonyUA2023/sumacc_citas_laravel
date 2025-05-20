@extends('public.layout')

@section('content')

{{-- Hero --}}
<section class="hero bg-red-600 text-white py-12 text-center">
    <h1 class="text-4xl font-bold mb-4">Reserva tu Servicio</h1>
    <p class="text-lg max-w-3xl mx-auto">Selecciona tu vehículo para conocer precios, luego completa tus datos y agenda tu cita.</p>
</section>

<div class="flex flex-col lg:flex-row gap-8 p-6">

    {{-- Formulario y selección izquierda --}}
    <div class="lg:w-2/3 space-y-8">

        {{-- Servicio seleccionado --}}
        <section class="p-4 border rounded">
            <h2 class="text-2xl font-bold mb-2">Servicio seleccionado</h2>
            <p class="font-semibold">{{ $service->name }}</p>
            <p>{{ $service->tagline }}</p>
            <p>{{ $service->exterior_description }}</p>
            <p>{{ $service->interior_description }}</p>
        </section>

        <form id="booking-form" method="POST" action="{{ route('public.book.store') }}" class="mx-16">
            @csrf

            <input type="hidden" name="service_id" value="{{ $service->id }}">
            <input type="hidden" name="customer_id" id="customer_id" value="">
            <input type="hidden" name="appointment_date" id="appointment_date_hidden" value="">
            <input type="hidden" name="appointment_time" id="appointment_time_hidden" value="">

            {{-- Paso 1: Selección de vehículo --}}
            <section id="step-vehicle" class="p-6 border rounded shadow-lg bg-gray-50">
                <h2 class="text-xl font-bold mb-6">Selecciona tu vehículo</h2>

                <div id="vehicle-options" class="space-y-4">
                    @foreach($vehiclePrices as $vp)
                    <label
                        class="flex items-center justify-between p-4 border rounded cursor-pointer hover:bg-red-100 transition duration-300 ease-in-out"
                        style="user-select:none;"
                        data-price="{{ $vp->price }}">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="vehicle_price_id" value="{{ $vp->id }}" class="mr-4 w-5 h-5" required>
                            <div>
                                <div class="font-semibold text-lg">{{ $vp->vehicleType->name }}</div>
                                <div class="text-gray-600">${{ number_format($vp->price, 2) }}</div>
                            </div>
                        </div>

                        <div class="text-4xl select-none" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                            {{ $vp->vehicleType->icon }}
                        </div>
                    </label>
                    @endforeach
                </div>

                <div id="vehicle-selected" class="hidden p-4 border rounded bg-white shadow-md flex items-center justify-between">
                    <div>
                        <div class="font-semibold text-lg" id="selected-vehicle-name"></div>
                        <div class="text-gray-600" id="selected-vehicle-price"></div>
                    </div>
                    <div id="selected-vehicle-icon" class="text-6xl select-none" style="width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;"></div>
                    <button type="button" id="change-vehicle" class="ml-4 text-red-600 hover:underline font-semibold">Cambiar vehículo</button>
                </div>
            </section>

            {{-- Paso 2: Servicios extra --}}
            <section id="step-extras" class="p-6 border rounded mt-6 hidden">
                <h2 class="text-xl font-bold mb-4">Servicios extra</h2>
                <div id="extra-services" class="flex flex-wrap gap-4 mb-6">
                    @foreach($extraServices as $extra)
                    <label
                        class="extra-btn flex flex-col items-center justify-center border rounded cursor-pointer px-4 py-3 select-none transition-colors duration-300"
                        data-price="{{ $extra->price }}">
                        <input type="checkbox" name="extras[]" value="{{ $extra->id }}" class="hidden" />
                        <span class="font-semibold">{{ $extra->name }}</span>
                        <span>${{ number_format($extra->price, 2) }}</span>
                    </label>
                    @endforeach
                </div>
            </section>

            {{-- Paso 3: Selección de fecha y hora --}}
            <section id="step-datetime" class="p-6 border rounded mt-6 hidden">
                <h2 class="text-xl font-bold mb-4">Selecciona fecha y hora</h2>

                <div id="calendar-container" class="overflow-x-auto">
                    <table class="table-auto border-collapse border border-gray-300 w-full text-center">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-2 py-1">Día</th>
                                <th class="border border-gray-300 px-2 py-1">7 AM</th>
                                <th class="border border-gray-300 px-2 py-1">9 AM</th>
                                <th class="border border-gray-300 px-2 py-1">11 AM</th>
                                <th class="border border-gray-300 px-2 py-1">1 PM</th>
                                <th class="border border-gray-300 px-2 py-1">3 PM</th>
                                <th class="border border-gray-300 px-2 py-1">5 PM</th>
                            </tr>
                        </thead>
                        <tbody id="calendar-body">
                            {{-- JS llenará esta tabla con días y botones de horario --}}
                        </tbody>
                    </table>
                </div>
            </section>
        </form>

        {{-- Formulario cliente separado, oculto inicialmente --}}
        <section id="client-info" class="p-4 border rounded mt-8 hidden">
            <h2 class="text-xl font-bold mb-4">Tus datos (obligatorios)</h2>

            <form id="client-form" class="flex flex-col gap-6" onsubmit="return false;">
                <div class="flex flex-col">
                    <label for="client-name" class="mb-1 font-semibold">Nombre completo</label>
                    <input type="text" name="name" id="client-name" placeholder="Nombre completo" class="w-full p-2 border rounded" required>
                </div>

                <div class="flex flex-col">
                    <label for="client-email" class="mb-1 font-semibold">Correo electrónico</label>
                    <input type="email" name="email" id="client-email" placeholder="Correo electrónico" class="w-full p-2 border rounded" required>
                </div>

                <div class="flex flex-col">
                    <label for="client-phone" class="mb-1 font-semibold">Teléfono</label>
                    <input type="text" name="phone" id="client-phone" placeholder="Teléfono" class="w-full p-2 border rounded" required>
                </div>

                <div class="flex flex-col">
                    <label for="client-address" class="mb-1 font-semibold">Dirección</label>
                    <input type="text" name="address" id="client-address" placeholder="Dirección" class="w-full p-2 border rounded" required>
                </div>

                <button id="save-client-btn" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition mt-4" type="submit">
                    Guardar datos
                </button>

                <p id="client-save-message" class="mt-2 text-sm text-red-600"></p>
            </form>
        </section>

    </div>

    {{-- Resumen derecho --}}
    <div class="lg:w-1/3 p-4 border rounded sticky top-20 h-max flex flex-col">
        <h2 class="text-2xl font-bold mb-4">Resumen del pedido</h2>
        <div id="order-summary" class="space-y-2 flex-grow">
            <p><strong>Servicio:</strong> <span id="summary-service">{{ $service->name }}</span></p>
            <p><strong>Vehículo:</strong> <span id="summary-vehicle">No seleccionado</span></p>
            <p><strong>Extras:</strong> <span id="summary-extras">Ninguno</span></p>
            <p><strong>Cliente:</strong> <span id="summary-customer">No ingresado</span></p>
            <p><strong>Fecha y hora:</strong> <span id="summary-datetime">No seleccionada</span></p>
            <p class="font-bold text-lg"><strong>Total:</strong> $<span id="summary-total">0.00</span></p>
        </div>
        <p id="booking-error-msg" class="text-red-600 mt-2"></p>
        <button id="book-appointment-btn" class="mt-6 bg-red-600 text-white py-3 px-6 rounded hover:bg-red-700 disabled:opacity-50" disabled>Agendar cita</button>
    </div>

</div>

{{-- Modal para resumen y confirmación --}}
<div id="booking-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg max-w-lg w-full p-6 shadow-lg relative">
        <h3 class="text-xl font-bold mb-4">Confirma tu cita</h3>
        <div id="modal-summary" class="space-y-2 text-gray-800 mb-6">
            {{-- Resumen dinámico --}}
        </div>
        <div class="flex justify-end gap-4">
            <button id="modal-close-btn" class="px-4 py-2 rounded border border-gray-400 hover:bg-gray-100">Cerrar</button>
            <button id="modal-confirm-btn" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Confirmar cita</button>
        </div>
        <button id="modal-x-btn" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
        <p id="modal-error-msg" class="mt-2 text-red-600"></p>
    </div>
</div>

<style>
    .extra-btn {
        background-color: white;
        color: #333;
        user-select: none;
    }

    .extra-btn:hover {
        background-color: #fee2e2;
    }

    .extra-btn.selected {
        background-color: #dc2626;
        color: white;
    }

    .calendar-btn {
        border: 1px solid #ccc;
        background: white;
        padding: 8px 12px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        border-radius: 6px;
        min-width: 70px;
    }
    .calendar-btn:hover:not([disabled]) {
        background-color: #fee2e2;
    }
    .calendar-btn.selected {
        background-color: #dc2626;
        color: white;
    }
    .calendar-btn:disabled {
        background-color: #eee;
        cursor: not-allowed;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- ELEMENTOS DOM ---
    const vehicleOptions = document.getElementById('vehicle-options');
    const vehicleSelected = document.getElementById('vehicle-selected');
    const changeVehicleBtn = document.getElementById('change-vehicle');
    const stepExtras = document.getElementById('step-extras');
    const stepDatetime = document.getElementById('step-datetime');
    const clientInfoSection = document.getElementById('client-info');
    const restInputs = [...stepExtras.querySelectorAll('input'), ...stepDatetime.querySelectorAll('button, input')];

    const radios = vehicleOptions.querySelectorAll('input[type="radio"][name="vehicle_price_id"]');
    const selectedVehicleName = document.getElementById('selected-vehicle-name');
    const selectedVehiclePrice = document.getElementById('selected-vehicle-price');
    const selectedVehicleIcon = document.getElementById('selected-vehicle-icon');

    // Resumen DOM
    const summaryVehicle = document.getElementById('summary-vehicle');
    const summaryExtras = document.getElementById('summary-extras');
    const summaryTotal = document.getElementById('summary-total');
    const extraLabels = document.querySelectorAll('#extra-services .extra-btn');
    const summaryCustomer = document.getElementById('summary-customer');
    const summaryDatetime = document.getElementById('summary-datetime');
    const bookingErrorMsg = document.getElementById('booking-error-msg');

    // Inputs ocultos
    const hiddenCustomerId = document.getElementById('customer_id');
    const appointmentDateInput = document.getElementById('appointment_date_hidden');
    const appointmentTimeInput = document.getElementById('appointment_time_hidden');

    // Formulario cliente
    const clientForm = document.getElementById('client-form');
    const saveClientBtn = document.getElementById('save-client-btn');
    const clientSaveMsg = document.getElementById('client-save-message');

    // Botones de reservar y modal
    const bookBtn = document.getElementById('book-appointment-btn');
    const bookingModal = document.getElementById('booking-modal');
    const modalSummary = document.getElementById('modal-summary');
    const modalCloseBtn = document.getElementById('modal-close-btn');
    const modalXBtn = document.getElementById('modal-x-btn');
    const modalConfirmBtn = document.getElementById('modal-confirm-btn');
    const modalErrorMsg = document.getElementById('modal-error-msg');

    // --- FUNCIONES ---

    function enableNextSteps() {
        stepExtras.classList.remove('hidden');
        stepDatetime.classList.remove('hidden');
        clientInfoSection.classList.remove('hidden');
        restInputs.forEach(input => input.disabled = false);
    }

    function hideNextSteps() {
        stepExtras.classList.add('hidden');
        stepDatetime.classList.add('hidden');
        clientInfoSection.classList.add('hidden');
        restInputs.forEach(input => input.disabled = true);
    }

    function resetSummary() {
        summaryVehicle.textContent = 'No seleccionado';
        summaryExtras.textContent = 'Ninguno';
        summaryTotal.textContent = '0.00';
        summaryCustomer.textContent = 'No ingresado';
        summaryDatetime.textContent = 'No seleccionada';
        appointmentDateInput.value = '';
        appointmentTimeInput.value = '';
        hiddenCustomerId.value = '';
        bookingErrorMsg.textContent = '';
        modalErrorMsg.textContent = '';
    }

    function updateSummaryVehicle() {
        summaryVehicle.textContent = selectedVehicleName.textContent + ' ' + selectedVehiclePrice.textContent;
        updateSummaryTotal();
    }

    function updateSummaryExtras() {
        let selectedExtras = [];
        let extrasTotal = 0;

        extraLabels.forEach(label => {
            const checkbox = label.querySelector('input[type="checkbox"]');
            if (checkbox.checked) {
                const name = label.querySelector('span.font-semibold').textContent;
                const price = parseFloat(label.getAttribute('data-price')) || 0;
                selectedExtras.push(`${name} ($${price.toFixed(2)})`);
                extrasTotal += price;
            }
        });

        summaryExtras.textContent = selectedExtras.length ? selectedExtras.join(', ') : 'Ninguno';
        updateSummaryTotal();
    }

    function updateSummaryTotal() {
        let extrasTotal = 0;

        extraLabels.forEach(label => {
            const checkbox = label.querySelector('input[type="checkbox"]');
            if (checkbox.checked) {
                extrasTotal += parseFloat(label.getAttribute('data-price')) || 0;
            }
        });

        let basePrice = 0;
        if (summaryVehicle.textContent !== 'No seleccionado') {
            const match = summaryVehicle.textContent.match(/\$(\d+(\.\d{1,2})?)/);
            basePrice = match ? parseFloat(match[1]) : 0;
        }

        summaryTotal.textContent = (basePrice + extrasTotal).toFixed(2);
    }

    function updateBookButtonState() {
        bookingErrorMsg.textContent = ''; // limpiar mensajes

        const vehicleSelectedValid = selectedVehicleName.textContent && selectedVehicleName.textContent !== '';
        const customerIdValid = !!hiddenCustomerId.value;
        const datetimeValid = appointmentDateInput.value && appointmentTimeInput.value;

        // Mostrar mensajes indicativos si no cumple
        if (!vehicleSelectedValid) {
            bookingErrorMsg.textContent = 'Debe seleccionar un vehículo.';
        } else if (!customerIdValid) {
            bookingErrorMsg.textContent = 'Debe guardar sus datos de cliente.';
        } else if (!datetimeValid) {
            bookingErrorMsg.textContent = 'Debe seleccionar fecha y hora.';
        }

        bookBtn.disabled = !(vehicleSelectedValid && customerIdValid && datetimeValid);
    }

    // --- VEHÍCULO ---

    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            const label = radio.closest('label');
            if (!label) return;

            const nameDiv = label.querySelector('div > div.font-semibold');
            const priceDiv = label.querySelector('div > div.text-gray-600');
            selectedVehicleName.textContent = nameDiv ? nameDiv.textContent : '';
            selectedVehiclePrice.textContent = priceDiv ? priceDiv.textContent : '';

            const iconDiv = label.querySelector('div.text-4xl');
            selectedVehicleIcon.textContent = iconDiv ? iconDiv.textContent.trim() : '';

            vehicleOptions.style.transition = 'opacity 0.5s ease';
            vehicleOptions.style.opacity = '0';

            setTimeout(() => {
                vehicleOptions.classList.add('hidden');
                vehicleSelected.classList.remove('hidden');
                vehicleSelected.style.opacity = '0';
                vehicleSelected.style.transition = 'opacity 0.5s ease';
                setTimeout(() => vehicleSelected.style.opacity = '1', 10);
            }, 500);

            enableNextSteps();
            updateSummaryVehicle();

            // Reset extras visual y resumen
            extraLabels.forEach(label => {
                const checkbox = label.querySelector('input[type="checkbox"]');
                checkbox.checked = false;
                label.classList.remove('selected');
            });
            updateSummaryExtras();

            updateBookButtonState();
        });
    });

    changeVehicleBtn.addEventListener('click', () => {
        vehicleSelected.style.transition = 'opacity 0.5s ease';
        vehicleSelected.style.opacity = '0';

        setTimeout(() => {
            vehicleSelected.classList.add('hidden');
            vehicleOptions.classList.remove('hidden');
            vehicleOptions.style.opacity = '0';
            setTimeout(() => vehicleOptions.style.opacity = '1', 10);

            hideNextSteps();

            radios.forEach(radio => radio.checked = false);
            resetSummary();

            extraLabels.forEach(label => {
                const checkbox = label.querySelector('input[type="checkbox"]');
                checkbox.checked = false;
                label.classList.remove('selected');
            });
            updateSummaryExtras();

            updateBookButtonState();
        }, 500);
    });

    // --- EXTRAS ---

    extraLabels.forEach(label => {
        label.addEventListener('click', e => {
            const checkbox = label.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            label.classList.toggle('selected', checkbox.checked);
            updateSummaryExtras();
            updateBookButtonState();
        });

        // Inicializar estado si ya está seleccionado
        if (label.querySelector('input[type="checkbox"]').checked) {
            label.classList.add('selected');
        }
    });

    // --- CLIENTE ---

    const clientNameInput = document.getElementById('client-name');
    const clientPhoneInput = document.getElementById('client-phone');

    [clientNameInput, clientPhoneInput].forEach(input => {
        input.addEventListener('input', () => {
            const nameVal = clientNameInput.value.trim();
            const phoneVal = clientPhoneInput.value.trim();
            summaryCustomer.textContent = nameVal ? `${nameVal}${phoneVal ? ' - ' + phoneVal : ''}` : 'No ingresado';
            updateBookButtonState();
        });
    });

    clientForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        saveClientBtn.disabled = true;
        saveClientBtn.textContent = 'Guardando...';
        clientSaveMsg.textContent = '';

        const payload = {
            name: clientForm.name.value.trim(),
            email: clientForm.email.value.trim(),
            phone_number: clientForm.phone.value.trim(),
            address: clientForm.address.value.trim(),
            _token: '{{ csrf_token() }}',
        };

        if (!payload.name || !payload.email || !payload.phone_number || !payload.address) {
            clientSaveMsg.textContent = 'Por favor, complete todos los campos.';
            saveClientBtn.disabled = false;
            saveClientBtn.textContent = 'Guardar datos';
            return;
        }

        try {
            const response = await fetch("{{ route('public.customer.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) throw new Error('Error en la respuesta del servidor.');

            const result = await response.json();

            if (result.success) {
                clientSaveMsg.style.color = 'green';
                clientSaveMsg.textContent = 'Datos guardados correctamente.';

                hiddenCustomerId.value = result.customer.id;
                summaryCustomer.textContent = `${result.customer.name} - ${result.customer.phone_number}`;

                updateBookButtonState();

            } else {
                clientSaveMsg.style.color = 'red';
                clientSaveMsg.textContent = 'Error: ' + (result.message || 'No se pudo guardar.');
            }
        } catch (error) {
            clientSaveMsg.style.color = 'red';
            clientSaveMsg.textContent = 'Error al guardar datos: ' + error.message;
        } finally {
            saveClientBtn.disabled = false;
            saveClientBtn.textContent = 'Guardar datos';
        }
    });

    // --- CALENDARIO ---

    const calendarBody = document.getElementById('calendar-body');

    const availableTimes = ['07:00 AM', '09:00 AM', '11:00 AM', '01:00 PM', '03:00 PM', '05:00 PM'];

    function getNextDates(days = 5) {
        const dates = [];
        const today = new Date();
        for (let i = 0; i < days; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);
            dates.push(date);
        }
        return dates;
    }

    function formatDateDisplay(date) {
        return date.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' });
    }

    function formatDateValue(date) {
        return date.toISOString().split('T')[0];
    }

    function getBookedSlots() {
        return [
            `${formatDateValue(new Date())} 09:00 AM`,
            `${formatDateValue(new Date())} 01:00 PM`,
            `${formatDateValue(new Date(new Date().setDate(new Date().getDate() + 1)))} 07:00 AM`,
        ];
    }

    function renderCalendar() {
        const dates = getNextDates(5);
        const bookedSlots = getBookedSlots();

        calendarBody.innerHTML = '';

        dates.forEach(date => {
            const tr = document.createElement('tr');

            const tdDay = document.createElement('td');
            tdDay.classList.add('border', 'border-gray-300', 'px-2', 'py-1', 'font-semibold', 'whitespace-nowrap');
            tdDay.textContent = formatDateDisplay(date);
            tr.appendChild(tdDay);

            availableTimes.forEach(time => {
                const tdTime = document.createElement('td');
                tdTime.classList.add('border', 'border-gray-300', 'px-2', 'py-1');

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'calendar-btn';
                btn.textContent = time;

                const slotStr = `${formatDateValue(date)} ${time}`;
                const isBooked = bookedSlots.includes(slotStr);

                btn.disabled = isBooked;
                if (isBooked) btn.title = 'Horario no disponible';

                btn.addEventListener('click', () => {
                    document.querySelectorAll('.calendar-btn.selected').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');

                    appointmentDateInput.value = formatDateValue(date);
                    appointmentTimeInput.value = time;

                    summaryDatetime.textContent = `${formatDateDisplay(date)} ${time}`;

                    updateBookButtonState();
                });

                tdTime.appendChild(btn);
                tr.appendChild(tdTime);
            });

            calendarBody.appendChild(tr);
        });
    }

    renderCalendar();

    // --- MODAL PARA CONFIRMAR CITA ---

    function openModal() {
        modalErrorMsg.textContent = '';
        modalSummary.innerHTML = `
            <p><strong>Servicio:</strong> {{ $service->name }}</p>
            <p><strong>Vehículo:</strong> ${selectedVehicleName.textContent} ${selectedVehiclePrice.textContent}</p>
            <p><strong>Extras:</strong> ${summaryExtras.textContent}</p>
            <p><strong>Cliente:</strong> ${summaryCustomer.textContent}</p>
            <p><strong>Fecha y hora:</strong> ${summaryDatetime.textContent}</p>
            <p class="font-bold text-lg"><strong>Total:</strong> $${summaryTotal.textContent}</p>
        `;
        bookingModal.classList.remove('hidden');
    }

    function closeModal() {
        bookingModal.classList.add('hidden');
    }

    // Abrir modal cuando se clickea "Agendar cita"
    bookBtn.addEventListener('click', () => {
        openModal();
    });

    // Cerrar modal botones
    modalCloseBtn.addEventListener('click', () => {
        closeModal();
    });
    modalXBtn.addEventListener('click', () => {
        closeModal();
    });

    // Confirmar cita - enviar al backend
    modalConfirmBtn.addEventListener('click', async () => {
        modalErrorMsg.textContent = '';
        modalConfirmBtn.disabled = true;
        modalConfirmBtn.textContent = 'Guardando...';

        const customerId = hiddenCustomerId.value;
        const appointmentDate = appointmentDateInput.value;
        const appointmentTime = appointmentTimeInput.value;
        const vehiclePriceRadio = document.querySelector('input[name="vehicle_price_id"]:checked');
        const serviceVehiclePriceId = vehiclePriceRadio ? vehiclePriceRadio.value : null;
        const extrasChecked = [...document.querySelectorAll('#extra-services input[type="checkbox"]:checked')].map(i => i.value);
        const totalPrice = parseFloat(summaryTotal.textContent) || 0;

        // Validar datos para prevenir fallos
        let errors = [];
        if (!customerId) errors.push('Debe guardar sus datos primero.');
        if (!serviceVehiclePriceId) errors.push('Seleccione un vehículo.');
        if (!appointmentDate || !appointmentTime) errors.push('Seleccione fecha y hora.');
        if (totalPrice <= 0) errors.push('Total inválido.');

        if (errors.length > 0) {
            modalErrorMsg.textContent = errors.join(' ');
            modalConfirmBtn.disabled = false;
            modalConfirmBtn.textContent = 'Confirmar cita';
            return;
        }

        const payload = {
            customer_id: customerId,
            appointment_date: appointmentDate,
            appointment_time: appointmentTime,
            service_vehicle_price_id: serviceVehiclePriceId,
            extras: extrasChecked,
            total_price: totalPrice,
            _token: '{{ csrf_token() }}'
        };

        try {
            const response = await fetch("{{ route('public.book.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                let errorMessage = 'Error al agendar la cita.';
                try {
                    const errorData = await response.json();
                    errorMessage = errorData.message || errorMessage;
                } catch (_) {}
                throw new Error(errorMessage);
            }

            const result = await response.json();

            if (result.success) {
                closeModal();
                alert('Cita agendada con éxito! ID: ' + result.appointment_id);
                // Redirigir al origen, por ejemplo:
                window.location.href = "{{ url()->previous() }}";
            } else {
                modalErrorMsg.textContent = 'Error: ' + (result.message || 'No se pudo guardar la cita.');
            }
        } catch (error) {
            modalErrorMsg.textContent = 'Error: ' + error.message;
        } finally {
            modalConfirmBtn.disabled = false;
            modalConfirmBtn.textContent = 'Confirmar cita';
        }
    });

    // --- Inicializaciones ---

    hideNextSteps();
    resetSummary();
    updateSummaryExtras();
    updateBookButtonState();

});
</script>

@endsection