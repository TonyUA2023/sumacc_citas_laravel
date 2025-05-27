@extends('public.layout')

@section('content')

{{-- Hero Section with Image Carousel --}}
<section class="relative w-full h-screen bg-black overflow-hidden" data-aos="fade">
  {{-- Swiper Container --}}
  <div class="swiper hero-swiper absolute inset-0">
    <div class="swiper-wrapper">
      @php
        $heroImages = [
          '/carros/detail3.jpg',
          '/carros/wash1.jpg',
          '/carros/detail.jpg',
          '/carros/wash2.jpg',
          '/carros/detail1.jpg',
          '/carros/wash3.jpg',
        ];
      @endphp
      
      @foreach($heroImages as $image)
        <div class="swiper-slide">
          <div
            class="absolute inset-0 bg-cover bg-center filter brightness-50"
            style="background-image: url('{{ asset($image) }}'); transform: scale(1.05);"
          ></div>
        </div>
      @endforeach
    </div>
  </div>
  
  {{-- Dark Gradient Overlay --}}
  <div class="absolute inset-0 bg-gradient-to-b from-black/95 via-black/75 to-black/95"></div>
  {{-- Solid Black Overlay --}}
  <div class="absolute inset-0 bg-black/50"></div>
  
  {{-- Animated Background Elements --}}
  <div class="absolute inset-0 pointer-events-none">
    <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/30 rounded-full blur-3xl animate-pulse-slow"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-red-500/30 rounded-full blur-3xl animate-pulse-slow animation-delay-2000"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-r from-blue-500/20 to-red-500/20 rounded-full blur-3xl animate-pulse-slow animation-delay-1000"></div>
  </div>
  
  {{-- Swiper Pagination --}}
  <div class="swiper-pagination !bottom-20"></div>
  
  {{-- Navigation Arrows (Desktop) --}}
  <div class="hidden md:block">
    <button class="swiper-button-prev !left-10 !text-white/50 hover:!text-white transition-colors duration-300">
      <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <button class="swiper-button-next !right-10 !text-white/50 hover:!text-white transition-colors duration-300">
      <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </button>
  </div>
  
  {{-- Content --}}
  <div class="relative z-10 h-full flex flex-col items-center justify-center">
    {{-- Logo Animation --}}
    <div class="mb-8" data-aos="zoom-in" data-aos-duration="1500">
      <div class="relative">
        <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-30 animate-pulse-slow"></div>
        <img src="{{ asset('logo/completo.png') }}" alt="WAYRA" class="relative w-32 h-32 md:w-40 md:h-40 animate-float">
      </div>
    </div>
    
    <div class="text-center space-y-6 px-4">
      <h1
        class="uppercase text-4xl sm:text-5xl md:text-7xl font-black tracking-wider drop-shadow-lg"
        data-aos="fade-up" data-aos-delay="200"
      >
        <span class="block text-transparent bg-gradient-to-r from-blue-400 via-blue-300 to-white bg-clip-text">
          WAYRA
        </span>
        <span
          class="text-2xl sm:text-3xl md:text-4xl text-gray-300 font-extrabold tracking-widest mt-2 block drop-shadow-md"
          data-aos="fade-up" data-aos-delay="400"
        >
          Deep Down Detail
        </span>
      </h1>
      
      <div class="h-1 w-32 mx-auto bg-gradient-to-r from-transparent via-red-500 to-transparent" data-aos="scale-x" data-aos-delay="600"></div>
      
      <h2
        class="text-xl sm:text-2xl md:text-3xl text-gray-400 font-semibold drop-shadow-md"
        data-aos="fade-up" data-aos-delay="800"
      >
        Premium Mobile Car Detailing • Seattle & Bellevue
      </h2>
      
      <div class="flex flex-col sm:flex-row justify-center gap-6 mt-12" data-aos="fade-up" data-aos-delay="1000">
        <a href="/detailing-services" class="group relative px-10 py-4 overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-500 transform transition-transform duration-300 group-hover:scale-110"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-500 opacity-0 transform scale-110 transition-all duration-300 group-hover:opacity-100 group-hover:scale-100"></div>
          <span class="relative z-10 text-white font-medium text-lg tracking-wide">Premium Detailing</span>
        </a>
        
        <a href="/car-wash" class="group relative px-10 py-4 overflow-hidden border border-gray-600 hover:border-transparent transition-all duration-300">
          <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-blue-600 opacity-0 transform scale-0 transition-all duration-500 group-hover:opacity-100 group-hover:scale-100"></div>
          <span class="relative z-10 text-gray-300 group-hover:text-white font-medium text-lg tracking-wide transition-colors duration-300">Hand Super Wash</span>
        </a>
      </div>
    </div>
  </div>
  
  {{-- Progress Bar --}}
  <div class="swiper-progress-bar"></div>
  
  {{-- Scroll Indicator --}}
  <div class="absolute bottom-10 md:bottom-10 left-1/2 transform -translate-x-1/2" data-aos="fade-up" data-aos-delay="1200">
    <div class="w-6 h-10 border-2 border-gray-600 rounded-full flex justify-center">
      <div class="w-1 h-3 bg-white rounded-full mt-2 animate-scroll-down"></div>
    </div>
  </div>
</section>



{{-- Customer Reviews Section --}}
<section class="relative bg-black py-24 overflow-hidden">
  {{-- Background Pattern --}}
  <div class="absolute inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
  </div>
  
  <div class="relative max-w-7xl mx-auto px-4">
    <div class="text-center mb-16" data-aos="fade-up">
      <h3 class="text-4xl sm:text-5xl font-black mb-4">
        <span class="text-transparent bg-gradient-to-r from-blue-400 to-blue-300 bg-clip-text">Customer</span>
        <span class="text-white ml-3">Excellence</span>
      </h3>
      <div class="h-1 w-24 mx-auto bg-gradient-to-r from-red-500 to-transparent"></div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      @php
        $reviews = [
          ['name' => 'Alexander Sugar', 'rating' => 5],
          ['name' => 'Neysha Asto', 'rating' => 5],
          ['name' => 'Hanisha Koneru', 'rating' => 5]
        ];
      @endphp
      
      @foreach($reviews as $index => $review)
      <div data-aos="fade-up" data-aos-delay="{{ $index * 200 }}" class="group relative">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-red-600/20 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <div class="relative bg-gradient-to-b from-gray-900 to-gray-950 p-8 rounded-2xl border border-gray-800 hover:border-gray-700 transition-all duration-500">
          {{-- 3D Effect Top Border --}}
          <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-red-500 to-blue-500"></div>
          
          <div class="flex flex-col items-center text-center space-y-4">
            {{-- Avatar with 3D effect --}}
            <div class="relative">
              <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center transform transition-transform duration-300 group-hover:scale-110">
                <span class="text-3xl font-bold text-white">{{ substr($review['name'], 0, 1) }}</span>
              </div>
              <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
              </div>
            </div>
            
            <h4 class="text-xl font-semibold text-white">{{ $review['name'] }}</h4>
            
            <div class="flex gap-1">
              @for($i = 0; $i < $review['rating']; $i++)
                <span class="text-2xl text-yellow-400 transform transition-transform duration-300 hover:scale-125">★</span>
              @endfor
            </div>
            
            <p class="text-gray-400 italic">"Exceptional service and attention to detail"</p>
            
            <a href="https://www.google.com/maps" 
               target="_blank" 
               class="inline-flex items-center text-blue-400 hover:text-red-400 transition-colors duration-300 group/link">
              <span>Read on Google</span>
              <svg class="w-4 h-4 ml-2 transform transition-transform duration-300 group-hover/link:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
              </svg>
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Premium Brands Showcase --}}
<section class="relative bg-gradient-to-b from-black via-gray-950 to-black py-20 overflow-hidden">
  <div class="absolute inset-0 bg-blue-900/5"></div>
  
  <div class="relative" data-aos="fade">
    <h4 class="text-center text-2xl font-light text-gray-500 mb-12 tracking-widest uppercase">Trusted by Premium Brands</h4>
    
    <div class="relative flex overflow-hidden">
      <div class="flex animate-infinite-scroll">
        @php
          $brands = [
            'audi.png', 'bmw.png', 'corvet.png', 'ferrrari.png', 'ford.png',
            'lambo.png', 'maseratti.png', 'mercedes.png', 'tesla.png', 
            'toyota.png', 'volkswagen.png'
          ];
          $allBrands = array_merge($brands, $brands, $brands);
        @endphp
        
        @foreach($allBrands as $logo)
          <div class="flex-shrink-0 mx-8">
            <img
              src="{{ asset('brands/' . $logo) }}"
              alt="{{ pathinfo($logo, PATHINFO_FILENAME) }}"
              class="h-20 md:h-24 object-contain filter brightness-50 hover:brightness-100 transition-all duration-500 transform hover:scale-110"
            />
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

{{-- About Section - Premium Design --}}
<section class="relative bg-black py-24 overflow-hidden">
  <div class="absolute inset-0">
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-blue-900/10 to-transparent"></div>
    <div class="absolute bottom-0 left-0 w-1/2 h-full bg-gradient-to-r from-red-900/10 to-transparent"></div>
  </div>
  
  <div class="relative max-w-7xl mx-auto px-4">
    <div class="text-center mb-20" data-aos="fade-up">
      <h2 class="text-5xl md:text-6xl font-black mb-6">
        <span class="text-transparent bg-gradient-to-r from-red-500 to-blue-500 bg-clip-text">Treat Your Car</span>
        <span class="block text-white mt-2">Like You Love It</span>
      </h2>
      <div class="flex justify-center gap-2">
        <div class="h-2 w-2 bg-red-500 rounded-full"></div>
        <div class="h-2 w-16 bg-gradient-to-r from-red-500 to-blue-500"></div>
        <div class="h-2 w-2 bg-blue-500 rounded-full"></div>
      </div>
    </div>
    
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <div data-aos="fade-right" data-aos-duration="1000">
        <div class="space-y-6 text-gray-300">
          <p class="text-lg leading-relaxed">
Looking for a premier all-hand carwash and detail facility in the Seattle area? Look no further than Wayra Deep Down Detail in all Seattle Area and Pacific North! Our expertly trained team of wash technicians will pamper your car with high-quality car care products like Adam's Polishes, Griot's Garage, and Swissvax, which include environmentally friendly wash shampoos, tire dressings, polishes, waxes, interior cleaners, and microfiber towels. In addition, our trained detailers use only the best paint protection film and ceramic coating products on the market, including Xpel, 3M, G-techniq, CeramicPro, and CQuartz, ensuring that your vehicle stays protected for the unexpected.          </p>
          
          <div class="flex items-start space-x-4">
            <div class="w-1 h-20 bg-gradient-to-b from-red-500 to-transparent flex-shrink-0"></div>
            <p class="text-lg leading-relaxed">
Relax while our experts take care of your vehicle, while you take care of what matters. At Wayra Auto Detail, we offer high quality mobile carwash and detail services in Seattle and throughout the North Pacific. Our team uses advanced technology and premium products to leave your car like new.

            </p>
          </div>
          
          {{-- Feature List --}}
          <div class="grid grid-cols-2 gap-4 mt-8">
            <div class="flex items-center space-x-3">
              <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
              <span class="text-gray-400">Eco-Friendly Products</span>
            </div>
            <div class="flex items-center space-x-3">
              <div class="w-2 h-2 bg-red-500 rounded-full"></div>
              <span class="text-gray-400">Certified Technicians</span>
            </div>
            <div class="flex items-center space-x-3">
              <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
              <span class="text-gray-400">Mobile Service</span>
            </div>
            <div class="flex items-center space-x-3">
              <div class="w-2 h-2 bg-red-500 rounded-full"></div>
              <span class="text-gray-400">Premium Protection</span>
            </div>
          </div>
        </div>
      </div>
      
      <div data-aos="fade-left" data-aos-duration="1000" class="relative">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-red-500/20 blur-3xl"></div>
        <img 
          src="{{ asset('/carros/detail2.jpg') }}" 
          alt="Premium Car Detail" 
          class="relative rounded-2xl shadow-2xl w-full"
        />
      </div>
    </div>
  </div>
</section>

{{-- Company Story Sections - Elegant Design --}}
<section class="bg-black">
  <div class="text-center py-16" data-aos="fade-up">
    <h3 class="text-4xl md:text-5xl font-black">
      <span class="text-transparent bg-gradient-to-r from-blue-400 via-white to-red-400 bg-clip-text">
        ABOUT WAYRA DEEP DOWN DETAIL
      </span>
    </h3>
  </div>

  {{-- Our Story --}}
  <div class="relative">
    <div class="flex flex-col lg:flex-row min-h-[600px]">
      <div class="w-full lg:w-1/2 relative overflow-hidden" data-aos="fade-right">
        <img src="/hero/1.jpg" alt="Our Story" class="absolute inset-0 w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent"></div>
      </div>
      
      <div class="w-full lg:w-1/2 bg-gradient-to-br from-gray-950 to-black flex items-center" data-aos="fade-left">
        <div class="p-12 lg:p-20">
          <h3 class="text-4xl font-bold mb-8">
            <span class="text-blue-400">Our</span> <span class="text-white">Story</span>
          </h3>
          
          <div class="space-y-6">
            <p class="text-gray-300 text-lg leading-relaxed">
              Wayra Mobile Detailing was born from a family dream fueled by a passion for cars and the perfect detail. Today, we are a reference in high-level mobile detailing services in the region.
            </p>
            
            <div class="flex items-center space-x-4">
              <div class="w-12 h-0.5 bg-red-500"></div>
              <span class="text-red-400 font-medium">Excellence Since Day One</span>
            </div>
            
            <p class="text-gray-400 text-lg leading-relaxed">
              We specialize in luxury, sports, and high-value vehicles, offering a personalized experience that enhances the beauty and character of each car.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Our Mission --}}
  <div class="relative">
    <div class="flex flex-col lg:flex-row min-h-[600px]">
      <div class="w-full lg:w-1/2 bg-gradient-to-bl from-gray-950 to-black flex items-center order-2 lg:order-1" data-aos="fade-right">
        <div class="p-12 lg:p-20">
          <h3 class="text-4xl font-bold mb-8">
            <span class="text-red-400">Our</span> <span class="text-white">Mission</span>
          </h3>
          
          <div class="space-y-6">
            <p class="text-gray-300 text-lg leading-relaxed">
              At Wayra Mobile Detailing, we provide luxury automotive detailing, taking care of every detail of your vehicle with advanced techniques and premium products.
            </p>
            
            <div class="grid grid-cols-2 gap-6 my-8">
              <div class="text-center">
                <div class="text-3xl font-bold text-blue-400">100+</div>
                <div class="text-gray-500">Happy Clients</div>
              </div>
              <div class="text-center">
                <div class="text-3xl font-bold text-red-400">100%</div>
                <div class="text-gray-500">Satisfaction</div>
              </div>
            </div>
            
            <p class="text-gray-400 text-lg leading-relaxed">
We offer mobile automotive detailing services at your doorstep in Seattle, Kirkland, Lynnwood, Edmonds, Bellevue, Everett. We provide full coverage in King and Snohomish counties and the Pacific Northwest, providing convenience, quality, and exceptional results.

            </p>
          </div>
        </div>
      </div>
      
      <div class="w-full lg:w-1/2 relative overflow-hidden order-1 lg:order-2" data-aos="fade-left">
        <img src="/hero/2.jpg" alt="Our Mission" class="absolute inset-0 w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-l from-black/80 to-transparent"></div>
      </div>
    </div>
  </div>

  {{-- Our Team --}}
  <div class="relative">
    <div class="flex flex-col lg:flex-row min-h-[700px]">
      <div class="w-full lg:w-1/2 relative overflow-hidden" data-aos="fade-right">
        <img src="/hero/3.jpg" alt="Our Team" class="absolute inset-0 w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent"></div>
      </div>
      
      <div class="w-full lg:w-1/2 bg-gradient-to-br from-gray-950 to-black flex items-center" data-aos="fade-left">
        <div class="p-12 lg:p-20">
          <h3 class="text-4xl font-bold mb-8">
            <span class="text-blue-400">Our</span> <span class="text-white">Team</span>
          </h3>
          
          <div class="space-y-6">
            <p class="text-gray-300 text-lg leading-relaxed">
Our team is made up of highly qualified professionals, passionate about automotive detailing and committed to excellence. With experience and precision, we elevate each vehicle to its best.

            </p>
            
            {{-- Team Features --}}
            <div class="space-y-4">
              <div class="flex items-center space-x-4">
                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                <span class="text-gray-400">Advanced Training & Certification</span>
              </div>
              <div class="flex items-center space-x-4">
                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                <span class="text-gray-400">Premium Tools & Products</span>
              </div>
              <div class="flex items-center space-x-4">
                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                <span class="text-gray-400">Customer-First Approach</span>
              </div>
            </div>
            
            <p class="text-gray-400 text-lg leading-relaxed mt-6">
We use advanced techniques and premium products for impeccable results. We are driven by customer satisfaction and perfection in every service. We provide in-home service in Throughout the North Pacific.

            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Services Grid - Premium Design --}}
<section class="relative bg-gradient-to-b from-black via-gray-950 to-black py-24 overflow-hidden">
  {{-- Background Elements --}}
  <div class="absolute inset-0">
    <div class="absolute top-1/2 left-0 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-red-500/5 rounded-full blur-3xl"></div>
  </div>
  
  <div class="relative max-w-7xl mx-auto px-4">
    <div class="text-center mb-20" data-aos="fade-up">
      <h2 class="text-5xl md:text-6xl font-black mb-6">
        <span class="text-transparent bg-gradient-to-r from-blue-400 to-red-400 bg-clip-text">Our Services</span>
      </h2>
      <p class="text-gray-400 text-xl">Premium Care for Your Premium Vehicle</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      @php
      $services = [
        ['title' => 'All-Hand Car Wash', 'imgSrc' => 'PrincServ/1.png', 'url' => '/car-wash', 'color' => 'blue'],
        ['title' => 'Exterior Detailing', 'imgSrc' => 'PrincServ/2.png', 'url' => '/detailing-services', 'color' => 'red'],
        ['title' => 'Interior Detailing', 'imgSrc' => 'PrincServ/3.png', 'url' => '/detailing-services', 'color' => 'blue'],
        ['title' => 'Paint Protection Film', 'imgSrc' => 'PrincServ/4.png', 'url' => '/car-wash', 'color' => 'red'],
        ['title' => 'Ceramic Coatings', 'imgSrc' => 'PrincServ/5.png', 'url' => '/car-wash', 'color' => 'blue'],
        ['title' => 'Paint Touchup', 'imgSrc' => 'PrincServ/8.png', 'url' => '/detailing-services', 'color' => 'red'],
        ['title' => 'Headlight Repair', 'imgSrc' => 'PrincServ/10.png', 'url' => '/detailing-services', 'color' => 'blue'],
        ['title' => 'Glass & Tint', 'imgSrc' => 'PrincServ/12.png', 'url' => '/detailing-services', 'color' => 'red'],
      ];
      @endphp

      @foreach ($services as $index => $service)
      <a href="{{ $service['url'] ?? '#' }}" 
         class="group relative overflow-hidden rounded-xl bg-gray-900 transform transition-all duration-500 hover:scale-105" 
         data-aos="fade-up" 
         data-aos-delay="{{ $index * 100 }}">
        
        <div class="relative h-72 overflow-hidden">
          <img src="{{ asset($service['imgSrc']) }}" 
               alt="{{ $service['title'] }}" 
               class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-125" />
          
          {{-- Premium Gradient Overlay --}}
          <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
          
          {{-- Color Accent on Hover --}}
          <div class="absolute inset-0 bg-gradient-to-br from-{{ $service['color'] }}-600/0 to-{{ $service['color'] }}-600/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
          
          {{-- Service Info --}}
          <div class="absolute inset-x-0 bottom-0 p-6">
            <h3 class="text-white text-xl font-bold transform transition-transform duration-500 group-hover:translate-y-[-8px]">
              {{ $service['title'] }}
            </h3>
            
            <div class="flex items-center mt-2 opacity-0 transform translate-y-4 transition-all duration-500 group-hover:opacity-100 group-hover:translate-y-0">
              <span class="text-{{ $service['color'] }}-400 text-sm font-medium">Learn More</span>
              <svg class="w-4 h-4 ml-2 text-{{ $service['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </div>
          </div>
          
          {{-- 3D Border Effect --}}
          <div class="absolute inset-0 border-2 border-{{ $service['color'] }}-500/0 group-hover:border-{{ $service['color'] }}-500/50 transition-all duration-500 rounded-xl"></div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>

@include('public.components.location')

{{-- Founder Section - Premium Design --}}
<section class="relative bg-black py-24 overflow-hidden">
  <div class="absolute inset-0 bg-gradient-to-b from-gray-950 to-black"></div>
  
  <div class="relative max-w-6xl mx-auto px-4">
    <div class="bg-gradient-to-br from-gray-900/50 to-gray-950/50 backdrop-blur-sm rounded-3xl border border-gray-800 overflow-hidden" data-aos="fade-up">
      {{-- Top Accent Bar --}}
      <div class="h-2 bg-gradient-to-r from-blue-500 via-red-500 to-blue-500"></div>
      
      <div class="flex flex-col lg:flex-row">
        {{-- Photo Section --}}
        <div class="w-full lg:w-1/3 p-12 flex items-center justify-center" data-aos="fade-right" data-aos-delay="200">
          <div class="relative">
            {{-- 3D Frame Effect --}}
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-red-500 rounded-full blur-2xl opacity-20 animate-pulse-slow"></div>
            <div class="absolute -inset-4 bg-gradient-to-br from-blue-500/20 to-red-500/20 rounded-full"></div>
            
            <img
              src="{{ asset('hero/perfil.jpg') }}"
              alt="Williams Merino"
              class="relative w-64 h-64 object-cover rounded-full border-4 border-gray-700"
            />
            
            {{-- CEO Badge --}}
            <div class="absolute bottom-4 right-4 bg-gradient-to-r from-blue-600 to-red-600 text-white px-4 py-2 rounded-full text-sm font-medium">
              CEO & Founder
            </div>
          </div>
        </div>

        {{-- Content Section --}}
        <div class="w-full lg:w-2/3 p-12" data-aos="fade-left" data-aos-delay="400">
          <h3 class="text-4xl font-bold mb-2">
            <span class="text-transparent bg-gradient-to-r from-blue-400 to-red-400 bg-clip-text">Williams Merino</span>
          </h3>
          <p class="text-xl text-gray-400 mb-8">Visionary Behind Wayra Mobile Detailing</p>

          {{-- Expandable Content --}}
          <div id="founderContent" class="space-y-6 max-h-0 overflow-hidden transition-all duration-700">
            <p class="text-gray-300 text-lg leading-relaxed">
              Williams Merino graduated from the Private University of the North with studies in Civil Engineering and Finance. His technical expertise and passion for automotive excellence led him to create Wayra Mobile Detailing.
            </p>

            <blockquote class="relative pl-8 py-4 my-8">
              <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-red-500 to-blue-500"></div>
              <p class="text-xl text-gray-200 italic">
                "If we provide our customers with the best service for all their automotive needs, they will be our customers for life."
              </p>
              <cite class="text-gray-400 text-sm mt-2 block">- Williams Merino</cite>
            </blockquote>

            <p class="text-gray-300 text-lg leading-relaxed">
              With this vision, he has established Wayra as a benchmark in the Pacific Northwest, where excellence, trust, and commitment to every detail are the foundation of success.
            </p>
          </div>

          {{-- Elegant Toggle Button --}}
          <button
            id="expandBtn"
            class="mt-8 group flex items-center space-x-3 text-blue-400 hover:text-red-400 transition-colors duration-300"
          >
            <span class="font-medium">Read Full Story</span>
            <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>



<style>
  /* Swiper Hero Styles */
  .hero-swiper {
    width: 100%;
    height: 100%;
  }
  
  .hero-swiper .swiper-slide {
    overflow: hidden;
  }
  
  .hero-swiper .swiper-slide > div {
    transition: transform 10s ease-out;
  }
  
  .hero-swiper .swiper-slide-active > div {
    transform: scale(1.1);
  }
  
  /* Swiper Custom Pagination */
  .hero-swiper .swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background: rgba(255, 255, 255, 0.3);
    opacity: 1;
    transition: all 0.3s ease;
  }
  
  .hero-swiper .swiper-pagination-bullet-active {
    width: 40px;
    height: 12px;
    border-radius: 6px;
    background: linear-gradient(90deg, #3b82f6, #ef4444);
  }
  
  /* Custom Navigation Buttons */
  .swiper-button-prev,
  .swiper-button-next {
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
    width: 60px !important;
    height: 60px !important;
    border-radius: 50%;
    display: flex !important;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
  }
  
  .swiper-button-prev:hover,
  .swiper-button-next:hover {
    background: rgba(59, 130, 246, 0.3);
    transform: scale(1.1);
  }
  
  .swiper-button-prev::after,
  .swiper-button-next::after {
    display: none;
  }
  
  /* Swiper Progress Bar */
  .swiper-progress-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: rgba(255, 255, 255, 0.1);
    z-index: 10;
  }
  
  .swiper-progress-bar::after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0;
    background: linear-gradient(90deg, #3b82f6, #ef4444);
    animation: progress 5s linear infinite;
  }
  
  @keyframes progress {
    0% { width: 0; }
    100% { width: 100%; }
  }
  @media (max-width: 768px) {
    .hero-swiper .swiper-pagination {
      bottom: 80px !important;
    }
    
    /* Better image positioning on mobile */
    .hero-swiper .swiper-slide > div {
      background-position: 70% center;
    }
  }
  
  /* Responsive Font Sizes */
  @media (max-width: 640px) {
    .hero-content h1 {
      font-size: 3rem;
    }
    
    .hero-content h2 {
      font-size: 1.5rem;
    }
  }
  /* Premium Dark Theme Styles */
  body {
    overflow-x: hidden;
    background-color: #000;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  }
  
  /* Premium Animations */
  @keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
  }
  
  @keyframes pulse-slow {
    0%, 100% { opacity: 0.5; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.1); }
  }
  
  @keyframes scroll-down {
    0% { transform: translateY(0); opacity: 0; }
    40% { opacity: 1; }
    80% { transform: translateY(8px); opacity: 0; }
    100% { transform: translateY(8px); opacity: 0; }
  }
  
  @keyframes infinite-scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-33.33%); }
  }
  
  @keyframes scale-x {
    from { transform: scaleX(0); }
    to { transform: scaleX(1); }
  }
  
  /* Animation Classes */
  .animate-float {
    animation: float 6s ease-in-out infinite;
  }
  
  .animate-pulse-slow {
    animation: pulse-slow 4s ease-in-out infinite;
  }
  
  .animate-scroll-down {
    animation: scroll-down 2s ease-in-out infinite;
  }
  
  .animate-infinite-scroll {
    animation: infinite-scroll 40s linear infinite;
  }
  
  /* Animation Delays */
  .animation-delay-1000 {
    animation-delay: 1000ms;
  }
  
  .animation-delay-2000 {
    animation-delay: 2000ms;
  }
  
  /* Premium Scrollbar */
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
  
  /* Gradient Text Support */
  .bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
  }
  
  /* Premium Focus States */
  a:focus-visible,
  button:focus-visible {
    outline: 2px solid #3b82f6;
    outline-offset: 4px;
  }
  
  /* Smooth Section Transitions */
  section {
    position: relative;
    overflow: hidden;
  }
  
  /* AOS Custom Animations */
  [data-aos="scale-x"] {
    transform: scaleX(0);
    transition-property: transform;
  }
  
  [data-aos="scale-x"].aos-animate {
    transform: scaleX(1);
  }
  
  /* Premium Hover Effects */
  .group:hover .group-hover\:scale-125 {
    transform: scale(1.25);
  }
  
  /* Backdrop Filters for Modern Browsers */
  @supports (backdrop-filter: blur(12px)) {
    .backdrop-blur-sm {
      backdrop-filter: blur(12px);
    }
  }
</style>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Initialize AOS
    AOS.init({
      duration: 1000,
      once: true,
      offset: 100,
      easing: 'ease-out-cubic'
    });
    
    // Initialize Hero Swiper
    const heroSwiper = new Swiper('.hero-swiper', {
      loop: true,
      effect: 'fade',
      fadeEffect: {
        crossFade: true
      },
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true
      },
      speed: 1500,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      on: {
        init: function() {
          // Apply Ken Burns effect to first slide on init
          const firstSlide = this.slides[0];
          if (firstSlide) {
            const bgElement = firstSlide.querySelector('div');
            if (bgElement) {
              setTimeout(() => {
                bgElement.style.transform = 'scale(1.1)';
              }, 100);
            }
          }
        },
        slideChange: function() {
          // Reset all slides transform
          this.slides.forEach(slide => {
            const bgElement = slide.querySelector('div');
            if (bgElement && !slide.classList.contains('swiper-slide-active')) {
              bgElement.style.transform = 'scale(1.05)';
            }
          });
          
          // Add Ken Burns effect to active slide
          const activeSlide = this.slides[this.activeIndex];
          const bgElement = activeSlide.querySelector('div');
          if (bgElement) {
            setTimeout(() => {
              bgElement.style.transform = 'scale(1.1)';
            }, 100);
          }
        }
      }
    });
    
    // Founder section expand/collapse with smooth animation
    const expandBtn = document.getElementById("expandBtn");
    const founderContent = document.getElementById("founderContent");
    let isExpanded = false;

  expandBtn.addEventListener("click", function () {
    isExpanded = !isExpanded;

    if (isExpanded) {
      founderContent.style.maxHeight = founderContent.scrollHeight + "px";
      expandBtn.querySelector("span").textContent = "Show Less";
      expandBtn.querySelector("svg").style.transform = "rotate(90deg)";
    } else {
      founderContent.style.maxHeight = "0";
      expandBtn.querySelector("span").textContent = "Read Full Story";
      expandBtn.querySelector("svg").style.transform = "rotate(0deg)";
    }
  });
      
    // Smooth scroll behavior
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
    
    // Parallax effect on scroll
    window.addEventListener('scroll', () => {
      const scrolled = window.pageYOffset;
      const parallaxElements = document.querySelectorAll('.parallax');
      
      parallaxElements.forEach(el => {
        const speed = el.dataset.speed || 0.5;
        el.style.transform = `translateY(${scrolled * speed}px)`;
      });
    });
  });
</script>

@endsection