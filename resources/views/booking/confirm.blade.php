{{-- resources/views/booking/confirm.blade.php --}}
@extends('public.layout')

@section('content')
@php
  use Carbon\Carbon;
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
        <li class="text-gray-700 font-medium">Step 6: Confirm Your Appointment</li>
      </ol>
    </nav>

    {{-- Stepper --}}
    <div class="mb-10" data-aos="fade-down" data-aos-delay="100">
      <div class="flex items-center justify-center space-x-4">
        {{-- Steps 1–5 Completed --}}
        @foreach([1,2,3,4,5] as $n)
          <div class="flex items-center space-x-2">
            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white">
              @if($n<6) ✓ @else {{ $n }} @endif
            </div>
            <span class="text-blue-600 {{ $n===5?'font-semibold':'' }}">
              {{ ["Service","Vehicle","Extras","Date & Time","Your Info"][$n-1] }}
            </span>
          </div>
          @if($n < 5)
            <div class="flex-1 h-px bg-gray-300"></div>
          @endif
        @endforeach
        <div class="flex-1 h-px bg-gray-300"></div>
        {{-- Step 6 Active --}}
        <div class="flex items-center space-x-2">
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">6</div>
          <span class="text-blue-600 font-semibold">Confirm</span>
        </div>
      </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
      
      {{-- Main panel: Review --}}
      <main class="lg:col-span-2 space-y-6" data-aos="fade-right" data-aos-delay="200">
        <h1 class="text-2xl font-bold mb-2">Step 6: Confirm Your Appointment</h1>
        <p class="text-gray-600 mb-4">Please review all your details below before confirming.</p>

        <div class="bg-white p-8 rounded-2xl shadow-lg space-y-4">
          <h2 class="text-xl font-semibold mb-2">Review Your Details</h2>
          <dl class="grid grid-cols-1 gap-y-4 gap-x-8 text-gray-800">
            <div class="sm:flex sm:justify-between">
              <dt class="font-medium">Service:</dt>
              <dd>{{ $service->name }}</dd>
            </div>
            <div class="sm:flex sm:justify-between">
              <dt class="font-medium">Vehicle:</dt>
              <dd>{{ $vehicle->vehicleType->name }} — ${{ number_format($vehicle->price,2) }}</dd>
            </div>
            <div class="sm:flex sm:justify-between">
              <dt class="font-medium">Extras:</dt>
              <dd>
                @if($extras->isEmpty())
                  None
                @else
                  @foreach($extras as $extra)
                    {{ $extra->name }} (${{ number_format($extra->price,2) }})@if(! $loop->last), @endif
                  @endforeach
                @endif
              </dd>
            </div>
            <div class="sm:flex sm:justify-between">
              <dt class="font-medium">Date:</dt>
              <dd>{{ Carbon::parse(session('booking.appointment_date'))->format('F j, Y') }}</dd>
            </div>
            <div class="sm:flex sm:justify-between">
              <dt class="font-medium">Time:</dt>
              <dd>{{ Carbon::parse(session('booking.appointment_date').' '.session('booking.appointment_time'))->format('g:i A') }}</dd>
            </div>
            <div class="sm:flex sm:justify-between">
              <dt class="font-medium">Name:</dt>
              <dd>{{ $customer->name }}</dd>
            </div>
            <div class="sm:flex sm:justify-between">
              <dt class="font-medium">Phone:</dt>
              <dd>{{ $customer->phone_number }}</dd>
            </div>
            <div class="sm:flex sm:justify-between">
              <dt class="font-medium">Email:</dt>
              <dd>{{ $customer->email ?? '—' }}</dd>
            </div>
            <div class="sm:flex sm:justify-between">
              <dt class="font-medium">Address:</dt>
              <dd>{{ $customer->address }}</dd>
            </div>
          </dl>
        </div>

        <div class="flex gap-4">
          <a href="{{ route('booking.client') }}"
             class="flex-1 px-6 py-3 bg-white border border-gray-300 rounded-lg text-center text-gray-700 hover:bg-gray-100 transition">
            &larr; Back
          </a>
          <form method="POST" action="{{ route('booking.confirm.store') }}" class="flex-1">
            @csrf
            <button type="submit"
                    class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
              Confirm Appointment
            </button>
          </form>
        </div>
      </main>

      {{-- Sidebar: Summary --}}
      <aside class="sticky top-28" data-aos="fade-left" data-aos-delay="300">
        <div class="bg-white p-6 rounded-2xl shadow-lg space-y-4 text-gray-800">
          <h2 class="text-lg font-semibold mb-2">Order Summary</h2>
          <div class="space-y-2 text-sm">
            <div class="flex justify-between">
              <span>Service</span>
              <span>${{ number_format($service->price ?? 0,2) }}</span>
            </div>
            <div class="flex justify-between">
              <span>Vehicle</span>
              <span>${{ number_format($vehicle->price,2) }}</span>
            </div>
            @if($extras->isNotEmpty())
              @foreach($extras as $extra)
                <div class="flex justify-between">
                  <span>{{ $extra->name }}</span>
                  <span>${{ number_format($extra->price,2) }}</span>
                </div>
              @endforeach
            @endif
          </div>
          <hr>
          <div class="flex justify-between font-semibold">
            <span>Total</span>
            <span>
              ${{ number_format(
                ($service->price ?? 0)
                + $vehicle->price
                + $extras->sum('price'),
              2) }}
            </span>
          </div>
        </div>
      </aside>

    </div>
  </div>
</div>
@endsection