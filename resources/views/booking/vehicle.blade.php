@extends('public.layout')

@section('content')

@php
  $skipExtras = $service->category_id == 2;
@endphp

<style>
  .vehicle-option.selected {
    background-color: #eff6ff !important;
    border-color: #3b82f6 !important;
  }
</style>

<div class="relative z-10 pt-36 min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100" data-aos="fade-up">
  <div class="container mx-auto px-4 lg:px-0 py-8">

    {{-- Breadcrumb --}}
    <nav class="mb-6 text-sm text-gray-500" aria-label="Breadcrumb" data-aos="fade-down" data-aos-delay="100">
      <ol class="flex items-center space-x-2">
        <li>
          <a href="{{ route('public.home') }}" class="hover:text-gray-700 transition">
            <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
            </svg>
            Home
          </a>
        </li>
        <li>›</li>
        <li class="text-gray-700 font-medium">Step 2: Select Your Vehicle</li>
      </ol>
    </nav>

    {{-- Stepper --}}
    <div class="mb-10" data-aos="fade-down" data-aos-delay="150">
      <div class="flex items-center justify-center space-x-4">
        {{-- Step 1 --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white">✓</div>
          <span class="text-blue-600">Service</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>

        {{-- Step 2 (Current) --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">2</div>
          <span class="text-blue-600 font-semibold">Vehicle</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>

        {{-- Conditional Step 3 --}}
        @unless($skipExtras)
          <div class="flex items-center space-x-2">
            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">3</div>
            <span class="text-gray-500">Extras</span>
          </div>
          <div class="flex-1 h-px bg-gray-300"></div>
        @endunless

        {{-- Adjusted Index for following steps --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">{{ $skipExtras ? '3' : '4' }}</div>
          <span class="text-gray-500">Date & Time</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>

        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">{{ $skipExtras ? '4' : '5' }}</div>
          <span class="text-gray-500">Your Info</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>

        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">{{ $skipExtras ? '5' : '6' }}</div>
          <span class="text-gray-500">Confirm</span>
        </div>
      </div>
    </div>

    {{-- Main grid --}}
    <div class="grid lg:grid-cols-3 gap-8">

      {{-- Main content --}}
      <main class="lg:col-span-2 space-y-6" data-aos="fade-right" data-aos-delay="200">
        <h1 class="text-2xl font-bold mb-2">Step 2: Select Your Vehicle</h1>
        <p class="text-gray-600 mb-4">Please choose the vehicle type you’d like to book this service for.</p>

        <form id="vehicle-form" method="POST" action="{{ route('booking.vehicle.store') }}">
          @csrf
          <div class="grid gap-6 sm:grid-cols-2 mb-4">
            @foreach($vehiclePrices as $vp)
              <label class="vehicle-option block bg-white rounded-2xl shadow hover:shadow-lg transition p-6 cursor-pointer border-2 border-transparent">
                <input
                  type="radio"
                  name="vehicle_price_id"
                  value="{{ $vp->id }}"
                  data-price="{{ number_format($vp->price, 2) }}"
                  required
                  class="sr-only"
                  {{ session('booking.vehicle_price_id') == $vp->id ? 'checked' : '' }}
                />
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    @if($vp->vehicleType->icon)
                      <img src="{{ asset('vehicles/' . $vp->vehicleType->icon) }}" alt="{{ $vp->vehicleType->name }}" class="w-10">
                    @endif
                    <span class="text-lg font-semibold text-gray-800">{{ $vp->vehicleType->name }}</span>
                  </div>
                  <span class="text-xl font-bold text-blue-600">${{ number_format($vp->price,2) }}</span>
                </div>
              </label>
            @endforeach
          </div>

          @error('vehicle_price_id')
            <div class="text-red-600 mb-4">{{ $message }}</div>
          @enderror

          {{-- Campo de notas adicionales --}}
          <div class="mb-4">
            <label for="notes" class="block text-gray-700 font-semibold mb-2">Enter Vehicle Type/Model/Color</label>
            <textarea
              name="notes"
              id="notes"
              rows="3"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:border-blue-300"
              placeholder="Let us know if there are stains, pet hair, odor issues, or any special request...">{{ old('notes', session('booking.notes') ?? '') }}</textarea>
          </div>
          {{-- Mostrar error --}}
          @error('notes')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
          @enderror
          <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
            <a href="{{ route('booking.service', ['service' => $service->id]) }}"
               class="flex-1 px-8 py-3 bg-white text-gray-700 border border-gray-300 rounded-xl text-center hover:bg-gray-100 transition">
              &larr; Back
            </a>
            <button id="next-btn" type="submit"
                    class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-xl font-semibold text-center hover:from-blue-700 hover:to-indigo-700 transition-all flex items-center justify-center disabled:opacity-50"
                    disabled>
              {{ $skipExtras ? 'Continue to Date & Time' : 'Continue to Extras' }}
              <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </button>
          </div>
        </form>

        {{-- Cancel --}}
        <form method="POST" action="{{ route('booking.cancel') }}" class="mt-6 text-center" data-aos="fade-up" data-aos-delay="300">
          @csrf
          <button type="submit" class="inline-flex items-center text-red-600 hover:underline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Cancel Booking
          </button>
        </form>
      </main>

      {{-- Sidebar --}}
      <aside class="sticky top-28" data-aos="fade-left" data-aos-delay="300">
        <div class="bg-white rounded-2xl shadow-lg p-6 space-y-4 text-gray-800">
          <h2 class="text-xl font-semibold mb-2">Appointment Summary</h2>
          <div class="space-y-2 text-sm">
            <div class="flex justify-between">
              <span>Service</span>
              <span>${{ number_format($service->price ?? 0,2) }}</span>
            </div>
            <div class="flex justify-between">
              <span>Vehicle</span>
              <span id="summary-vehicle-price">
                {{ session('booking.vehicle_price_id')
                    ? '$'.number_format(optional($vehiclePrices->firstWhere('id', session('booking.vehicle_price_id')))->price ?? 0,2)
                    : '–'
                }}
              </span>
            </div>
          </div>
        </div>
      </aside>

    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const radios       = document.querySelectorAll('input[name="vehicle_price_id"]');
    const nextBtn      = document.getElementById('next-btn');
    const summaryPrice = document.getElementById('summary-vehicle-price');

    function clearSelectionStyles() {
      document.querySelectorAll('label.vehicle-option').forEach(lbl => {
        lbl.classList.remove('selected');
      });
    }

    radios.forEach(radio => {
      radio.addEventListener('change', () => {
        clearSelectionStyles();
        const lbl = radio.closest('label.vehicle-option');
        if (lbl) {
          lbl.classList.add('selected');
        }
        nextBtn.disabled = false;
        nextBtn.removeAttribute('disabled');
        if (summaryPrice) {
          summaryPrice.textContent = '$' + radio.dataset.price;
        }
      });
    });

    const pre = Array.from(radios).find(r => r.checked);
    if (pre) {
      pre.dispatchEvent(new Event('change'));
    }
  });
</script>

@endsection