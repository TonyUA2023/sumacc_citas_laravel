@php
  $navLinks = [
    ['name' => 'Home', 'href' => url('/')],
    ['name' => 'Premium Detailing', 'href' => url('/detailing-services')],
    ['name' => 'Hand Super Wash', 'href' => url('/car-wash')],
    ['name' => 'Premium Products', 'href' => url('/products')],
  ];
@endphp

<header class="fixed w-full z-50 transition-all duration-500" id="main-header">
  <style>
    /* Header Styles */
    #main-header {
      background: rgba(0, 0, 0, 0.95);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    #main-header.scrolled {
      background: rgba(0, 0, 0, 0.98);
      box-shadow: 0 4px 30px rgba(41, 128, 185, 0.1);
    }
    
    /* Logo Text Gradient Animation */
    @keyframes gradient-shift {
      0%, 100% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
    }
    
    .wayra-logo-text {
      background: linear-gradient(135deg, #3b82f6, #60a5fa, #2563eb, #3b82f6);
      background-size: 300% 300%;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      animation: gradient-shift 5s ease infinite;
      position: relative;
    }
    
    /* 3D Effect for Logo */
    .wayra-logo-text::before {
      content: 'WAYRA';
      position: absolute;
      left: 2px;
      top: 2px;
      z-index: -1;
      background: linear-gradient(135deg, #1e40af, #1e3a8a);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    /* Subtitle styling */
    .subtitle-text {
      background: linear-gradient(90deg, #60a5fa, #93c5fd);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: 0.15em;
    }
    
    /* Navigation Link Styles */
    .nav-link {
      position: relative;
      color: #e5e7eb;
      transition: color 0.3s ease;
      font-weight: 500;
    }
    
    .nav-link::before {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, #3b82f6, #ef4444);
      transition: width 0.3s ease;
    }
    
    .nav-link:hover {
      color: #60a5fa;
    }
    
    .nav-link:hover::before,
    .nav-link.active::before {
      width: 100%;
    }
    
    .nav-link.active {
      color: #3b82f6;
    }
    
    /* Premium Button Style */
    .contact-btn {
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }
    
    .contact-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, #ef4444, #dc2626);
      transition: left 0.3s ease;
    }
    
    .contact-btn:hover::before {
      left: 0;
    }
    
    .contact-btn span {
      position: relative;
      z-index: 1;
    }
    
    .contact-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
    }
    
    /* Mobile Menu Styles */
    #mobile-menu {
      background: linear-gradient(135deg, #000000 0%, #0f172a 100%);
      border-right: 1px solid rgba(59, 130, 246, 0.2);
    }
    
    .mobile-nav-link {
      color: #e5e7eb;
      position: relative;
      padding-left: 20px;
      transition: all 0.3s ease;
    }
    
    .mobile-nav-link::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 0;
      background: linear-gradient(180deg, #3b82f6, #ef4444);
      transition: height 0.3s ease;
    }
    
    .mobile-nav-link:hover::before,
    .mobile-nav-link.active::before {
      height: 100%;
    }
    
    .mobile-nav-link:hover {
      color: #60a5fa;
      transform: translateX(10px);
    }
    
    /* Menu Icon Animation */
    .menu-icon {
      transition: all 0.3s ease;
    }
    
    .menu-icon:hover {
      transform: scale(1.1);
    }
    
    /* Logo Image Glow Effect */
    .logo-image {
      filter: drop-shadow(0 0 20px rgba(59, 130, 246, 0.3));
      transition: all 0.3s ease;
    }
    
    .logo-container:hover .logo-image {
      filter: drop-shadow(0 0 30px rgba(59, 130, 246, 0.5));
      transform: scale(1.05);
    }
    
    /* Mobile Menu Overlay */
    .menu-overlay {
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(5px);
    }
  </style>

  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    <!-- Logo Section -->
    <a href="{{ url('/') }}" class="logo-container flex items-center space-x-4 group">
      <div class="relative">
        <div class="absolute inset-0 bg-blue-500 blur-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
        <img src="{{ asset('logo/logopng.png') }}" alt="WAYRA Logo" class="logo-image h-16 md:h-20 w-auto relative z-10" />
      </div>
      <div class="flex flex-col items-start">
        <h1 class="wayra-logo-text text-3xl md:text-4xl font-black uppercase tracking-wider">WAYRA</h1>
        <span class="subtitle-text text-xs md:text-sm font-medium uppercase">Deep Down Detail</span>
      </div>
    </a>

    <!-- Desktop Navigation -->
    <nav class="hidden lg:flex items-center space-x-8">
      @foreach ($navLinks as $link)
        <a href="{{ $link['href'] }}" 
           class="nav-link text-base hover:text-blue-400 transition-colors duration-300 @if(request()->is(trim(parse_url($link['href'], PHP_URL_PATH), '/'))) active @endif">
          {{ $link['name'] }}
        </a>
      @endforeach
    </nav>

    <!-- Contact Button & Mobile Menu -->
    <div class="flex items-center space-x-4">
      <!-- Desktop Contact Button -->
      <a href="{{ url('/car-wash') }}" 
         class="contact-btn hidden md:flex items-center px-6 py-3 text-white font-medium rounded-lg shadow-lg">
        <span>Get Quote</span>
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </a>

      <!-- Mobile Menu Button -->
      <button id="menu-toggle" class="lg:hidden menu-icon text-gray-300 hover:text-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-black rounded-lg p-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu Overlay -->
  <div id="menu-overlay" class="menu-overlay fixed inset-0 z-40 hidden opacity-0 transition-opacity duration-300"></div>

  <!-- Mobile Menu Panel -->
  <div id="mobile-menu" class="fixed top-0 left-0 w-4/5 max-w-sm h-full shadow-2xl z-50 transform -translate-x-full transition-transform duration-500">
    <!-- Mobile Menu Header -->
    <div class="flex items-center justify-between p-6 border-b border-gray-800">
      <div class="flex items-center space-x-3">
        <img src="{{ asset('logo/logopng.png') }}" alt="WAYRA" class="h-12 w-auto" />
        <div>
          <h2 class="wayra-logo-text text-2xl font-bold">WAYRA</h2>
          <span class="subtitle-text text-xs">Deep Down Detail</span>
        </div>
      </div>
      <button id="menu-close" class="text-gray-400 hover:text-red-400 transition-colors duration-300 focus:outline-none p-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Mobile Navigation Links -->
    <nav class="flex flex-col py-8">
      @foreach ($navLinks as $link)
        <a href="{{ $link['href'] }}" 
           class="mobile-nav-link py-4 px-8 text-lg font-medium @if(request()->is(trim(parse_url($link['href'], PHP_URL_PATH), '/'))) active @endif">
          {{ $link['name'] }}
        </a>
      @endforeach
      
      <!-- Mobile Contact Button -->
      <div class="px-8 mt-8">
        <a href="{{ url('/car-wash') }}" 
           class="contact-btn flex items-center justify-center w-full px-6 py-4 text-white font-medium rounded-lg shadow-lg">
          <span>Get Quote</span>
          <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>
    </nav>

    <!-- Mobile Menu Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-gray-800">
      <div class="flex justify-center space-x-4">
        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
          </svg>
        </a>
        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</header>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const header = document.getElementById('main-header');
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuClose = document.getElementById('menu-close');
    const menuOverlay = document.getElementById('menu-overlay');
    const body = document.body;

    // Header scroll effect
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
      const currentScroll = window.pageYOffset;
      
      if (currentScroll > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
      
      lastScroll = currentScroll;
    });

    // Mobile menu functionality
    function openMenu() {
      mobileMenu.classList.remove('-translate-x-full');
      menuOverlay.classList.remove('hidden');
      setTimeout(() => {
        menuOverlay.classList.remove('opacity-0');
      }, 10);
      body.style.overflow = 'hidden';
    }

    function closeMenu() {
      mobileMenu.classList.add('-translate-x-full');
      menuOverlay.classList.add('opacity-0');
      setTimeout(() => {
        menuOverlay.classList.add('hidden');
      }, 500);
      body.style.overflow = '';
    }

    menuToggle.addEventListener('click', openMenu);
    menuClose.addEventListener('click', closeMenu);
    menuOverlay.addEventListener('click', closeMenu);

    // Close menu when clicking on a link
    const mobileLinks = mobileMenu.querySelectorAll('a');
    mobileLinks.forEach(link => {
      link.addEventListener('click', closeMenu);
    });

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