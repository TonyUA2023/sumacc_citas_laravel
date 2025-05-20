@extends('public.layout')

@section('content')

<!-- HERO DESKTOP -->
<section>
  <div class="w-full h-screen bg-cover bg-center flex items-center justify-center relative">
    <video autoplay muted loop class="absolute top-0 left-0 w-full h-full object-cover">
      <source src="{{ asset('vid/vid.mp4') }}" type="video/mp4" />
      Tu navegador no soporta video.
    </video>
    <div class="relative z-10 text-center space-y-4">
      <h2 class="uppercase text-5xl md:text-6xl font-extrabold tracking-wider text-white">
        Mobile Car Detail, Car Detailing
      </h2>
      <h2 class="uppercase text-4xl md:text-5xl font-bold text-gray-300">
        Seattle and Bellevue
      </h2>
      <div class="flex justify-center space-x-6 mt-6">
        <a href="#" class="border border-white py-2 px-6 text-white hover:bg-white hover:text-black transition">Premium Detailing</a>
        <a href="#" class="border border-white py-2 px-6 text-white hover:bg-white hover:text-black transition">Super Wash</a>
      </div>
    </div>
  </div>

  <!-- HERO MOBILE -->
  <div class="lg:hidden w-full h-screen bg-cover bg-center flex items-center justify-center relative">
    <video autoplay muted loop class="absolute top-0 left-0 w-full h-full object-cover">
      <source src="{{ asset('vid/vid.mp4') }}" type="video/mp4" />
      Tu navegador no soporta video.
    </video>
    <div class="relative z-10 text-center space-y-4">
      <h2 class="uppercase text-4xl font-extrabold tracking-wider text-white">
        Mobile Car Detail, Car Detailing
      </h2>
      <h2 class="uppercase text-3xl font-bold text-gray-300">
        Seattle and Bellevue
      </h2>
      <div class="flex justify-center space-x-6 mt-6">
        <a href="#" class="border border-white py-2 px-6 text-white hover:bg-white hover:text-black transition">Premium Detailing</a>
        <a href="#" class="border border-white py-2 px-6 text-white hover:bg-white hover:text-black transition">Super Wash</a>
      </div>
    </div>
  </div>

  <!-- GOOGLE REVIEWS -->
  <div class="bg-gray-900 py-8 px-4 lg:px-0">
    <div class="max-w-5xl mx-auto">
      <h3 class="text-3xl font-bold text-white text-center mb-6">Customer Feedback</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-800 p-4 rounded-lg text-center">
          <p class="text-white font-semibold">Alexander Sugar</p>
          <p class="text-yellow-500">★★★★★</p>
          <a href="https://maps.app.goo.gl/u8mpCdTyJWfDEqcp8" target="_blank" class="text-blue-500 underline">Read on Google Maps →</a>
        </div>
        <div class="bg-gray-800 p-4 rounded-lg text-center">
          <p class="text-white font-semibold">Neysha Asto</p>
          <p class="text-yellow-500">★★★★★</p>
          <a href="https://maps.app.goo.gl/u8mpCdTyJWfDEqcp8" target="_blank" class="text-blue-500 underline">Read on Google Maps →</a>
        </div>
        <div class="bg-gray-800 p-4 rounded-lg text-center">
          <p class="text-white font-semibold">Hanisha Koneru</p>
          <p class="text-yellow-500">★★★★★</p>
          <a href="https://maps.app.goo.gl/u8mpCdTyJWfDEqcp8" target="_blank" class="text-blue-500 underline">Read on Google Maps →</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- "OUR STORY" SECTION -->
<section class="bg-gray-800 py-16 px-4 text-center text-white">
  <h3 class="text-4xl font-bold mb-6">Our Story</h3>
  <p class="text-lg font-light">
    Wayra Mobile Detailing was born from a family dream fueled by a passion for cars and the perfect detail. Today, we are a reference in high-level mobile detailing services in the region, known for our excellence, trust, and superior results.
  </p>
  <p class="text-lg font-light mt-4">
    We specialize in caring for luxury, sports, and high-value vehicles, offering a personalized experience that enhances the beauty and character of each car. Quality, precision, and passion define us in every visit.
  </p>
</section>

<!-- "OUR MISSION" SECTION -->
<section class="bg-black py-16 px-4 text-center text-white">
  <h3 class="text-4xl font-bold mb-6">Our Mission</h3>
  <p class="text-lg font-light">
    At Wayra Mobile Detailing, we provide luxury automotive detailing, taking care of every detail of your vehicle. Our expert team uses advanced techniques and premium products to ensure flawless results on your car, truck, or SUV.
  </p>
  <p class="text-lg font-light mt-4">
    We offer mobile automotive detailing services at your doorstep in Seattle, Kirkland, Lynnwood, Edmonds, Bellevue, Everett, and nearby cities, providing convenience, quality, and exceptional results.
  </p>
</section>

<div class="w-[80%] h-px bg-white my-10 md:mt-24 mx-auto"></div>

<section class="py-16 bg-white mt-[50px]">

  <h2 class="text-center text-5xl font-bold mb-10">Services</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 lg:px-24">
    @php
      $services = [
        ['title' => 'All-Hand Car Wash', 'imgSrc' => 'PrincServ/1.png'],
        ['title' => 'Exterior Detailing', 'imgSrc' => 'PrincServ/2.png'],
        ['title' => 'Interior Detailing', 'imgSrc' => 'PrincServ/3.png'],
        ['title' => 'Paint Protection Film', 'imgSrc' => 'PrincServ/4.png'],
        ['title' => 'Ceramic Coatings', 'imgSrc' => 'PrincServ/5.png'],
        ['title' => 'Paint Correction', 'imgSrc' => 'PrincServ/7.png'],
        ['title' => 'Paint Touchup', 'imgSrc' => 'PrincServ/8.png'],
        ['title' => 'Headlight Repair', 'imgSrc' => 'PrincServ/10.png'],
        ['title' => 'Glass & Tint', 'imgSrc' => 'PrincServ/12.png'],
      ];
    @endphp

    @foreach ($services as $service)
      <div class="group relative overflow-hidden rounded-lg shadow-lg cursor-pointer">
        <img src="{{ asset($service['imgSrc']) }}" alt="{{ $service['title'] }}" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110" />
        <div class="absolute inset-0 bg-black opacity-40 group-hover:opacity-60 transition duration-300"></div>
        <h3 class="absolute inset-0 flex items-center justify-center text-white text-xl font-bold group-hover:opacity-100 transition duration-300">
          {{ $service['title'] }}
        </h3>
      </div>
    @endforeach
  </div>
</section>

@include('public.components.location')

@include('public.components.details')

@endsection

<style>
.btn {
  @apply bg-white/40 text-black transition-all duration-500 ease-in-out font-bold cursor-pointer;
  position: relative;
  z-index: 0;
}

.btn::before {
  content: "";
  @apply absolute inset-0 m-auto bg-[#167DC0] transition-all duration-500 ease-in-out z-[-1];
}

.btn--1::before {
  width: 0;
  height: 100%;
}

.btn--1:hover {
  @apply text-white;
}

.btn--1:hover::before {
  width: 100%;
}
</style>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const targets = document.querySelectorAll(".animated-section");

    if (targets.length > 0) {
      const observer = new IntersectionObserver(
        function (entries) {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.remove("opacity-0");
              entry.target.classList.add("animate-fade-down");
            }
          });
        },
        { threshold: 0.1 }
      );

      targets.forEach((target) => {
        target.classList.add("opacity-0");
        observer.observe(target);
      });
    } else {
      console.error("No se encontraron elementos con la clase 'animated-section'");
    }
  });
</script>