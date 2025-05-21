@extends('public.layout')

@section('content')

{{-- Hero --}}
<section class="hero">
  @php
    $bgImage = asset('services/interior-cleaning/bmw-2.jpg');
    @endphp

    <div class="hero-image" style="background-image: url('{{ $bgImage }}');">
    <div class="hero-content">
      <h1>Premium Products</h1>
      <p>We bring the shine to your driveway!</p>
    </div>
  </div>
  <div class="hero-white">
    <div class="hero-text">
      <h2>Give your car the care it deserves!</h2>
      <p>
        At Wayra Auto Detailing, we provide exceptional detailing services using cutting-edge techniques and high-quality products. Our skilled Vehicle Appearance Technicians will meticulously clean, restore, and finish your vehicle, ensuring it looks and feels like new.
      </p>
    </div>
  </div>
</section>

<style>
.hero {
  display: flex;
  flex-direction: column;
  height: 70vh;
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
  padding: 1rem 1rem;
  border-radius: 10px;
}

.hero-white {
  height: 20vh;
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

{{-- Sección de introducción con logo y descripción --}}
<section class=" bg-white text-gray-800">
  <div class="container mx-auto px-4 text-center">
    <div class="mb-10">
      <img src="{{ asset('logo/logopng.png') }}" alt="Wayra Auto Detailing" class="mx-auto mb-4 h-52" />
      <h1 class="text-4xl font-bold">Products For The Perfectionist</h1>
      <p class="text-lg pt-4">
        Wayra Auto Detailing features a premier all-hand carwash facility. Your car will be pampered by an expert trained team who wash your car completely by hand with the best products.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
      <div>
        <img src="{{ asset('carwash/adams.png') }}" alt="Adam's Polishes" class="mx-auto mb-4" />
        <p class="text-lg">
          Wayra Auto Detailing carries only the finest grade car care and detailing products available from the world’s leading manufacturers.
        </p>
      </div>
      <div>
        <img src="{{ asset('carwash/griots.png') }}" alt="Griot's Garage" class="mx-auto mb-4" />
        <p class="text-lg">
          Griot's Garage produces a full line of automotive products that represent "Car Care for the Perfectionist!"
        </p>
      </div>
      <div>
        <img src="{{ asset('carwash/swiss.png') }}" alt="Swissvax" class="mx-auto mb-4" />
        <p class="text-lg">
          Swissvax offers high-performance car care products. Our goal is to provide the very best in auto and boat detailing products.
        </p>
      </div>
    </div>
  </div>
</section>

{{-- ProductSection inline component --}}

@php
  $products = [
    [
      'title' => "Adam's Polishes",
      'subtitle' => "Inspiring Everyone to Achieve Shine Perfection",
      'description' => "Adam's Premium Car Care signature product line includes car wax, sealants, dressings, cleaners, and polishes – all guaranteed to outshine and outlast any product you've used on your vehicle. Our products are not mass-produced and each is carefully formulated with special blends of high-quality polymers, acrylics, and waxes.",
      'buttonText' => "View Details",
      'buttonLink' => url('/contactform'),
      'imageUrl' => asset('carwash/adams.png'),
      'imageAlt' => "Adam's Polishes",
    ],
    [
      'title' => "Griot's Car Care",
      'subtitle' => "",
      'description' => "Griot's Garage produces a full line of automotive products that represent 'Car Care for the Perfectionist!' Now in business over 21 years, Griot's team formulates and produces their liquid products right here in their own factory in Indiana.",
      'buttonText' => "View Details",
      'buttonLink' => url('/contactform'),
      'imageUrl' => asset('carwash/griots.png'),
      'imageAlt' => "Griot's Car Care",
    ],
    [
      'title' => "Swissvax",
      'subtitle' => "",
      'description' => "At Wayra Deep Down Detail, we proudly offer Swissvax, a premium car care system handcrafted in Switzerland. With a legacy dating back to 1930, Swissvax combines luxury and performance with its high-quality Carnauba wax formulations, providing exceptional care and protection for vehicles. Designed for those who seek perfection, Swissvax delivers unparalleled results for enthusiasts who demand only the best. At Wayra, we believe that when excellence is the standard, Swissvax is the ultimate solution for maintaining your vehicle's beauty.",
      'buttonText' => "View Details",
      'buttonLink' => url('/contactform'),
      'imageUrl' => asset('carwash/swiss.png'),
      'imageAlt' => "Swissvax",
    ],
  ];
@endphp

@foreach ($products as $product)
  <section class="py-16 bg-white text-gray-800">
    <div class="container mx-auto px-4 flex flex-col lg:flex-row items-center space-x-6 lg:space-y-0 lg:space-x-6">
      <!-- Imagen del producto -->
      <div class="w-56 flex-shrink-0">
        <img src="{{ $product['imageUrl'] }}" alt="{{ $product['imageAlt'] }}" class="rounded-lg shadow-md" />
      </div>

      <!-- Información del producto -->
      <div class="flex-grow">
        <h2 class="text-3xl font-bold mb-2">{{ $product['title'] }}</h2>
        @if ($product['subtitle'])
          <h3 class="text-xl italic text-gray-600 mb-4">{{ $product['subtitle'] }}</h3>
        @endif
        <p class="mb-6">{{ $product['description'] }}</p>
     </div>
    </div>
  </section>
@endforeach

{{-- Location component (as included previously) --}}
@include('public.components.location')

@endsection