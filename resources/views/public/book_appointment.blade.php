@extends('public.layout')

@section('content')

{{-- Hero --}}
<section class="hero bg-red-600 text-white py-12 text-center px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl sm:text-4xl font-bold mb-4">Book Your Service</h1>
    <p class="text-base sm:text-lg max-w-xl mx-auto">Select your vehicle to see prices, then complete your information and schedule your appointment.</p>
</section>

<div class="flex flex-col lg:flex-row gap-6 p-4 sm:p-6 lg:p-8 max-w-8xl mx-auto">

    {{-- Left form and selection --}}
    <div class="lg:w-3/4 space-y-8">

        {{-- Selected service --}}
        <section class="p-4 border rounded ">
            <h2 class="text-xl sm:text-2xl font-bold mb-2">Selected Service</h2>
            <p class="font-semibold text-base sm:text-lg">{{ $service->name }}</p>
            <p class="text-sm sm:text-base">{{ $service->tagline }}</p>
            <p class="text-sm sm:text-base">{{ $service->exterior_description }}</p>
            <p class="text-sm sm:text-base">{{ $service->interior_description }}</p>
        </section>

        <form id="booking-form" method="POST" action="{{ route('public.book.store') }}" class="mx-0 sm:mx-16">
            @csrf

            <input type="hidden" name="service_id" value="{{ $service->id }}">
            <input type="hidden" name="customer_id" id="customer_id" value="">
            <input type="hidden" name="appointment_date" id="appointment_date_hidden" value="">
            <input type="hidden" name="appointment_time" id="appointment_time_hidden" value="">

            {{-- Step 1: Vehicle Selection --}}
            <section id="step-vehicle" class="p-4 sm:p-6 border rounded shadow-lg bg-gray-50">
                <h2 class="text-lg sm:text-xl font-bold mb-6">Select Your Vehicle</h2>

                <div id="vehicle-options" class="space-y-4">
                    @foreach($vehiclePrices as $vp)
                    <label
                        class="flex items-center justify-between p-3 sm:p-4 border rounded cursor-pointer hover:bg-red-100 transition duration-300 ease-in-out"
                        style="user-select:none;"
                        data-price="{{ $vp->price }}">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <input type="radio" name="vehicle_price_id" value="{{ $vp->id }}" class="mr-3 sm:mr-4 w-4 h-4 sm:w-5 sm:h-5" required>
                            <div>
                                <div class="font-semibold text-base sm:text-lg">{{ $vp->vehicleType->name }}</div>
                                <div class="text-gray-600 text-sm sm:text-base">${{ number_format($vp->price, 2) }}</div>
                            </div>
                        </div>

                        <div class="select-none flex items-center justify-center" style="width: 40px; height: 40px; min-width:40px; min-height:40px;">
                            <img src="/vehicles/{{ $vp->vehicleType->icon }}" alt="vehicle icon" class="max-h-8 max-w-8 object-contain">
                        </div>
                    </label>
                    @endforeach
                </div>

                <div id="vehicle-selected" class="hidden p-4 border rounded bg-white shadow-md flex items-center justify-between">
                    <div>
                        <div class="font-semibold text-base sm:text-lg" id="selected-vehicle-name"></div>
                        <div class="text-gray-600 text-sm sm:text-base" id="selected-vehicle-price"></div>
                    </div>
                    <div id="selected-vehicle-icon" class="select-none flex items-center justify-center" style="width: 48px; height: 48px;"></div>
                    <button type="button" id="change-vehicle" class="ml-4 text-red-600 hover:underline font-semibold text-sm sm:text-base">Change Vehicle</button>
                </div>
            </section>

            {{-- Step 2: Extra Services --}}
            <section id="step-extras" class="p-4 sm:p-6 border rounded mt-6 hidden">
                <h2 class="text-lg sm:text-xl font-bold mb-4">Extra Services</h2>
                <div id="extra-services" class="flex flex-wrap gap-3 sm:gap-4 mb-6">
                    @foreach($extraServices as $extra)
                    <label
                        class="extra-btn flex flex-col items-center justify-center border rounded cursor-pointer px-3 sm:px-4 py-2 sm:py-3 select-none transition-colors duration-300 text-sm sm:text-base"
                        data-price="{{ $extra->price }}">
                        <input type="checkbox" name="extras[]" value="{{ $extra->id }}" class="hidden" />
                        <span class="font-semibold">{{ $extra->name }}</span>
                        <span>${{ number_format($extra->price, 2) }}</span>
                    </label>
                    @endforeach
                </div>
            </section>

            {{-- Step 3: Date and Time Selection --}}
            <section id="step-datetime" class="p-4 sm:p-6 border rounded mt-6 hidden">
                <h2 class="text-lg sm:text-xl font-bold mb-4">Select Date and Time</h2>

                <div id="calendar-container" class="overflow-auto max-h-96 rounded border border-gray-200 shadow-sm bg-white">
                    <table class="table-auto border-collapse w-full text-center min-w-[600px]">
                        <thead>
                            <tr>
                                <th class="px-2 py-1 bg-white sticky top-0 left-0 z-20 text-gray-600 font-medium border-b text-xs sm:text-sm whitespace-nowrap">Time / Day</th>
                                {{-- The days will be generated dynamically here --}}
                            </tr>
                        </thead>
                        <tbody id="calendar-body">
                            {{-- The hours and cells will be generated dynamically --}}
                        </tbody>
                    </table>
                </div>
            </section>
        </form>

        {{-- Client form, initially hidden --}}
        <section id="client-info" class="p-4 sm:p-6 border rounded-lg shadow-sm mt-8 hidden bg-white">
            <h2 class="text-lg sm:text-xl font-bold mb-6 pb-3 border-b text-gray-800">Personal Information</h2>

            <form id="client-form" class="flex flex-col gap-4 sm:gap-6" onsubmit="return false;">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="flex flex-col">
                        <label for="client-name" class="mb-1 text-xs sm:text-sm font-medium text-gray-700">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-2 sm:pl-3 pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <input type="text" name="name" id="client-name" placeholder="Enter your full name" class="w-full pl-8 sm:pl-10 pr-3 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base" required>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <label for="client-email" class="mb-1 text-xs sm:text-sm font-medium text-gray-700">Email Address </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-2 sm:pl-3 pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <input type="email" name="email" id="client-email" placeholder="example@email.com" class="w-full pl-8 sm:pl-10 pr-3 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base" required>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="flex flex-col">
                        <label for="client-phone" class="mb-1 text-xs sm:text-sm font-medium text-gray-700">Phone Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-2 sm:pl-3 pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            </div>
                            <input type="text" name="phone" id="client-phone" placeholder="Ex: 987654321" class="w-full pl-8 sm:pl-10 pr-3 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base" required>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <label for="client-address" class="mb-1 text-xs sm:text-sm font-medium text-gray-700">Address (Work address)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-2 sm:pl-3 pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </div>
                            <input type="text" name="address" id="client-address" placeholder="Enter your complete address" class="w-full pl-8 sm:pl-10 pr-3 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base" required>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center mt-4">
                    <button id="save-client-btn" class="w-full max-w-xs bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-all transform hover:-translate-y-1 shadow-md font-medium flex items-center justify-center gap-2" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Save Information
                    </button>
                    <p id="client-save-message" class="mt-3 text-sm"></p>
                </div>
            </form>
        </section>

    </div>

    {{-- Right summary --}}
    <div class="lg:w-1/4 p-4 border rounded sticky top-16 h-max flex flex-col bg-white shadow-sm max-h-[calc(100vh-4rem)] overflow-y-auto">
        <h2 class="text-xl sm:text-2xl font-bold mb-4">Order Summary</h2>
        <div id="order-summary" class="space-y-2 flex-grow text-sm sm:text-base">
            <p><strong>Service:</strong> <span id="summary-service">{{ $service->name }}</span></p>
            <p><strong>Vehicle:</strong> <span id="summary-vehicle">Not selected</span></p>
            <p><strong>Extras:</strong> <span id="summary-extras">None</span></p>
            <p><strong>Customer:</strong> <span id="summary-customer">Not entered</span></p>
            <p><strong>Date and Time:</strong> <span id="summary-datetime">Not selected</span></p>
            <p class="font-bold text-lg"><strong>Total:</strong> $<span id="summary-total">0.00</span></p>
        </div>
        <p id="booking-error-msg" class="text-red-600 mt-2 text-sm"></p>
        <button id="book-appointment-btn" class="mt-6 bg-red-600 text-white py-3 px-6 rounded hover:bg-red-700 disabled:opacity-50 text-sm sm:text-base" disabled>Book Appointment</button>
    </div>

</div>

{{-- Modal for summary and confirmation --}}
<div id="booking-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-lg max-w-lg w-full p-6 shadow-lg relative max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold mb-4">Confirm Your Appointment</h3>
        <div id="modal-summary" class="space-y-2 text-gray-800 mb-6 text-sm sm:text-base">
            {{-- Dynamic summary --}}
        </div>
        <div class="flex justify-end gap-4 flex-wrap">
            <button id="modal-close-btn" class="px-4 py-2 rounded border border-gray-400 hover:bg-gray-100">Close</button>
            <button id="modal-confirm-btn" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Confirm Appointment</button>
        </div>
        <button id="modal-x-btn" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl font-bold leading-none">&times;</button>
        <p id="modal-error-msg" class="mt-2 text-red-600 text-sm"></p>
    </div>
</div>

<style>
    .extra-btn {
        background-color: white;
        color: #333;
        user-select: none;
        min-width: 90px;
        text-align: center;
    }

    .extra-btn:hover {
        background-color: #fee2e2;
    }

    .extra-btn.selected {
        background-color: #dc2626;
        color: white;
    }

    /* Estilos para botones del calendario */
    .calendar-btn {
        font-weight: 500;
        user-select: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        font-size: 0.75rem; /* Ajuste para móviles */
        padding: 0.25rem 0.5rem;
    }

    .calendar-btn.selected {
        background-color: #3B82F6 !important;
        color: white !important;
        border-color: #2563EB !important;
        transform: scale(1.02);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .calendar-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .calendar-btn:disabled {
        opacity: 0.5;
    }

    /* Sticky first column and header */
    #calendar-container table th:first-child,
    #calendar-container table td:first-child {
        position: sticky;
        left: 0;
        background-color: #f9fafb;
        z-index: 20;
        min-width: 48px;
    }

    #calendar-container table thead th {
        position: sticky;
        top: 0;
        background-color: #ffffff;
        z-index: 15;
        font-size: 0.75rem;
    }
    
    #calendar-container table {
        border-spacing: 6px;
        border-collapse: separate;
        min-width: 600px; /* Para scroll horizontal en móvil */
    }
    
    #calendar-container td {
        padding: 3px;
    }

    /* Scroll horizontal en móvil */
    #calendar-container {
        -webkit-overflow-scrolling: touch;
    }

</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Datos de citas bloqueadas (fecha + hora) y estados
    const blockedAppointmentsRaw = @json($blockedAppointments ?? []);

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

    const summaryVehicle = document.getElementById('summary-vehicle');
    const summaryExtras = document.getElementById('summary-extras');
    const summaryTotal = document.getElementById('summary-total');
    const extraLabels = document.querySelectorAll('#extra-services .extra-btn');
    const summaryCustomer = document.getElementById('summary-customer');
    const summaryDatetime = document.getElementById('summary-datetime');
    const bookingErrorMsg = document.getElementById('booking-error-msg');

    const hiddenCustomerId = document.getElementById('customer_id');
    const appointmentDateInput = document.getElementById('appointment_date_hidden');
    const appointmentTimeInput = document.getElementById('appointment_time_hidden');

    const clientForm = document.getElementById('client-form');
    const saveClientBtn = document.getElementById('save-client-btn');
    const clientSaveMsg = document.getElementById('client-save-message');

    const bookBtn = document.getElementById('book-appointment-btn');
    const bookingModal = document.getElementById('booking-modal');
    const modalSummary = document.getElementById('modal-summary');
    const modalCloseBtn = document.getElementById('modal-close-btn');
    const modalXBtn = document.getElementById('modal-x-btn');
    const modalConfirmBtn = document.getElementById('modal-confirm-btn');
    const modalErrorMsg = document.getElementById('modal-error-msg');

    const calendarBody = document.getElementById('calendar-body');
    const calendarTheadRow = document.querySelector('#step-datetime thead tr');

    // --- FUNCIONES UTILES ---
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
        summaryVehicle.textContent = 'Not selected';
        summaryExtras.textContent = 'None';
        summaryTotal.textContent = '0.00';
        summaryCustomer.textContent = 'Not entered';
        summaryDatetime.textContent = 'Not selected';
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
                selectedExtras.push(`${name} (${price.toFixed(2)})`);
                extrasTotal += price;
            }
        });
        summaryExtras.textContent = selectedExtras.length ? selectedExtras.join(', ') : 'None';
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
        bookingErrorMsg.textContent = '';
        const vehicleSelectedValid = summaryVehicle.textContent && summaryVehicle.textContent !== 'Not selected';
        const customerIdValid = !!hiddenCustomerId.value;
        const datetimeValid = appointmentDateInput.value && appointmentTimeInput.value;
        if (!vehicleSelectedValid) {
            bookingErrorMsg.textContent = 'You must select a vehicle.';
        } else if (!customerIdValid) {
            bookingErrorMsg.textContent = 'You must save your customer information.';
        } else if (!datetimeValid) {
            bookingErrorMsg.textContent = 'You must select date and time.';
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
        label.addEventListener('click', () => {
            const checkbox = label.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            label.classList.toggle('selected', checkbox.checked);
            updateSummaryExtras();
            updateBookButtonState();
        });
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
            clientSaveMsg.classList.add('text-red-600');
            clientSaveMsg.textContent = 'Please complete all fields.';
            saveClientBtn.disabled = false;
            saveClientBtn.textContent = 'Save Information';
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
                clientSaveMsg.textContent = 'Information saved successfully.';
                hiddenCustomerId.value = result.customer.id;
                summaryCustomer.textContent = `${result.customer.name} - ${result.customer.phone_number}`;
                updateBookButtonState();
            } else {
                clientSaveMsg.classList.add('text-red-600');
                clientSaveMsg.textContent = 'Error: ' + (result.message || 'Could not save information.');
            }
        } catch (error) {
            clientSaveMsg.classList.add('text-red-600');
            clientSaveMsg.textContent = 'Error saving data: ' + error.message;
        } finally {
            saveClientBtn.disabled = false;
            saveClientBtn.textContent = 'Save Information';
        }
    });

    // --- CALENDARIO MEJORADO ---
    // Horas que mostramos en eje Y (de 8am a 5pm)
    const availableHours = [];
    for (let h = 8; h <= 17; h++) {
        availableHours.push(h.toString().padStart(2, '0') + ':00');
    }
    // Días (columnas) - desde hoy, rango 7 días
    function getNextDays(daysCount = 7) {
        const days = [];
        const today = new Date();
        for (let i = 0; i < daysCount; i++) {
            const d = new Date(today);
            d.setDate(today.getDate() + i);
            days.push(d);
        }
        return days;
    }
    // Formatear fecha de encabezado
    function renderCalendarHeader(days) {
        while (calendarTheadRow.children.length > 1) {
            calendarTheadRow.removeChild(calendarTheadRow.lastChild);
        }
        days.forEach(day => {
            const th = document.createElement('th');
            th.className = 'px-3 py-2 bg-white sticky top-0 z-10 text-gray-600 font-medium border-b';
            // Prefijo en inglés
            const dayName = day.toLocaleDateString('en-US', { weekday: 'short' });
            const dayNumber = day.getDate();
            const daySpan = document.createElement('div');
            daySpan.className = 'text-sm';
            daySpan.textContent = dayName;
            const dateSpan = document.createElement('div');
            dateSpan.className = 'text-base';
            dateSpan.textContent = dayNumber;
            th.appendChild(daySpan);
            th.appendChild(dateSpan);
            calendarTheadRow.appendChild(th);
        });
    }
    // Construir cuerpo del calendario
    function renderCalendarBody(days, hours) {
        calendarBody.innerHTML = '';
        hours.forEach(hour => {
            const tr = document.createElement('tr');
            const tdHour = document.createElement('td');
            tdHour.className = 'px-3 py-2 bg-gray-50 sticky left-0 z-10 whitespace-nowrap font-medium text-gray-600 text-sm border-r';
            tdHour.textContent = to12Hour(hour);
            tr.appendChild(tdHour);
            days.forEach(day => {
                const dateStr = formatDateValue(day);
                const hourStr = hour;
                const td = document.createElement('td');
                td.className = 'px-2 py-1';
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'calendar-btn w-full rounded py-2 px-3 text-center';
                btn.textContent = to12Hour(hourStr);
                const blocked = isBlocked(dateStr, hourStr);
                btn.disabled = blocked;
                if (blocked) {
                    btn.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed', 'opacity-50');
                } else {
                    btn.classList.add('bg-white', 'text-gray-700', 'hover:bg-blue-50', 'border', 'border-gray-200');
                    btn.addEventListener('click', () => {
                        document.querySelectorAll('.calendar-btn.selected').forEach(b => b.classList.remove('selected'));
                        btn.classList.add('selected');
                        appointmentDateInput.value = dateStr;
                        appointmentTimeInput.value = hourStr;
                        summaryDatetime.textContent = `${formatDateDisplay(day)} ${to12Hour(hour)}`;
                        updateBookButtonState();
                    });
                }
                td.appendChild(btn);
                tr.appendChild(td);
            });
            calendarBody.appendChild(tr);
        });
    }
    // Funciones auxiliares
    function isBlocked(dateStr, hourStr) {
        const blocked = blockedAppointmentsRaw.some(ba => ba.date === dateStr && ba.hour === hourStr);
        if (blocked) return true;
        const now = new Date();
        const cellDateTime = new Date(dateStr + 'T' + hourStr + ':00');
        return cellDateTime <= now;
    }
    function to12Hour(time24) {
        const [hour, minute] = time24.split(':').map(Number);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        let hour12 = hour % 12;
        hour12 = hour12 ? hour12 : 12;
        return `${hour12}:${minute.toString().padStart(2,'0')} ${ampm}`;
    }
    function formatDateValue(date) {
        return date.toISOString().split('T')[0];
    }
    function formatDateDisplay(date) {
        return date.toLocaleDateString('en-US', { weekday: 'short', day: 'numeric', month: 'short' });
    }
    // Render inicial
    const days = getNextDays(7);
    renderCalendarHeader(days);
    renderCalendarBody(days, availableHours);

    // --- MODAL PARA CONFIRMAR CITA ---
    function openModal() {
        modalErrorMsg.textContent = '';
        modalSummary.innerHTML = `
            <p><strong>Service:</strong> {{ $service->name }}</p>
            <p><strong>Vehicle:</strong> ${selectedVehicleName.textContent} ${selectedVehiclePrice.textContent}</p>
            <p><strong>Extras:</strong> ${summaryExtras.textContent}</p>
            <p><strong>Customer:</strong> ${summaryCustomer.textContent}</p>
            <p><strong>Date and Time:</strong> ${summaryDatetime.textContent}</p>
            <p class="font-bold text-lg"><strong>Total:</strong> ${summaryTotal.textContent}</p>
        `;
        bookingModal.classList.remove('hidden');
    }
    function closeModal() {
        bookingModal.classList.add('hidden');
    }
    bookBtn.addEventListener('click', openModal);
    modalCloseBtn.addEventListener('click', closeModal);
    modalXBtn.addEventListener('click', closeModal);
    modalConfirmBtn.addEventListener('click', async () => {
        modalErrorMsg.textContent = '';
        modalConfirmBtn.disabled = true;
        modalConfirmBtn.textContent = 'Saving...';
        const customerId = hiddenCustomerId.value;
        const appointmentDate = appointmentDateInput.value;
        const appointmentTime = appointmentTimeInput.value;
        const vehiclePriceRadio = document.querySelector('input[name="vehicle_price_id"]:checked');
        const serviceVehiclePriceId = vehiclePriceRadio ? vehiclePriceRadio.value : null;
        const extrasChecked = [...document.querySelectorAll('#extra-services input[type="checkbox"]:checked')].map(i => i.value);
        const totalPrice = parseFloat(summaryTotal.textContent) || 0;
        let errors = [];
        if (!customerId) errors.push('You must save your information first.');
        if (!serviceVehiclePriceId) errors.push('Select a vehicle.');
        if (!appointmentDate || !appointmentTime) errors.push('Select date and time.');
        if (totalPrice <= 0) errors.push('Invalid total.');
        if (errors.length) {
            modalErrorMsg.textContent = errors.join(' ');
            modalConfirmBtn.disabled = false;
            modalConfirmBtn.textContent = 'Confirm Appointment';
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
                let errorMessage = 'Error scheduling the appointment.';
                try {
                    const errorData = await response.json();
                    errorMessage = errorData.message || errorMessage;
                } catch (_) {}
                throw new Error(errorMessage);
            }
            const result = await response.json();
            if (result.success) {
                closeModal();
                alert('Appointment scheduled successfully! ID: ' + result.appointment_id);
                window.location.href = "{{ url()->previous() }}";
            } else {
                modalErrorMsg.textContent = 'Error: ' + (result.message || 'Could not schedule the appointment.');
            }
        } catch (error) {
            modalErrorMsg.textContent = 'Error: ' + error.message;
        } finally {
            modalConfirmBtn.disabled = false;
            modalConfirmBtn.textContent = 'Confirm Appointment';
        }
    });

    // Inicializaciones
    hideNextSteps();
    resetSummary();
    updateSummaryExtras();
    updateBookButtonState();

});
</script>

@endsection