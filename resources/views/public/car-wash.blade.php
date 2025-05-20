@extends('public.layout')

@section('content')

{{-- Hero --}}
<section class="hero">

    @php
    $bgImage = asset('services/exterior-cleaning/bmw-1.png');
    @endphp

    <div class="hero-image" style="background-image: url('{{ $bgImage }}');">


    <div class="hero-content">
      <h1>Premium Car Wash</h1>
      <p>We bring the shine to your driveway!</p>
    </div>
  </div>
  <div class="hero-white">
    <div class="hero-text">
      <h2>Give your car a fresh</h2>
      <p>
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
}

.hero-image {
  height: 45vh;
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-align: center;
}

.hero-content {
  background-color: rgba(0, 0, 0, 0.5);
  padding: 1rem 2rem;
  border-radius: 10px;
}

.hero-white {
  height: 40vh;
  background-color: white;
  display: flex;
  align-items: center;
  justify-content: center;
}

.hero-text h2 {
  font-size: 2.5rem;
  color: #333;
  margin: 0;
  text-align: center;
  font-weight: bold;
}

.hero-text p {
  font-size: 1.2rem;
  color: #333;
  margin: 0;
  text-align: center;
  font-weight: normal;
}

h1 {
  font-size: 2.5rem;
  margin: 0;
}

p {
  font-size: 1.25rem;
}
</style>

{{-- Sección de introducción con botón --}}
<section class="bg-gray-900 text-white py-16">
  <div class="container mx-auto px-4 text-center">
    <h1 class="text-4xl font-bold">Wayra Deep Down Detail</h1>
    <p class="text-lg mt-4">Premium Auto Detailing Services</p>
    <a href="{{ url('/contactform') }}" class="mt-6 inline-block bg-red-500 hover:bg-red-600 text-white py-2 px-6 rounded-full">Book Now</a>
  </div>
</section>

{{-- Servicios dinámicos filtrados por categoría SUPER WASH (id=1) --}}
<section id="services" class="py-16 bg-white text-gray-800">
  <div class="container mx-auto px-4 space-y-16">

    @php
      $superWashCategory = $categories->firstWhere('id', 1);
    @endphp

    @if ($superWashCategory && $superWashCategory->services->count())
      <h2 class="text-3xl font-bold mb-8 text-center text-red-600">{{ $superWashCategory->category_name }}</h2>

      @foreach ($superWashCategory->services->sortBy('id') as $index => $service)
        @php
          $reverse = $index % 2 === 0;
        @endphp

        <section class="py-16 bg-white text-gray-800">
          <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row {{ $reverse ? 'lg:flex-row-reverse' : '' }} gap-8 items-start">
              <!-- Detalles del Servicio -->
              <div class="bg-gray-50 p-6 shadow-lg rounded-md lg:w-1/2">
                <h2 class="text-3xl font-bold mb-2 text-red-600">{{ $service->name }}</h2>
                <p class="text-lg font-semibold mb-2">{{ $service->tagline ?? 'Duration and price info not available' }}</p>

                @if ($service->exterior_description)
                  <div class="mb-4">
                    <p class="font-bold">Exterior Cleaning:</p>
                    <p class="text-sm leading-relaxed text-gray-700">{{ $service->exterior_description }}</p>
                  </div>
                @endif

                @if ($service->interior_description)
                  <div class="mb-4">
                    <p class="font-bold">Interior Cleaning:</p>
                    <p class="text-sm leading-relaxed text-gray-700">{{ $service->interior_description }}</p>
                  </div>
                @endif

                <a href="{{ route('public.book', $service->id) }}" class="mt-4 inline-block bg-black text-white py-2 px-4 rounded-md hover:bg-gray-700">
                  Schedule Now
                </a>
              </div>

              <!-- Tabla de Precios -->
              <div class="bg-white p-4 shadow-md rounded-md lg:w-1/2">
                <h3 class="text-xl font-semibold mb-4">Vehicle Pricing</h3>
                <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm">
                  <thead>
                    <tr class="bg-gray-200">
                      <th class="border border-gray-300 text-left px-3 py-2">Vehicle Type</th>
                      <th class="border border-gray-300 text-right px-3 py-2">Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($service->serviceVehiclePrices as $price)
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
      <p class="text-center">No Car Wash services available at the moment.</p>
    @endif

  </div>
</section>

@endsection