{{-- resources/views/public/appointments/show.blade.php --}}
@extends('public.layout')

@section('content')
<div class="pt-28 min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100" data-aos="fade-up">
  <div class="max-w-3xl mx-auto px-4 lg:px-0 py-8" data-aos="fade-down">
    <h1 class="text-3xl font-bold mb-6">Appointment #{{ $appointment->id }}</h1>
  </div>

  <div class="max-w-3xl mx-auto px-4 lg:px-0" data-aos="fade-right" data-aos-delay="100">
    <div class="bg-white rounded-2xl shadow-lg p-6 space-y-4 text-gray-800 text-sm sm:text-base">
      <p><strong>Client:</strong> {{ $appointment->customer->name }} ({{ $appointment->customer->phone_number }})</p>
      
      <p>
        <strong>Service:</strong>
        {{ $appointment->serviceVehiclePrice->service->name }} — 
        {{ $appointment->serviceVehiclePrice->vehicleType->name }}
        <span class="text-gray-500">(${{ number_format($appointment->serviceVehiclePrice->price, 2) }})</span>
      </p>
      
      @if($appointment->appointmentExtras->isNotEmpty())
        <p>
          <strong>Extras:</strong>
          {{ $appointment->appointmentExtras
              ->map(fn($ae) => $ae->aLaCarteService->name . ' ($'.number_format($ae->aLaCarteService->price, 2).')')
              ->join(', ') }}
        </p>
      @endif

      <p>
        <strong>Date & Time:</strong>
        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y \a\t g:i A') }}
      </p>

      <p><strong>Address for Service:</strong> {{ $appointment->customer->address }}</p>

      @if(!empty($appointment->notes))
        <p><strong>Client Notes:</strong> {{ $appointment->notes }}</p>
      @endif

      <p><strong>Status:</strong> {{ $appointment->status }}</p>

      <p class="text-lg font-semibold"><strong>Total:</strong> ${{ number_format($appointment->total_price, 2) }}</p>
    </div>
  </div>

  @php
    $message = urlencode(
      "Appointment #{$appointment->id}\n" .
      "Client: {$appointment->customer->name} ({$appointment->customer->phone_number})\n" .
      "Service: {$appointment->serviceVehiclePrice->service->name} - {$appointment->serviceVehiclePrice->vehicleType->name}\n" .
      ($appointment->appointmentExtras->isNotEmpty() ? "Extras: " . $appointment->appointmentExtras->map(fn($ae) => $ae->aLaCarteService->name)->join(', ') . "\n" : '') .
      "Date & Time: " . \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y \a\t g:i A') . "\n" .
      "Address: {$appointment->customer->address}\n" .
      (!empty($appointment->notes) ? "Notes: {$appointment->notes}\n" : '') .
      "Status: {$appointment->status}\n" .
      "Total: $" . number_format($appointment->total_price, 2)
    );
    $phone = '+14253506740';
  @endphp

  <div class="max-w-3xl mx-auto px-4 lg:px-0 mt-6 space-y-2 text-center" data-aos="fade-up" data-aos-delay="200">
    <p class="text-gray-600 text-sm">
      <strong>Note:</strong> If you're using a <span class="font-semibold">computer</span>, use the WhatsApp button. 
      On a <span class="font-semibold">mobile device</span>, both options (SMS or WhatsApp) will work.
    </p>
    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-4">
      <a href="https://wa.me/{{ $phone }}?text={{ $message }}"
         class="inline-block px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
        📱 Send via WhatsApp
      </a>
      <a href="sms:{{ $phone }}?body={{ $message }}"
         class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
        📩 Send via SMS
      </a>
      <a href="{{ route('public.home') }}"
         class="inline-block px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition">
        ← Back to Home
      </a>
    </div>
  </div>
</div>
@endsection