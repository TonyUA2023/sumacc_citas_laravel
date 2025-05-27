@extends('public.layout')

@section('content')

{{-- Hero Section - Premium Dark Design --}}
<section class="relative h-screen overflow-hidden bg-black">
  @php
    $bgImage = asset('services/interior-cleaning/bmw-2.jpg');
  @endphp
  
  {{-- Background Image with Parallax Effect --}}
  <div class="absolute inset-0">
    <div class="absolute inset-0 bg-cover bg-center bg-fixed opacity-40" 
         style="background-image: url('{{ $bgImage }}');"
         data-aos="zoom-out"
         data-aos-duration="2000">
    </div>
  </div>
  
  {{-- Gradient Overlays --}}
  <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/60 to-black"></div>
  
  {{-- Animated Background Elements --}}
  <div class="absolute inset-0">
    <div class="absolute top-20 right-10 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse-slow"></div>
    <div class="absolute bottom-20 left-10 w-72 h-72 bg-red-500/10 rounded-full blur-3xl animate-pulse-slow animation-delay-2000"></div>
  </div>
  
  {{-- Hero Content --}}
  <div class="relative z-10 h-full flex flex-col items-center justify-center px-4">
    <div class="text-center space-y-6" data-aos="fade-up">
      <h1 class="text-5xl md:text-7xl font-black uppercase tracking-wider">
        <span class="block text-transparent bg-gradient-to-r from-blue-400 via-white to-red-400 bg-clip-text animate-gradient">
          Premium Products
        </span>
      </h1>
      
      <div class="h-1 w-32 mx-auto bg-gradient-to-r from-transparent via-red-500 to-transparent" 
           data-aos="scale-x" 
           data-aos-delay="300">
      </div>
      
      <p class="text-xl md:text-2xl text-gray-300 font-light tracking-wide" 
         data-aos="fade-up" 
         data-aos-delay="500">
        We bring the shine to your driveway!
      </p>
    </div>
    
    {{-- Scroll Indicator --}}
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2" data-aos="fade-up" data-aos-delay="800">
      <div class="w-6 h-10 border-2 border-gray-600 rounded-full flex justify-center">
        <div class="w-1 h-3 bg-white rounded-full mt-2 animate-scroll-down"></div>
      </div>
    </div>
  </div>
</section>

{{-- Introduction Section --}}
<section class="relative bg-gradient-to-b from-black to-gray-950 py-20 overflow-hidden">
  {{-- Background Pattern --}}
  <div class="absolute inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
  </div>
  
  <div class="relative container mx-auto px-4">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-4xl md:text-5xl font-bold mb-6">
        <span class="text-white">Give your car the </span>
        <span class="text-transparent bg-gradient-to-r from-blue-400 to-red-400 bg-clip-text">care it deserves!</span>
      </h2>
      
      <p class="text-gray-300 text-lg md:text-xl max-w-4xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="200">
        At Wayra Auto Detailing, we provide exceptional detailing services using cutting-edge techniques and high-quality products. Our skilled Vehicle Appearance Technicians will meticulously clean, restore, and finish your vehicle, ensuring it looks and feels like new.
      </p>
    </div>
  </div>
</section>

{{-- Products Showcase Section --}}
<section class="relative bg-black py-24 overflow-hidden">
  <div class="container mx-auto px-4">
    {{-- Section Header --}}
    <div class="text-center mb-20" data-aos="fade-up">
      <div class="mb-8">
        <img src="{{ asset('logo/completo.png') }}" 
             alt="Wayra Auto Detailing" 
             class="mx-auto h-40 md:h-52 filter brightness-90 hover:brightness-100 transition-all duration-500"
             data-aos="zoom-in"
             data-aos-delay="200" />
      </div>
      
      <h1 class="text-4xl md:text-6xl font-black mb-6">
        <span class="text-transparent bg-gradient-to-r from-blue-400 via-white to-blue-400 bg-clip-text">
          Products For The Perfectionist
        </span>
      </h1>
      
      <p class="text-gray-300 text-lg md:text-xl max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="400">
        Wayra Auto Detailing features a premier all-hand carwash facility. Your car will be pampered by an expert trained team who wash your car completely by hand with the best products.
      </p>
    </div>

    {{-- Products Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
      @php
        $brands = [
          [
            'name' => "Adam's Polishes",
            'image' => asset('carwash/adams.png'),
            'description' => "Wayra Auto Detailing carries only the finest grade car care and detailing products available from the world's leading manufacturers.",
            'color' => 'blue'
          ],
          [
            'name' => "Griot's Garage",
            'image' => asset('carwash/griots.png'),
            'description' => "Griot's Garage produces a full line of automotive products that represent 'Car Care for the Perfectionist!'",
            'color' => 'red'
          ],
          [
            'name' => "Swissvax",
            'image' => asset('carwash/swiss.png'),
            'description' => "Swissvax offers high-performance car care products. Our goal is to provide the very best in auto and boat detailing products.",
            'color' => 'blue'
          ]
        ];
      @endphp
      
      @foreach($brands as $index => $brand)
      <div class="group relative" data-aos="fade-up" data-aos-delay="{{ $index * 200 }}">
        {{-- Card Glow Effect --}}
        <div class="absolute inset-0 bg-gradient-to-r from-{{ $brand['color'] }}-600/20 to-{{ $brand['color'] }}-600/10 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        {{-- Card Content --}}
        <div class="relative bg-gradient-to-b from-gray-900 to-gray-950 p-8 rounded-2xl border border-gray-800 hover:border-{{ $brand['color'] }}-600/50 transition-all duration-500 h-full">
          {{-- Top Accent Line --}}
          <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-{{ $brand['color'] }}-500 to-{{ $brand['color'] }}-600"></div>
          
          <div class="flex flex-col items-center text-center h-full">
            <div class="mb-6 h-32 flex items-center justify-center">
              <img src="{{ $brand['image'] }}" 
                   alt="{{ $brand['name'] }}" 
                   class="max-h-full w-auto filter brightness-90 group-hover:brightness-110 transform transition-all duration-500 group-hover:scale-110" />
            </div>
            
            <h3 class="text-2xl font-bold text-white mb-4">{{ $brand['name'] }}</h3>
            
            <p class="text-gray-400 leading-relaxed flex-grow">{{ $brand['description'] }}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Products Detail Section --}}
@php
  $products = [
    [
      'title' => "Adam's Polishes",
      'subtitle' => "Inspiring Everyone to Achieve Shine Perfection",
      'description' => "Adam's Premium Car Care signature product line includes car wax, sealants, dressings, cleaners, and polishes – all guaranteed to outshine and outlast any product you've used on your vehicle. Our products are not mass-produced and each is carefully formulated with special blends of high-quality polymers, acrylics, and waxes.",
      'buttonLink' => url('/contactform'),
      'imageUrl' => asset('carwash/adams.png'),
      'imageAlt' => "Adam's Polishes",
      'accent' => 'blue'
    ],
    [
      'title' => "Griot's Car Care",
      'subtitle' => "Car Care for the Perfectionist",
      'description' => "Griot's Garage produces a full line of automotive products that represent 'Car Care for the Perfectionist!' Now in business over 21 years, Griot's team formulates and produces their liquid products right here in their own factory in Indiana.",
      'buttonLink' => url('/contactform'),
      'imageUrl' => asset('carwash/griots.png'),
      'imageAlt' => "Griot's Car Care",
      'accent' => 'red'
    ],
    [
      'title' => "Swissvax",
      'subtitle' => "Swiss Excellence in Car Care",
      'description' => "At Wayra Deep Down Detail, we proudly offer Swissvax, a premium car care system handcrafted in Switzerland. With a legacy dating back to 1930, Swissvax combines luxury and performance with its high-quality Carnauba wax formulations, providing exceptional care and protection for vehicles. Designed for those who seek perfection, Swissvax delivers unparalleled results for enthusiasts who demand only the best. At Wayra, we believe that when excellence is the standard, Swissvax is the ultimate solution for maintaining your vehicle's beauty.",
      'buttonLink' => url('/contactform'),
      'imageUrl' => asset('carwash/swiss.png'),
      'imageAlt' => "Swissvax",
      'accent' => 'blue'
    ],
  ];
@endphp

@foreach ($products as $index => $product)
  <section class="relative py-24 overflow-hidden {{ $index % 2 == 0 ? 'bg-gray-950' : 'bg-black' }}">
    <div class="container mx-auto px-4">
      <div class="flex flex-col lg:flex-row items-center gap-12 {{ $index % 2 == 1 ? 'lg:flex-row-reverse' : '' }}">
        
        {{-- Product Image --}}
        <div class="w-full lg:w-1/3 flex-shrink-0" data-aos="fade-{{ $index % 2 == 0 ? 'right' : 'left' }}">
          <div class="relative group">
            {{-- Glow Effect --}}
            <div class="absolute inset-0 bg-gradient-to-br from-{{ $product['accent'] }}-500/30 to-transparent rounded-3xl blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            
            {{-- Image Container --}}
            <div class="relative bg-gradient-to-br from-gray-800 to-gray-900 p-12 rounded-3xl border border-gray-700 hover:border-{{ $product['accent'] }}-600/50 transition-all duration-500">
              <img src="{{ $product['imageUrl'] }}" 
                   alt="{{ $product['imageAlt'] }}" 
                   class="w-full h-auto filter brightness-90 hover:brightness-110 transform transition-all duration-500 group-hover:scale-105" />
            </div>
          </div>
        </div>

        {{-- Product Information --}}
        <div class="w-full lg:w-2/3" data-aos="fade-{{ $index % 2 == 0 ? 'left' : 'right' }}" data-aos-delay="200">
          <div class="space-y-6">
            <div>
              <h2 class="text-4xl md:text-5xl font-bold mb-3">
                <span class="text-transparent bg-gradient-to-r from-{{ $product['accent'] }}-400 to-{{ $product['accent'] }}-300 bg-clip-text">
                  {{ $product['title'] }}
                </span>
              </h2>
              
              @if ($product['subtitle'])
                <h3 class="text-xl md:text-2xl text-gray-400 italic">{{ $product['subtitle'] }}</h3>
              @endif
            </div>
            
            <div class="h-1 w-24 bg-gradient-to-r from-{{ $product['accent'] }}-500 to-transparent"></div>
            
            <p class="text-gray-300 text-lg leading-relaxed">{{ $product['description'] }}</p>
            
            {{-- Features List --}}
            <div class="grid grid-cols-2 gap-4 mt-8">
              <div class="flex items-center space-x-3">
                <div class="w-2 h-2 bg-{{ $product['accent'] }}-500 rounded-full"></div>
                <span class="text-gray-400">Premium Quality</span>
              </div>
              <div class="flex items-center space-x-3">
                <div class="w-2 h-2 bg-{{ $product['accent'] }}-500 rounded-full"></div>
                <span class="text-gray-400">Professional Grade</span>
              </div>
              <div class="flex items-center space-x-3">
                <div class="w-2 h-2 bg-{{ $product['accent'] }}-500 rounded-full"></div>
                <span class="text-gray-400">Long-lasting Results</span>
              </div>
              <div class="flex items-center space-x-3">
                <div class="w-2 h-2 bg-{{ $product['accent'] }}-500 rounded-full"></div>
                <span class="text-gray-400">Eco-Friendly Options</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endforeach

{{-- CTA Section --}}
<section class="relative bg-gradient-to-b from-black to-gray-950 py-24 overflow-hidden">
  <div class="absolute inset-0">
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
  </div>
  
  <div class="relative container mx-auto px-4 text-center" data-aos="fade-up">
    <h2 class="text-4xl md:text-5xl font-bold mb-6">
      <span class="text-white">Ready to Experience </span>
      <span class="text-transparent bg-gradient-to-r from-blue-400 to-red-400 bg-clip-text">Premium Care?</span>
    </h2>
    
    <p class="text-gray-300 text-xl mb-10 max-w-2xl mx-auto">
      Contact us today to learn more about our premium products and services. Your vehicle deserves the best.
    </p>
    
    <a href="{{ url('/detailing-services') }}" 
       class="group relative inline-flex items-center px-10 py-5 overflow-hidden rounded-lg transition-all duration-300 hover:scale-105">
      <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-red-600 to-blue-600 bg-size-200 animate-gradient-x"></div>
      <span class="relative z-10 text-white font-bold text-xl">Get Started Today</span>
      <svg class="relative z-10 w-6 h-6 ml-3 text-white transform transition-transform duration-300 group-hover:translate-x-2" 
           fill="none" 
           stroke="currentColor" 
           viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
      </svg>
    </a>
  </div>
</section>

<style>
  /* Animations */
  @keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
  }
  
  @keyframes gradient-x {
    0% { background-position: 0% 50%; }
    100% { background-position: 200% 50%; }
  }
  
  @keyframes pulse-slow {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.1); }
  }
  
  @keyframes scroll-down {
    0% { transform: translateY(0); opacity: 0; }
    40% { opacity: 1; }
    80% { transform: translateY(8px); opacity: 0; }
    100% { transform: translateY(8px); opacity: 0; }
  }
  
  /* Animation Classes */
  .animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
  }
  
  .animate-gradient-x {
    animation: gradient-x 3s ease infinite;
  }
  
  .animate-pulse-slow {
    animation: pulse-slow 4s ease-in-out infinite;
  }
  
  .animate-scroll-down {
    animation: scroll-down 2s ease-in-out infinite;
  }
  
  .animation-delay-2000 {
    animation-delay: 2000ms;
  }
  
  /* Background Size for Gradient Animation */
  .bg-size-200 {
    background-size: 200% 100%;
  }
  
  /* Gradient Text Support */
  .bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
  }
  
  /* Custom Scrollbar */
  ::-webkit-scrollbar {
    width: 12px;
  }
  
  ::-webkit-scrollbar-track {
    background: #0a0a0a;
    border-left: 1px solid #111;
  }
  
  ::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #1e40af, #dc2626);
    border-radius: 6px;
  }
  
  ::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #2563eb, #ef4444);
  }
  
  /* Ensure sections don't overflow */
  body {
    overflow-x: hidden;
    background-color: #000;
  }
  
  section {
    overflow: hidden;
  }
  
  /* Focus States */
  a:focus-visible {
    outline: 2px solid #3b82f6;
    outline-offset: 4px;
  }
</style>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Initialize AOS
    AOS.init({
      duration: 1000,
      once: true,
      offset: 100,
      easing: 'ease-out-cubic'
    });
    
    // Parallax effect for hero background
    const heroImage = document.querySelector('.bg-fixed');
    if (heroImage) {
      window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxSpeed = 0.5;
        heroImage.style.transform = `translateY(${scrolled * parallaxSpeed}px)`;
      });
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
  });
</script>
{{-- Location component --}}
@include('public.components.location')

@endsection