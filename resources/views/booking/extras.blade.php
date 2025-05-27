{{-- resources/views/booking/extras.blade.php --}}
@extends('public.layout')

@section('content')

<style>
  /* Estilos para la opción seleccionada */
  .vehicle-extra-option.selected {
    background-color: #eff6ff !important; /* bg-blue-50 */
    border-color: #3b82f6 !important;     /* border-blue-500 */
  }
</style>

@php
  use App\Models\Service;
  use App\Models\ServiceVehiclePrice;

  // Recuperar desde sesión lo seleccionado en pasos anteriores
  $serviceModel = Service::find(session('booking.service_id'));
  $vehicleModel = ServiceVehiclePrice::with('vehicleType')
                     ->find(session('booking.vehicle_price_id'));
@endphp

<div class="pt-28 min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100" data-aos="fade-up">
  <div class="container mx-auto px-4 lg:px-0 py-8">

    {{-- Breadcrumb --}}
    <nav class="mb-6 text-sm text-gray-500" aria-label="Breadcrumb" data-aos="fade-down">
      <ol class="flex items-center space-x-2">
        <li>
          <a href="{{ route('public.home') }}" class="hover:text-gray-700 transition">
            <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10.707 2.293a1 1 0…"/>
            </svg>
            Home
          </a>
        </li>
        <li>›</li>
        <li class="text-gray-700 font-medium">Step 3: Pick Extras</li>
      </ol>
    </nav>

    {{-- Stepper --}}
    <div class="mb-10" data-aos="fade-down" data-aos-delay="100">
      <div class="flex items-center justify-center space-x-4">
        {{-- Paso 1 --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white">✓</div>
          <span class="text-blue-600">Service</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>
        {{-- Paso 2 --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white">✓</div>
          <span class="text-blue-600">Vehicle</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>
        {{-- Paso 3 --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">3</div>
          <span class="text-blue-600 font-semibold">Extras</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>
        {{-- Pasos 4–6 --}}
        @foreach([4,5,6] as $n)
          <div class="flex items-center space-x-2">
            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">{{ $n }}</div>
            <span class="text-gray-500">{{ ['Date & Time','Your Info','Confirm'][$n-4] }}</span>
          </div>
          @if($n < 6)<div class="flex-1 h-px bg-gray-300"></div>@endif
        @endforeach
      </div>
    </div>

    {{-- Main grid --}}
    <div class="grid lg:grid-cols-3 gap-8">
      
      {{-- Main content: extras form --}}
      <main class="lg:col-span-2 space-y-6" data-aos="fade-right" data-aos-delay="200">
        <h1 class="text-2xl font-bold mb-2">
          Step 3: Pick Extras <small class="text-gray-500">(Optional)</small>
        </h1>
        <p class="text-gray-600 mb-4">
          Select any additional services you'd like to add, or skip if none.
        </p>

        <form method="POST" action="{{ route('booking.extras.store') }}">
          @csrf

          <div class="grid gap-6 sm:grid-cols-2 mb-4">
            @foreach($extras as $extra)
              <label class="vehicle-extra-option block bg-white rounded-2xl shadow hover:shadow-lg transition p-6 cursor-pointer border-2 border-transparent">
                <input
                  type="checkbox"
                  name="extras[]"
                  value="{{ $extra->id }}"
                  data-name="{{ $extra->name }}"
                  data-price="{{ number_format($extra->price, 2) }}"
                  class="sr-only"
                  {{ in_array($extra->id, session('booking.extras', [])) ? 'checked' : '' }}
                />
                <div class="flex items-center justify-between">
                  <span class="text-lg font-semibold text-gray-800">{{ $extra->name }}</span>
                  <span class="text-xl font-bold text-blue-600">${{ number_format($extra->price,2) }}</span>
                </div>
              </label>
            @endforeach
          </div>

          @error('extras.*')
            <div class="text-red-600 mb-4">{{ $message }}</div>
          @enderror

          {{-- Action Buttons --}}
          <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
            <a href="{{ route('booking.vehicle') }}"
               class="flex-1 px-8 py-3 bg-white text-gray-700 border border-gray-300 rounded-xl text-center hover:bg-gray-100 transition">
              &larr; Back
            </a>
            <button type="submit"
                    class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-xl font-semibold text-center
                           hover:from-blue-700 hover:to-indigo-700 transition-all flex items-center justify-center">
              Continue to Date & Time
            </button>
          </div>
        </form>

        {{-- Cancel --}}
        <form method="POST" action="{{ route('booking.cancel') }}" class="mt-6 text-center" data-aos="fade-up" data-aos-delay="300">
          @csrf
          <button type="submit" class="inline-flex items-center text-red-600 hover:underline">
            Cancel Booking
          </button>
        </form>
      </main>

      {{-- Sidebar: Appointment Summary --}}
      <aside class="sticky top-28" data-aos="fade-left" data-aos-delay="300">
        <div class="bg-white rounded-2xl shadow-lg p-6 space-y-4 text-gray-800">
          <h2 class="text-xl font-semibold mb-2">Appointment Summary</h2>
          <div class="space-y-2 text-sm">
            <div class="flex justify-between">
              <span>Service</span>
              <span>{{ $serviceModel->name }}</span>
            </div>
            <div class="flex justify-between">
              <span>Vehicle</span>
              <span>
                {{ $vehicleModel->vehicleType->name }}
                — ${{ number_format($vehicleModel->price,2) }}
              </span>
            </div>
            <div class="flex justify-between">
              <span>Extras</span>
              <span id="summary-extras">
                {{ session('booking.extras') ? collect($extras->whereIn('id', session('booking.extras')))->pluck('name')->join(', ') : 'None' }}
              </span>
            </div>
          </div>
          <hr>
          <div class="flex justify-between font-semibold">
            <span>Total</span>
            <span id="summary-total">
              ${{ number_format($vehicleModel->price + ( session('booking.extras') ? $extras->whereIn('id', session('booking.extras'))->sum('price') : 0 ), 2) }}
            </span>
          </div>
        </div>
      </aside>

    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const checkboxes    = document.querySelectorAll('input[name="extras[]"]');
    const summaryExtras = document.getElementById('summary-extras');
    const summaryTotal  = document.getElementById('summary-total');
    const basePrice     = parseFloat('{{ $vehicleModel->price }}');

    function updateSummary() {
      let names = [];
      let extrasSum = 0;

      checkboxes.forEach(chk => {
        const lbl = chk.closest('.vehicle-extra-option');
        if (chk.checked) {
          lbl.classList.add('selected');
          names.push(chk.dataset.name);
          extrasSum += parseFloat(chk.dataset.price);
        } else {
          lbl.classList.remove('selected');
        }
      });

      summaryExtras.textContent = names.length ? names.join(', ') : 'None';
      const total = basePrice + extrasSum;
      summaryTotal.textContent = '$' + total.toFixed(2);
    }

    checkboxes.forEach(chk => {
      chk.addEventListener('change', updateSummary);
    });

    // Inicializa al cargar
    updateSummary();
  });
</script>

@endsection