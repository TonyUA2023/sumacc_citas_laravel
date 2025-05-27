<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="description" content="Astro description" />
  <meta name="viewport" content="width=device-width" />

   <!-- Título dinámico -->
  <title>{{ $title ?? 'Wayra' }}</title>

  <meta name="description" content="{{ $metaDescription ?? 'Mobile Detailing' }}" />
  <meta name="keywords" content="{{ $metaKeywords ?? 'mobile detailing, deep down detail, detail, polishing, car wash, Seattle, Bellevue, Wayra' }}" />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="{{ url()->current() }}" />

  <meta property="og:title" content="{{ $title ?? 'Wayra' }}" />
  <meta property="og:description" content="{{ $metaDescription ?? 'Astro description' }}" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:image" content="{{ asset('logo/logoHead1.png') }}" />

  <meta name="twitter:title" content="{{ $title ?? 'Wayra' }}" />
  <meta name="twitter:description" content="{{ $metaDescription ?? 'At Wayra Mobile Detailing, we provide luxury automotive detailing, taking care of every detail of your vehicle with advanced techniques and premium products.' }}" />
  <meta name="twitter:image" content="{{ asset('logo/logoHead1.png') }}" />

    <!-- JSON-LD Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "{{ $title ?? 'Wayra Mobile Detailing' }}",
    "url": "{{ url()->current() }}",
    "potentialAction": {
      "@type": "SearchAction",
      "target": "{{ url('/?s={search_term_string}') }}",
      "query-input": "required name=search_term_string"
    }
  }
  </script>

  <link rel="icon" type="image/svg+xml" href="{{ asset('logo/logoHead1.ico') }}" />
  <title>{{ $title ?? 'Wayra' }}</title>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet"/>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black">

  @include('public.components.header')

  <main class=>
    @yield('content')
  </main>

  @include('public.components.footer')

  <div class="fixed bottom-5 right-5 flex flex-col space-y-3 animate-bounce-custom z-50">
    <!-- Botón de WhatsApp -->
    <a href="https://wa.link/t1ivhk" target="_blank" class="flex items-center justify-center p-3 bg-[#25D366] text-white font-bold text-sm rounded-full hover:bg-green-600 transition">
      <img src="{{ asset('SocialNetsIcon/whatssapp.png') }}" alt="WhatsApp" class="w-11 h-11" />
    </a>

    <!-- Botón de SMS Facebook -->
    <a href="https://www.facebook.com/profile.php?id=61566085425354" class="flex items-center justify-center p-3 bg-[#ffffff] text-white font-bold text-sm rounded-full hover:bg-blue-600 transition">
      <img src="{{ asset('SocialNetsIcon/messenger.png') }}" alt="SMS" class="w-11 h-11" />
    </a>

    <!-- Botón de mensaje SMS -->
    <a href="sms:+1 (425) 350 - 6740?body=I’m interested in getting a mobile detailing service for my vehicle. Could you provide more details on your services and pricing?" class="flex items-center justify-center p-3 bg-[#FF5733] text-white font-bold text-sm rounded-full hover:bg-red-600 transition">
      <img src="{{ asset('SocialNetsIcon/sms.png') }}" alt="SMS" class="w-11 h-11" />
    </a>
  </div>

</body>

<style>
  :root {
    --accent: 136, 58, 234;
    --accent-light: 224, 204, 250;
    --accent-dark: 49, 10, 101;
    --accent-gradient: linear-gradient(
      45deg,
      rgb(var(--accent)),
      rgb(var(--accent-light)) 30%,
      white 60%
    );
  }
  html {
    font-family: system-ui, sans-serif;
    scroll-behavior: smooth;
  }
  code {
    font-family: Menlo, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New, monospace;
  }
</style>
</html>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
  // Inicializa AOS
  AOS.init({
    duration: 600,    // Duración de la animación en ms
    once: true,       // Sólo animar una vez al hacer scroll
  });
</script>