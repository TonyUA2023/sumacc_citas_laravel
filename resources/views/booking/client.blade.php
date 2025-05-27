{{-- resources/views/booking/client.blade.php --}}
@extends('public.layout')

@section('content')
<div class="relative z-10 pt-36 min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100" data-aos="fade-up">
  <div class="container mx-auto px-4 lg:px-0 py-8">

    {{-- Breadcrumb --}}
    <nav class="mb-6 text-sm text-gray-500" aria-label="Breadcrumb" data-aos="fade-down">
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
        <li class="text-gray-700 font-medium">Step 5: Your Information</li>
      </ol>
    </nav>

    {{-- Stepper --}}
    <div class="mb-10" data-aos="fade-down" data-aos-delay="100">
      <div class="flex items-center justify-center space-x-4">
        {{-- Step 1 --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white">✓</div>
          <span class="text-blue-600">Service</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>

        {{-- Step 2 --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white">✓</div>
          <span class="text-blue-600">Vehicle</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>

        {{-- Step 3 --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white">✓</div>
          <span class="text-blue-600">Extras</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>

        {{-- Step 4 --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white">✓</div>
          <span class="text-blue-600">Date & Time</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>

        {{-- Step 5 Active --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">5</div>
          <span class="text-blue-600 font-semibold">Your Info</span>
        </div>
        <div class="flex-1 h-px bg-gray-300"></div>

        {{-- Step 6 --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">6</div>
          <span class="text-gray-500">Confirm</span>
        </div>
      </div>
    </div>

    {{-- Main grid --}}
    <div class="grid lg:grid-cols-3 gap-8">

      {{-- Main content: client form --}}
      <main class="lg:col-span-2 space-y-6" data-aos="fade-right" data-aos-delay="200">
        <h1 class="text-2xl font-bold mb-2">Step 5: Your Information</h1>
        <p class="text-gray-600 mb-4">Please provide your contact details to complete the booking.</p>

        <div class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
          <form id="client-form" method="POST" action="{{ route('booking.client.store') }}">
            @csrf

            {{-- Full Name --}}
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
              <input
                type="text"
                name="name"
                value="{{ old('name', $customer->name) }}"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="John Doe"
              >
              @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Email Address --}}
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
              <input
                type="email"
                name="email"
                value="{{ old('email', $customer->email) }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="you@example.com"
              >
              @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Phone Number --}}
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
              <input
                type="tel"
                name="phone_number"
                value="{{ old('phone_number', $customer->phone_number) }}"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="+1 (555) 123-4567"
              >
              @error('phone_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Address --}}
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
              <input
                type="text"
                name="address"
                value="{{ old('address', $customer->address) }}"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="123 Main St, City"
              >
              @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Navigation Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 mt-8">
              <a href="{{ route('booking.datetime') }}"
                 class="flex-1 text-center px-6 py-3 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                &larr; Back
              </a>
              <button type="submit"
                      class="flex-1 text-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Next &rarr;
              </button>
            </div>
          </form>

          {{-- Cancel --}}
          <form method="POST" action="{{ route('booking.cancel') }}" class="mt-4 text-center" data-aos="fade-up" data-aos-delay="300">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:underline">
              Cancel Booking
            </button>
          </form>
        </div>
      </main>

      {{-- Sidebar: Appointment Summary --}}
      <aside class="sticky top-28" data-aos="fade-left" data-aos-delay="300">
        <div class="bg-white rounded-2xl shadow-lg p-6 space-y-4 text-gray-800">
          <h2 class="text-xl font-semibold mb-2">Appointment Summary</h2>
          <div class="space-y-2 text-sm">
            <div class="flex justify-between">
              <span>Service</span>
              <span>{{ $service->name }}</span>
            </div>
            <div class="flex justify-between">
              <span>Vehicle</span>
              <span>{{ $vehicle->vehicleType->name }} — ${{ number_format($vehicle->price,2) }}</span>
            </div>
            <div class="flex justify-between">
              <span>Extras</span>
              <span>
                @if($extras->isEmpty()) None
                @else {{ $extras->pluck('name')->join(', ') }}
                @endif
              </span>
            </div>
            <div class="flex justify-between">
              <span>Date</span>
              <span>{{ \Carbon\Carbon::parse(session('booking.appointment_date'))->format('M j, Y') }}</span>
            </div>
            <div class="flex justify-between">
              <span>Time</span>
              <span>{{ \Carbon\Carbon::parse(session('booking.appointment_date').' '.session('booking.appointment_time'))->format('g:i A') }}</span>
            </div>
          </div>
          <hr>
          <div class="flex justify-between font-semibold">
            <span>Total</span>
            <span>${{ number_format($vehicle->price + $extras->sum('price'),2) }}</span>
          </div>
        </div>
      </aside>

    </div>
  </div>
</div>
@endsection