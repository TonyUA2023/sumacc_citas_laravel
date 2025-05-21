@extends('public.layout')

@section('content')

<section class="hero">
    <<div class="hero-image" style="background-image: url('{{ asset('services/interior-cleaning/bmw-2.jpg') }}');">

        <div class="hero-content">
            <h1>Premium Mobile Detailing</h1>
            <p>We bring the shine to your driveway!</p>
        </div>
        </div>
        <div class="hero-white">
            <div class="hero-text">
                <h2>Show your car love!</h2>
                <p>
                    Indulge it with top-notch detailing services and state-of-the-art techniques combined with premium products at the full-service Wayra Auto Detailing. Our expert Vehicle Appearance Technicians will carry out a thorough cleaning, restoration, and finishing process to get your car looking its absolute best.
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

<section id="gallery" class="bg-gray-900 text-white py-16 px-6 md:px-20">
    <!-- EXTERIOR CLEANING -->
    <div class="max-w-7xl mx-auto mb-20">
        <h3 class="text-center text-4xl font-semibold mb-8 tracking-wide uppercase">Exterior Cleaning</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-8">
            <img src="{{ asset('services/top/ext-1.jpg') }}" alt="Wayra Mobile Detailing Exterior Cleaning"
                class="rounded-xl object-cover w-full h-64 sm:h-72 md:h-80 transition-transform duration-300 hover:scale-105 shadow-lg">
            <img src="{{ asset('services/top/ext-2.jpg') }}" alt="Wayra Mobile Detailing Exterior Cleaning"
                class="rounded-xl object-cover w-full h-64 sm:h-72 md:h-80 transition-transform duration-300 hover:scale-105 shadow-lg">
            <img src="{{ asset('services/top/ext-3.jpg') }}" alt="Wayra Mobile Detailing Exterior Cleaning"
                class="rounded-xl object-cover w-full h-64 sm:h-72 md:h-80 transition-transform duration-300 hover:scale-105 shadow-lg">
        </div>
        <p class="text-center max-w-3xl mx-auto text-lg leading-relaxed text-gray-300">
            Wayra Mobile Detailing provides a complete range of services for restoring, preserving, and maintaining the exterior of your vehicle. Our team takes great pride in our work and treats every car as if it were our own. We won't settle for anything less than your car looking its very best! Let us show you just how amazing your vehicle can look after a day with Wayra Mobile Detailing.
        </p>
    </div>

    <!-- INTERIOR CLEANING -->
    <div class="max-w-7xl mx-auto mb-20 bg-white rounded-3xl py-14 px-10 shadow-xl">
        <h3 class="text-center text-4xl font-semibold mb-8 text-gray-900 tracking-wide uppercase">Interior Cleaning</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-8">
            <img src="{{ asset('services/top/int-1.jpg') }}" alt="Wayra Mobile Detailing Interior Cleaning"
                class="rounded-xl object-cover w-full h-64 sm:h-72 md:h-80 shadow-md">
            <img src="{{ asset('services/top/int-2.jpg') }}" alt="Wayra Mobile Detailing Interior Cleaning"
                class="rounded-xl object-cover w-full h-64 sm:h-72 md:h-80 shadow-md">
            <img src="{{ asset('services/top/int-3.jpg') }}" alt="Wayra Mobile Detailing Interior Cleaning"
                class="rounded-xl object-cover w-full h-64 sm:h-72 md:h-80 shadow-md">
        </div>
        <p class="text-center max-w-3xl mx-auto text-gray-700 text-lg leading-relaxed">
            At Wayra Mobile Detailing, our mission is to rejuvenate your car’s interior, making it look and feel like new. We utilize the industry’s top cleaning techniques to care for every surface inside your vehicle, using only premium products to thoroughly clean and restore them.
        </p>
    </div>
</section>

<section id="services" class="py-16 bg-white text-gray-800">
  <div class="container mx-auto px-4 space-y-16">

    @php
      $mobileDetailingCategory = $categories->firstWhere('id', 2);
    @endphp

    @if ($mobileDetailingCategory && $mobileDetailingCategory->services->count())
      <h2 class="text-3xl font-bold mb-8 text-center text-red-600">{{ $mobileDetailingCategory->category_name }}</h2>

      @foreach ($mobileDetailingCategory->services->sortBy('id') as $index => $service)
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
      <p class="text-center">No Mobile Detailing services available at the moment.</p>
    @endif

  </div>
</section>



@endsection