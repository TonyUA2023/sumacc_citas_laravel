{{-- resources/views/public/car-wash.blade.php --}}
@extends('public.layout')

@section('content')

<div class="overflow-x-hidden overflow-y-hidden">

  @php
      // Imágenes para el carrusel del Hero
      $heroImages = [
        asset('carros/wash2.jpg'),
          asset('carros/wash1.jpg'),
          asset('carros/wash3.jpg'),
          asset('carros/wash4.jpg'),
          asset('carros/wash5.jpg'),
          asset('carros/wash6.jpg'),
          asset('carros/wash7.jpg'),
      ];
      $superWashCategory = $categories->firstWhere('id', 1);
      $firstServiceId = optional($superWashCategory->services->first())->id;
  @endphp

  {{-- Hero Section Dark con Carrusel --}}
  <section
    class="relative w-full h-screen bg-black overflow-hidden"
    data-aos="fade"
    data-aos-duration="1000"
  >
    {{-- Swiper Container --}}
    <div class="swiper hero-swiper absolute inset-0">
      <div class="swiper-wrapper">
        @foreach($heroImages as $img)
          <div class="swiper-slide">
            <div
              class="absolute inset-0 bg-cover bg-center filter brightness-50"
              style="background-image: url('{{ $img }}'); transform: scale(1.05);"
            ></div>
          </div>
        @endforeach
      </div>

      {{-- Progress Bar Pagination --}}
      <div class="swiper-pagination swiper-pagination-progressbar !bottom-10"></div>
    </div>

    {{-- Dark Gradient Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-b from-black/90 via-black/70 to-black/90"></div>
    {{-- Semi-Opaque Black Layer --}}
    <div class="absolute inset-0 bg-black/50"></div>

    {{-- Hero Content --}}
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-6">
      <h1
        class="text-5xl md:text-7xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-red-500 drop-shadow-lg"
        data-aos="fade-up"
        data-aos-delay="200"
      >
        PREMIUM HAND SUPER WASH
      </h1>
      <p
        class="mt-4 text-lg md:text-2xl text-gray-300 max-w-2xl"
        data-aos="fade-up"
        data-aos-delay="400"
      >
        We bring the shine to your driveway with a touch of elegance and precision.
      </p>
    </div>
  </section>

    {{-- Premium Brands Showcase --}}
  <section class="relative bg-gradient-to-b from-black via-gray-950 to-black py-20 overflow-hidden">
    <div class="absolute inset-0 bg-blue-900/5"></div>

    <div class="relative" data-aos="fade">
      <h4 class="text-center text-2xl font-light text-gray-500 mb-12 tracking-widest uppercase">Trusted by Premium Brands</h4>

      <div class="relative flex overflow-hidden">
        <div class="flex animate-infinite-scroll whitespace-nowrap">
          @php
          $brands = [
          'audi.png', 'bmw.png', 'corvet.png', 'ferrrari.png', 'ford.png',
          'lambo.png', 'maseratti.png', 'mercedes.png', 'tesla.png',
          'toyota.png', 'volkswagen.png'
          ];
          $allBrands = array_merge($brands, $brands, $brands); // triplicado para efecto continuo
          @endphp

          @foreach($allBrands as $logo)
          <div class="flex-shrink-0 mx-8">
            <img
              src="{{ asset('brands/' . $logo) }}"
              alt="{{ pathinfo($logo, PATHINFO_FILENAME) }}"
              class="h-20 md:h-24 object-contain filter brightness-50 hover:brightness-100 transition-all duration-500 transform hover:scale-110" />
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- Servicios Super Wash en Dark Mode --}}
  <section
    id="services"
    class="py-16 bg-gray-900 text-gray-200 px-6 lg:px-16 overflow-x-hidden overflow-y-hidden"
  >
    <div class="container mx-auto space-y-12">
      @if($superWashCategory && $superWashCategory->services->count())
        <h2 class="text-3xl font-bold text-center text-red-400" data-aos="fade-up">
          {{ $superWashCategory->category_name }}
        </h2>
        @foreach($superWashCategory->services->sortBy('id') as $index => $service)
          @php $reverse = $index % 2 === 0; @endphp
          <div
            class="flex flex-col lg:flex-row {{ $reverse ? 'lg:flex-row-reverse' : '' }} gap-8 items-stretch"
            data-aos="fade-up"
            data-aos-delay="{{ $index * 100 }}"
          >
            {{-- Detalles Servicio --}}
            <div class="bg-gray-800 p-6 rounded-2xl shadow-lg lg:w-1/2">
              <h3 class="text-2xl font-bold text-red-400 mb-2">{{ $service->name }}</h3>
              <p class="italic mb-4">{{ $service->tagline }}</p>
                         @if($service->description)
              <p class="mb-2">{{ $service->description }}</p>
            @endif

            @if($service->recommended_frequency)
            <p class="mb-4">Recommendation: {{ $service->recommended_frequency }}</p>
            @endif
            @if($service->exterior_description)
              <div class="mb-3">
                <p class="font-semibold">Exterior Cleaning:</p>
                <p class="text-gray-400">{{ $service->exterior_description }}</p>
              </div>
            @endif

            @if($service->interior_description)
              <div class="mb-3">
                <p class="font-semibold">Interior Cleaning:</p>
                <p class="text-gray-400">{{ $service->interior_description }}</p>
              </div>
            @endif

              <a
                href="{{ route('booking.service', ['service' => $service->id]) }}"
                class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-full transition"
              >
                Schedule Now
              </a>
            </div>

            {{-- Tabla Precios --}}
            <div class="bg-gray-800 p-4 rounded-2xl shadow-inner overflow-x-auto lg:w-1/2">
              <h4 class="text-xl font-semibold mb-3">Vehicle Pricing</h4>
              <table class="min-w-full table-auto text-sm">
                <thead>
                  <tr class="bg-gray-700">
                    <th class="px-4 py-2 text-left">Vehicle Type</th>
                    <th class="px-4 py-2 text-right">{{ $service->price_label }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($service->serviceVehiclePrices->sortBy('vehicleType.id') as $price)
                    <tr class="{{ $loop->even ? 'bg-gray-800' : '' }}">
                      <td class="px-4 py-2">{{ $price->vehicleType->name }}</td>
                      <td class="px-4 py-2 text-right text-green-400">
                        ${{ number_format($price->price, 2) }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @endforeach
      @else
        <p class="text-center text-gray-400">No Car Wash services available.</p>
      @endif
    </div>
  </section>

  {{-- A La Carte Extras --}}
  <section
    id="a-la-carte"
    class="py-16 bg-gray-800 text-gray-200 px-6 lg:px-20 overflow-x-hidden overflow-y-hidden"
  >
    <div class="text-center mb-8" data-aos="fade-up">
      <h2 class="text-3xl font-bold text-red-400">A La Carte Services</h2>
      <p class="mt-2 text-gray-400">Add these extras to any wash</p>
    </div>
    <div class="overflow-x-auto" data-aos="fade-up" data-aos-delay="200">
      <table class="min-w-full table-auto text-sm">
        <thead>
          <tr class="bg-gray-700">
            <th class="px-4 py-2 text-left">Service</th>
            <th class="px-4 py-2 text-right">Price</th>
          </tr>
        </thead>
        <tbody>
          @foreach($aLaCarteServices as $extra)
            <tr class="{{ $loop->even ? 'bg-gray-800' : '' }}">
              <td class="px-4 py-2">{{ $extra->name }}</td>
              <td class="px-4 py-2 text-right">
                {{ is_null($extra->price) ? 'Inquire' : '$'.number_format($extra->price, 2) }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>

<section
  id="gallery"
  class="py-16 bg-gray-900 text-gray-200 px-6 lg:px-16 overflow-hidden"
  data-aos="fade-up"
>
  <!-- Título -->
  <h2 class="text-3xl font-bold text-center mb-12 text-red-400">Gallery & Video</h2>

  <!-- Galería de imágenes -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
    @foreach (range(1, 11) as $i)
      <div class="h-96 bg-cover bg-center rounded-lg shadow-lg" style="background-image:url('{{ asset("carros/wash{$i}.jpg") }}')"></div>
    @endforeach
  </div>

  <!-- Galería de videos responsiva -->
  <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
    @foreach (range(5, 9) as $v)
      <div class="aspect-w-16 aspect-h-9">
        <video
          class="w-full h-[35rem] rounded-lg object-cover shadow-lg"
          src="{{ asset("carros/VID{$v}.mp4") }}"
          autoplay
          muted
          loop
          controls
          playsinline
        ></video>
      </div>
    @endforeach
  </div>
</section>
</div> {{-- cierre overflow wrapper --}}

<style>
  .hero-swiper .swiper-slide > div {
    transition: transform 10s ease-out;
  }
  .swiper-pagination-bullet-active {
    background: #ff4d4d;
  }

  /* Progressbar Container */
  .swiper-pagination-progressbar {
    position: absolute;
    bottom: 10px !important;
    left: 0;
    width: 100%;
    height: 4px;
    background: rgba(255, 255, 255, 0.2);
    z-index: 10;
  }

  /* Progressbar Fill */
  .swiper-pagination-progressbar-fill {
    background: #ff4d4d;
    width: 0%;
    height: 100%;
    transition: width 0.3s ease;
  }

    @keyframes infinite-scroll {
    0% {
      transform: translateX(0);
    }

    100% {
      transform: translateX(-33.333%);
    }

    /* Ajusta este valor según el contenido */
  }

  .animate-infinite-scroll {
    animation: infinite-scroll 40s linear infinite;
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.hero-swiper', {
      loop: true,
      autoplay: { delay: 2000, disableOnInteraction: false },
      effect: 'fade',
      fadeEffect: { crossFade: true },
      speed: 1000,
      pagination: {
        el: '.swiper-pagination',
        type: 'progressbar'
      },
    });
    AOS.init({ duration: 800, once: true });
  });
</script>
@endsection