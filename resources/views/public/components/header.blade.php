@php
  $navLinks = [
    ['name' => 'Home', 'href' => url('/')],
    ['name' => 'Premium Detailing', 'href' => url('/detailing-services')],
    ['name' => 'Hand Super Wash', 'href' => url('/car-wash')],
    ['name' => 'Premium Products', 'href' => url('/products')],
  ];
@endphp

<header class="bg-white text-black shadow-md fixed w-full z-50">
  <div class="container mx-auto px-4 py-3 flex justify-between items-center">
    <!-- Logo -->
    <div class="flex items-center space-x-3">
      <img src="{{ asset('logo/logopng.png') }}" alt="Logo de Wayra" class="h-20 w-auto" />
      <a href="{{ url('/') }}" class="text-2xl font-bold text-center">Wayra <br /> <span class="font-normal text-xl">MOBILE DETAILING</span></a>
    </div>

    <!-- Navigation Links -->
    <nav class="hidden md:flex justify-center space-x-6">
      @foreach ($navLinks as $link)
        <a href="{{ $link['href'] }}" class="text-lg nav-link relative hover:text-gray-400 @if(request()->is(trim($link['href'], '/'))) active @endif">{{ $link['name'] }}</a>
      @endforeach
    </nav>

    <!-- Contact Button -->
    <div class="hidden md:flex items-center justify-end ">
      <a href="{{ url('/contactform') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Contact</a>
    </div>

    <!-- Mobile Menu Button -->
    <button id="menu-toggle" class="md:hidden focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
      </svg>
    </button>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden fixed top-0 left-0 w-3/4 h-full bg-gray-900 text-white shadow-md z-20 transform -translate-x-full transition-transform duration-300">
    <div class="flex justify-end p-4">
      <button id="menu-close" class="focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <nav class="flex flex-col space-y-6 mt-10 px-6">
      @foreach ($navLinks as $link)
        <a href="{{ $link['href'] }}" class="hover:text-gray-400">{{ $link['name'] }}</a>
      @endforeach
      <a href="{{ url('/contactform') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Contact</a>
    </nav>
  </div>
</header>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
      if (link.getAttribute('href') === currentPath) {
        link.classList.add('active');
      }
    });

    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuClose = document.getElementById('menu-close');

    if (menuToggle && mobileMenu && menuClose) {
      menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        mobileMenu.classList.toggle('-translate-x-full');
        mobileMenu.classList.toggle('translate-x-0');
      });

      menuClose.addEventListener('click', () => {
        mobileMenu.classList.add('-translate-x-full');
        setTimeout(() => {
          mobileMenu.classList.add('hidden');
        }, 300);
      });
    }
  });
</script>