@extends('public.layout')

@section('content')

{{-- Hero --}}
<section class="hero">

    @php
    $bgImage = asset('services/exterior-cleaning/bmw-1.png');
    @endphp

    <div class="hero-image" style="background-image: url('{{ $bgImage }}');">
        <div class="hero-content px-4 sm:px-6 lg:px-8 text-center">
          <h1 class="text-3xl sm:text-4xl font-bold text-white leading-tight">Premium Car Wash</h1>
          <p class="text-base sm:text-lg text-white mt-2 max-w-xl mx-auto">We bring the shine to your driveway!</p>
        </div>
    </div>
    <div class="hero-white flex items-center justify-center bg-white py-10 px-4 sm:px-6 lg:px-8">
        <div class="hero-text max-w-3xl text-center">
          <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">Give your car a fresh</h2>
          <p class="text-base sm:text-lg text-gray-700">
            Clean look with Wayra Auto Detailing's top-quality car wash services. Our team will make sure your vehicle is spotless and shining, inside and out.
          </p>
        </div>
    </div>
</section>

<style>
.hero {
  display: flex;
  flex-direction: column;
  height: 85vh;
  min-height: 500px;
  max-height: 800px;
  width: 100%;
}

.hero-image {
  height: 45vh;
  min-height: 250px;
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-align: center;
}

.hero-content h1,
.hero-content p {
  text-shadow: 0 0 8px rgba(0,0,0,0.7);
}

.hero-white {
  height: 40vh;
  min-height: 220px;
}

.hero-text h2,
.hero-text p {
  margin: 0 auto;
}

/* Responsive typography */
@media (max-width: 768px) {
  .hero-content h1 {
    font-size: 1.875rem; /* 30px */
  }
  .hero-content p {
    font-size: 1rem;
  }
  .hero-text h2 {
    font-size: 1.5rem;
  }
  .hero-text p {
    font-size: 1rem;
  }
}
</style>

{{-- Sección de introducción con botón --}}
<section class="bg-gray-900 text-white py-16 px-4 sm:px-6 lg:px-8 text-center">
  <div class="container max-w-4xl mx-auto">
    <h1 class="text-3xl sm:text-4xl font-bold">Wayra Deep Down Detail</h1>
    <p class="text-base sm:text-lg mt-4">Premium Auto Detailing Services</p>
    <a href="{{ url('/contactform') }}" class="mt-6 inline-block bg-red-500 hover:bg-red-600 text-white py-2 px-6 rounded-full text-base sm:text-lg">Book Now</a>
  </div>
</section>

{{-- Servicios dinámicos filtrados por categoría SUPER WASH (id=1) --}}
<section id="services" class="py-16 bg-white text-gray-800 px-4 sm:px-6 lg:px-8">
  <div class="container max-w-7xl mx-auto space-y-16">

    @php
      $superWashCategory = $categories->firstWhere('id', 1);
    @endphp

    @if ($superWashCategory && $superWashCategory->services->count())
      <h2 class="text-3xl sm:text-4xl font-bold mb-8 text-center text-red-600">{{ $superWashCategory->category_name }}</h2>

      @foreach ($superWashCategory->services->sortBy('id') as $index => $service)
        @php
          $reverse = $index % 2 === 0;
        @endphp

        <section class="bg-white text-gray-800">
          <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col lg:flex-row {{ $reverse ? 'lg:flex-row-reverse' : '' }} gap-6 lg:gap-8 items-start">
              <!-- Detalles del Servicio -->
              <div class="bg-gray-50 p-6 shadow-lg rounded-md lg:w-1/2">
                <h2 class="text-2xl sm:text-3xl font-bold mb-2 text-red-600">{{ $service->name }}</h2>
                <p class="text-base sm:text-lg font-semibold mb-2">{{ $service->tagline ?? 'Duration and price info not available' }}</p>

                @if ($service->exterior_description)
                  <div class="mb-4">
                    <p class="font-bold">Exterior Cleaning:</p>
                    <p class="text-sm sm:text-base leading-relaxed text-gray-700">{{ $service->exterior_description }}</p>
                  </div>
                @endif

                @if ($service->interior_description)
                  <div class="mb-4">
                    <p class="font-bold">Interior Cleaning:</p>
                    <p class="text-sm sm:text-base leading-relaxed text-gray-700">{{ $service->interior_description }}</p>
                  </div>
                @endif

                <a href="{{ route('public.book', $service->id) }}" class="mt-4 inline-block bg-black text-white py-2 px-4 rounded-md hover:bg-gray-700 text-base sm:text-lg">
                  Schedule Now
                </a>
              </div>

              <!-- Tabla de Precios -->
              <div class="bg-white p-4 shadow-md rounded-md lg:w-1/2 overflow-x-auto">
                <h3 class="text-xl sm:text-2xl font-semibold mb-4">Vehicle Pricing</h3>
                <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm sm:text-base">
                  <thead>
                    <tr class="bg-gray-200">
                      <th class="border border-gray-300 text-left px-3 py-2">Vehicle Type</th>
                      <th class="border border-gray-300 text-right px-3 py-2">Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($service->serviceVehiclePrices->sortBy(function($price) {
                        return $price->vehicleType->id ?? 0;
                    }) as $price)
                      <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                        <td class="border border-gray-300 px-3 py-2">{{ $price->vehicleType->name ?? 'N/A' }}</td>
                        <td class="border border-gray-300 text-right px-3 py-2">${{ number_format($price->price, 2) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
      @endforeach

    @else
      <p class="text-center text-base sm:text-lg">No Car Wash services available at the moment.</p>
    @endif

  </div>
</section>

@endsection