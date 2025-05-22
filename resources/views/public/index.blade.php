@extends('public.layout')

@section('content')

<section class="relative w-full h-screen bg-cover bg-center flex items-center justify-center">
  <video autoplay muted loop class="absolute top-0 left-0 w-full h-full object-cover">
    <source src="{{ asset('vid/vid.mp4') }}" type="video/mp4" />
    Tu navegador no soporta video.
  </video>
  <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50"></div> <div class="relative z-10 text-center space-y-4 px-4">
    <h1 class="uppercase text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-wider text-white">
      <span class="text-5xl sm:text-6xl md:text-7xl font-extrabold block">Welcome TO</span>
      Mobile Car Detail, Car Detailing
    </h1>
    <h2 class="uppercase text-2xl sm:text-3xl md:text-5xl font-bold text-gray-300">
      Seattle and Bellevue
    </h2>
    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6 mt-6">
      <a href="/detailing-services" class="border border-white py-2 px-4 sm:px-6 text-white hover:bg-white hover:text-black transition font-semibold text-lg sm:text-xl md:text-2xl rounded">
        Premium Detailing
      </a>
      <a href="/car-wash" class="border border-white py-2 px-4 sm:px-6 text-white hover:bg-white hover:text-black transition font-semibold text-lg sm:text-xl md:text-2xl rounded">
        Hand Super Wash
      </a>
    </div>
  </div>
</section>

<section class="bg-gray-900 py-8 sm:py-12 px-4">
  <div class="max-w-5xl mx-auto">
    <h3 class="text-2xl sm:text-3xl font-bold text-white text-center mb-6 sm:mb-8">Customer Feedback</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      {{-- Repite este bloque para cada reseña --}}
      <div class="bg-gray-800 p-4 sm:p-6 rounded-lg text-center">
        <p class="text-white font-semibold text-lg sm:text-xl">Alexander Sugar</p>
        <p class="text-yellow-500 text-xl sm:text-2xl">★★★★★</p>
        <a href="https://www.google.com/maps/search/?api=1&query=google+place+id+YOUR_PLACE_ID_HERE" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 underline text-sm sm:text-base">Read on Google Maps →</a>
      </div>
      <div class="bg-gray-800 p-4 sm:p-6 rounded-lg text-center">
        <p class="text-white font-semibold text-lg sm:text-xl">Neysha Asto</p>
        <p class="text-yellow-500 text-xl sm:text-2xl">★★★★★</p>
        <a href="https://www.google.com/maps/search/?api=1&query=google+place+id+YOUR_PLACE_ID_HERE" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 underline text-sm sm:text-base">Read on Google Maps →</a>
      </div>
      <div class="bg-gray-800 p-4 sm:p-6 rounded-lg text-center">
        <p class="text-white font-semibold text-lg sm:text-xl">Hanisha Koneru</p>
        <p class="text-yellow-500 text-xl sm:text-2xl">★★★★★</p>
        <a href="https://www.google.com/maps/search/?api=1&query=google+place+id+YOUR_PLACE_ID_HERE" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 underline text-sm sm:text-base">Read on Google Maps →</a>
      </div>
    </div>
  </div>
</section>

<section class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('services/exterior-cleaning/bmw-1.jpg') }}');">
  <div class="bg-blue-900 bg-opacity-75 py-12 sm:py-16 px-4 sm:px-8 md:px-20 lg:px-40">
    <div class="max-w-5xl mx-auto text-center text-white">
      <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6">Treat Your Car Like You Love It.</h2>
      <div class="text-left text-sm sm:text-base leading-relaxed space-y-4">
        <p>
          Looking for a premier all-hand carwash and detail facility in the Seattle area? Look no further than Wayra Deep Down Detail in all Seattle Area and Pacific North! Our expertly trained team of wash technicians will pamper your car with high-quality car care products like Adam's Polishes, Griot's Garage, and Swissvax, which include environmentally friendly wash shampoos, tire dressings, polishes, waxes, interior cleaners, and microfiber towels. In addition, our trained detailers use only the best paint protection film and ceramic coating products on the market, including Xpel, 3M, G-techniq, CeramicPro, and CQuartz, ensuring that your vehicle stays protected for the unexpected.
        </p>
        <p>
          Relax while our experts take care of your vehicle, while you take care of what matters. At Wayra Auto Detail, we offer high quality mobile carwash and detail services in Seattle and throughout the North Pacific. Our team uses advanced technology and premium products to leave your car like new.
        </p>
      </div>
    </div>
  </div>
</section>

<h3 class="text-center font-black text-2xl sm:text-3xl md:text-4xl bg-black text-white py-4 sm:py-5">ABOUT WAYRA DEEP DOWN DETAIL</h3>

<section class="sm:flex flex-wrap">
  <div class="w-full sm:w-1/2 lg:w-1/3 bg-gray-800 py-8 sm:py-10 px-4 text-center text-white bg-cover bg-center" style="background-image: url('{{ asset('hero/1.jpg') }}');">
    <div class="bg-black bg-opacity-70 py-8 sm:py-10 px-5 h-full flex flex-col justify-center rounded">
      <h3 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6">Our Story</h3>
      <p class="text-base sm:text-lg font-light mb-4">
        Wayra Mobile Detailing was born from a family dream fueled by a passion for cars and the perfect detail. Today, we are a reference in high-level mobile detailing services in the region, known for our excellence, trust, and superior results.
      </p>
      <p class="text-base sm:text-lg font-light">
        We specialize in caring for luxury, sports, and high-value vehicles, offering a personalized experience that enhances the beauty and character of each car. Quality, precision, and passion define us in every visit.
      </p>
    </div>
  </div>

  <div class="w-full sm:w-1/2 lg:w-1/3 bg-black py-8 sm:py-10 px-4 text-center text-white bg-cover bg-center" style="background-image: url('{{ asset('hero/2.jpg') }}');">
    <div class="bg-black bg-opacity-70 py-8 sm:py-10 px-5 h-full flex flex-col justify-center rounded">
      <h3 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6">Our Mission</h3>
      <p class="text-base sm:text-lg font-light mb-4">
        At Wayra Mobile Detailing, we provide luxury automotive detailing, taking care of every detail of your vehicle. Our expert team uses advanced techniques and premium products to ensure flawless results on your car, truck, or SUV.
      </p>
      <p class="text-base sm:text-lg font-light">
        We offer mobile automotive detailing services at your doorstep in Seattle, Kirkland, Lynnwood, Edmonds, Bellevue, Everett, and nearby cities, providing convenience, quality, and exceptional results.
      </p>
    </div>
  </div>

  <div class="w-full sm:w-full lg:w-1/3 bg-gray-800 py-8 sm:py-10 px-4 text-center text-white bg-cover bg-center" style="background-image: url('{{ asset('hero/3.jpg') }}');">
    <div class="bg-black bg-opacity-70 py-8 sm:py-10 px-5 h-full flex flex-col justify-center rounded">
      <h3 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6">Our Team</h3>
      <p class="text-base sm:text-lg font-light mb-4">
        Our team is made up of highly qualified professionals, passionate about automotive detailing and committed to excellence. With experience and precision, we elevate each vehicle to its best.
      </p>
      <p class="text-base sm:text-lg font-light">
        We use advanced techniques and premium products for impeccable results. We are driven by customer satisfaction and perfection in every service. We provide in-home service in Seattle, Bellevue, Kirkland, Lynnwood, and Everett. We provide full coverage in King and Snohomish counties and the Pacific Northwest.
      </p>
    </div>
  </div>
</section>

<section class="py-10 sm:py-12 bg-white mt-[10px]">
  <h2 class="text-center text-3xl sm:text-4xl md:text-5xl font-bold mb-8 sm:mb-10 px-4">Our Services</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 sm:px-8 lg:px-24">
    @php
    $services = [
      ['title' => 'All-Hand Car Wash', 'imgSrc' => 'PrincServ/1.png', 'url' => '/car-wash'],
      ['title' => 'Exterior Detailing', 'imgSrc' => 'PrincServ/2.png', 'url' => '/detailing-services#exterior'],
      ['title' => 'Interior Detailing', 'imgSrc' => 'PrincServ/3.png', 'url' => '/detailing-services#interior'],
      ['title' => 'Paint Protection Film', 'imgSrc' => 'PrincServ/4.png', 'url' => '/paint-protection-film'],
      ['title' => 'Ceramic Coatings', 'imgSrc' => 'PrincServ/5.png', 'url' => '/ceramic-coatings'],
      ['title' => 'Paint Touchup', 'imgSrc' => 'PrincServ/8.png', 'url' => '/paint-touchup'],
      ['title' => 'Headlight Repair', 'imgSrc' => 'PrincServ/10.png', 'url' => '/headlight-repair'],
      ['title' => 'Glass & Tint', 'imgSrc' => 'PrincServ/12.png', 'url' => '/glass-tinting'],
    ];
    @endphp

    @foreach ($services as $service)
    <a href="{{ $service['url'] ?? '#' }}" class="group relative overflow-hidden rounded-lg shadow-lg block transform hover:scale-105 transition-transform duration-300">
      <img src="{{ asset($service['imgSrc']) }}" alt="{{ $service['title'] }}" class="w-full h-56 sm:h-64 object-cover transition-transform duration-500 group-hover:scale-110" />
      <div class="absolute inset-0 bg-black opacity-40 group-hover:opacity-50 transition-opacity duration-300"></div>
      <h3 class="absolute inset-0 flex items-center justify-center text-white text-lg sm:text-xl font-bold text-center p-2 opacity-90 group-hover:opacity-100 transition-opacity duration-300">
        {{ $service['title'] }}
      </h3>
    </a>
    @endforeach
  </div>
</section>

@include('public.components.location')

@endsection

@push('styles')
<style>
  /* Los estilos .btn, .btn--1 etc., se mantienen si los necesitas para animaciones específicas. */
  /* Si los botones del héroe deben usar esta animación, necesitarías añadirles las clases .btn y .btn--1 */
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

  /* Clases de opacidad de fondo por si necesitas anular o asegurar la prioridad sobre otros estilos */
  .bg-black.bg-opacity-50 {
      background-color: rgba(0,0,0,0.5) !important;
  }
   .bg-black.bg-opacity-70 {
      background-color: rgba(0,0,0,0.7) !important;
  }
  .bg-blue-900.bg-opacity-75 {
      background-color: rgba(30, 58, 138, 0.75) !important; /* Ajusta el color exacto de tu blue-900 si es diferente */
  }

</style>
@endpush

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const targets = document.querySelectorAll(".animated-section"); // Asegúrate de tener elementos con la clase 'animated-section'

    if (targets.length > 0) {
      const observer = new IntersectionObserver(
        function(entries, obs) { // obs es el propio observer
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.remove("opacity-0");
              // Asegúrate de que 'animate-fade-down' esté definido en tu config de Tailwind o CSS global
              // Ejemplo de animación Tailwind (requiere configuración en tailwind.config.js):
              // entry.target.classList.add("animate-fadeInDown"); // animate-fadeInDown es un ejemplo
              entry.target.classList.add("animate-fade-down"); // Usando tu clase original

              // Opcional: Dejar de observar el elemento una vez que la animación ha ocurrido
              // obs.unobserve(entry.target);
            }
          });
        }, {
          threshold: 0.1 // Porcentaje del elemento que debe estar visible para disparar la animación
        }
      );

      targets.forEach((target) => {
        target.classList.add("opacity-0"); // Inicia los elementos como invisibles
        observer.observe(target);
      });
    } else {
      // console.log("No se encontraron elementos con la clase 'animated-section' en esta página.");
    }
  });
</script>
@endpush