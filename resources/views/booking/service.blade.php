{{-- resources/views/booking/service.blade.php --}}
@extends('public.layout')

@section('content')
  {{-- … encabezado, breadcrumb, progreso, etc … --}}

  {{-- Main Content --}}
  <div class="max-w-4xl mx-auto pt-36 mb-20">
    <h1 class="text-3xl font-bold text-gray-300 mb-2">Confirm Your Service Selection</h1>
    <p class="text-gray-400 mb-8">Review the service details before proceeding to schedule your appointment</p>

    {{-- Service Card --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all hover:scale-[1.02]">
      {{-- Header with Image (opcional) --}}
      @if($service->image)
        <div class="h-64 relative overflow-hidden">
          <img src="{{ asset('storage/'.$service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
          <div class="absolute inset-0 bg-black/40"></div>
          <div class="absolute bottom-0 left-0 p-6 text-white">
            <h2 class="text-3xl font-bold">{{ $service->name }}</h2>
            <p class="text-lg">{{ $service->tagline }}</p>
          </div>
        </div>
      @endif

      {{-- Body --}}
      <div class="p-8">
        <div class="grid md:grid-cols-2 gap-8 mb-8">
          {{-- Descripción --}}
          <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Description</h3>
            <p class="text-gray-600 leading-relaxed">{{ $service->description }}</p>

            @if($service->exterior_description)
              <p class="mt-4 font-medium text-gray-800">Exterior:</p>
              <p class="text-gray-600">{{ $service->exterior_description }}</p>
            @endif

            @if($service->interior_description)
              <p class="mt-4 font-medium text-gray-800">Interior:</p>
              <p class="text-gray-600">{{ $service->interior_description }}</p>
            @endif
          </div>

          {{-- Detalles Rápidos --}}
          <div class="space-y-6">
            {{-- Precio Inicial --}}
            <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
              <span class="font-medium text-gray-700">Starting Price</span>
              <span class="text-2xl font-bold text-blue-600">
                ${{ number_format($service->starting_price,2) }}
              </span>
            </div>

            {{-- Etiqueta de Precio --}}
            @if($service->price_label)
            <div class="flex items-center justify-between p-4 bg-indigo-50 rounded-lg">
              <span class="font-medium text-gray-700">Price Label</span>
              <span class="text-gray-800">{{ $service->price_label }}</span>
            </div>
            @endif

            {{-- Duración Base --}}
            <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
              <span class="font-medium text-gray-700">Duration</span>
              <span class="text-lg font-semibold text-green-600">
                {{ $service->base_duration_minutes }} minutes
              </span>
            </div>

            {{-- Frecuencia Recomendada --}}
            @if($service->recommended_frequency)
            <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg">
              <span class="font-medium text-gray-700">Recommended Frequency</span>
              <span class="text-gray-800">{{ $service->recommended_frequency }}</span>
            </div>
            @endif

            {{-- Categoría --}}
            <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg">
              <span class="font-medium text-gray-700">Category</span>
              <span class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">
                {{ $service->category->category_name }}
              </span>
            </div>
          </div>
        </div>

        {{-- Botón para continuar --}}
        <div class="flex gap-4">
          <form method="POST" action="{{ route('booking.service.store') }}" class="flex-1">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">
            <button type="submit"
                    class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition">
              Continue to Vehicle
            </button>
          </form>

          <form method="POST" action="{{ route('booking.cancel') }}" class="flex-1">
            @csrf
            <button type="submit"
                    class="w-full px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition">
              Cancel
            </button>
          </form>
        </div>
      </div>
    </div>

    {{-- Información adicional --}}
    <div class="mt-8 bg-amber-50 border border-amber-200 rounded-xl p-6">
      <h4 class="font-semibold text-amber-800 mb-2">Important Information</h4>
      <p class="text-sm text-amber-700">
        Our detailing team will arrive 10 minutes in advance. If you need to cancel or reschedule your appointment, please do so at least 24 hours in advance.      </p>
    </div>
  </div>
</div>
@endsection