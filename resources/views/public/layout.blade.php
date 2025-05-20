<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="description" content="Astro description" />
  <meta name="viewport" content="width=device-width" />
  <link rel="icon" type="image/svg+xml" href="{{ asset('logo/logoHead1.ico') }}" />
  <title>{{ $title ?? 'Wayra' }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

  @include('public.components.header')

  <main>
    @yield('content')
  </main>

  @include('public.components.footer')

  <div class="fixed bottom-5 right-5 flex flex-col space-y-3 animate-bounce-custom z-50">
    <!-- Botón de WhatsApp -->
    <a href="https://wa.link/ufggf2" target="_blank" class="flex items-center justify-center p-3 bg-[#25D366] text-white font-bold text-sm rounded-full hover:bg-green-600 transition">
      <img src="{{ asset('SocialNetsIcon/whatssapp.png') }}" alt="WhatsApp" class="w-11 h-11" />
    </a>

    <!-- Botón de SMS Facebook -->
    <a href="https://www.facebook.com/profile.php?id=61566085425354" class="flex items-center justify-center p-3 bg-[#ffffff] text-white font-bold text-sm rounded-full hover:bg-blue-600 transition">
      <img src="{{ asset('SocialNetsIcon/messenger.png') }}" alt="SMS" class="w-11 h-11" />
    </a>

    <!-- Botón de mensaje SMS -->
    <a href="sms:+1 (347) 786 - 1830?body=I’m interested in getting a mobile detailing service for my vehicle. Could you provide more details on your services and pricing?" class="flex items-center justify-center p-3 bg-[#FF5733] text-white font-bold text-sm rounded-full hover:bg-red-600 transition">
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