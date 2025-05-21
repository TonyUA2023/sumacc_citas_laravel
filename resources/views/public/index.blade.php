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
        <span class="text-7xl font-extrabold">Welcome TO</span> <br> Mobile Car Detail, Car Detailing
      </h2>
      <h2 class="uppercase text-4xl md:text-5xl font-bold text-gray-300">
        Seattle and Bellevue
      </h2>
      <div class="flex justify-center space-x-6 mt-6">
        <a href="/detailing-services" class="border border-white py-2 px-6 text-white hover:bg-white hover:text-black transition font-semibold text-2xl">Premium Detailing</a>
        <a href="/car-wash" class="border border-white py-2 px-6 text-white hover:bg-white hover:text-black transition font-semibold text-2xl">Hand Super Wash</a>
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
        <a href="/detailing-services" class="border border-white py-2 px-6 text-white hover:bg-white hover:text-black transition">Full Detailing</a>
        <a href="/car-wash" class="border border-white py-2 px-6 text-white hover:bg-white hover:text-black transition">Super Wash</a>
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
<section class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('services/exterior-cleaning/bmw-1.jpg');">
  <div class="bg-blue-900 bg-opacity-70 py-16 px-8 md:px-20 lg:px-40">
    <div class="max-w-5xl mx-auto text-center text-white">
      <h2 class="text-3xl md:text-4xl font-bold mb-6">Treat Your Car Like You Love It.</h2>
      <div class="text-left text-sm md:text-base leading-relaxed">
        <p class="mb-4">
          Looking for a premier all-hand carwash and detail facility in the Seattle area? Look no further than Wayra Deep Down Detail in all Seattle Area and Pacific North! Our expertly trained team of wash technicians will pamper your car with high-quality car care products like Adam's Polishes, Griot's Garage, and Swissvax, which include environmentally friendly wash shampoos, tire dressings, polishes, waxes, interior cleaners, and microfiber towels. In addition, our trained detailers use only the best paint protection film and ceramic coating products on the market, including Xpel, 3M, G-techniq, CeramicPro, and CQuartz, ensuring that your vehicle stays protected for the unexpected.
        </p>
        <p>
          Relax while our experts take care of your vehicle, while you take care of what matters. At Wayra Auto Detail, we offer high quality mobile carwash and detail services in Seattle and throughout the North Pacific. Our team uses advanced technology and premium products to leave your car like new.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- "OUR STORY" SECTION -->
 <h3 class="text-center font-black text-4xl bg-black text-white py-5 ">ABOUT  WAYRA DEEP DOWN DETAIL</h3>
<section class=" sm:flex "> 
  
  <div class="bg-gray-800 py-5 px-4 text-center text-white" style="background-image: url('hero/1.jpg'); background-size: cover">

    <div class="bg-black bg-opacity-50 py-10 px-5">
      <h3 class="text-4xl font-bold mb-6">Our Story</h3>
      <p class="text-lg font-light">
        Wayra Mobile Detailing was born from a family dream fueled by a passion for cars and the perfect detail. Today, we are a reference in high-level mobile detailing services in the region, known for our excellence, trust, and superior results.
      </p>
      <p class="text-lg font-light mt-4">
        We specialize in caring for luxury, sports, and high-value vehicles, offering a personalized experience that enhances the beauty and character of each car. Quality, precision, and passion define us in every visit.
      </p>
    </div>

  </div>

  <!-- "OUR MISSION" SECTION -->
  <div class="bg-black py-5 px-4 text-center text-white" style="background-image: url('hero/2.jpg'); background-size: cover">
    <div class="bg-black bg-opacity-50 py-10 px-5">
      <h3 class="text-4xl font-bold mb-6">Our Mission</h3>
      <p class="text-lg font-light">
        At Wayra Mobile Detailing, we provide luxury automotive detailing, taking care of every detail of your vehicle. Our expert team uses advanced techniques and premium products to ensure flawless results on your car, truck, or SUV.
      </p>
      <p class="text-lg font-light mt-4">
        We offer mobile automotive detailing services at your doorstep in Seattle, Kirkland, Lynnwood, Edmonds, Bellevue, Everett, and nearby cities, providing convenience, quality, and exceptional results.
      </p>
    </div>
  </div>


  <div class="bg-gray-800 py-5 px-4 text-center text-white" style="background-image: url('hero/3.jpg'); background-size: cover">
    <div class="bg-black bg-opacity-50 py-10 px-5">
      <h3 class="text-4xl font-bold mb-6">Our Team</h3>
      <p class="text-lg font-light">
        Our team is made up of highly qualified professionals, passionate about automotive detailing and committed to excellence.
        With experience and precision, we elevate each vehicle to its best. </p>
      <p class="text-lg font-light mt-4">
        We use advanced techniques and premium products for impeccable results.
        We are driven by customer satisfaction and perfection in every service.
        We provide in-home service in Seattle, Bellevue, Kirkland, Lynnwood, and Everett.
        We provide full coverage in King and Snohomish counties and the Pacific Northwest. </p>
    </div>
  </div>

</section>

<section class="max-w-5xl mx-auto flex flex-col md:flex-row items-center bg-gray-900 text-white rounded-lg shadow-lg p-8 my-16">
  <!-- Texto gerente (izquierda) -->
  <div class="text-left md:max-w-xl md:mr-12 order-2 md:order-1">
    <h3 class="text-3xl font-bold mb-2">Williams Merino</h3>
    <p class="font-semibold mb-4">Gerente Administrativo</p>
    <p class="text-gray-300 leading-relaxed">
      Juan Pérez es el Gerente Administrativo de Wayra Deep Down Detail, con más de 15 años de experiencia en gestión y administración empresarial. Su liderazgo y visión estratégica han sido clave para el crecimiento y la consolidación de la empresa. Juan se enfoca en optimizar procesos internos, asegurar la calidad en el servicio y brindar una atención excepcional a nuestros clientes.
    </p>
  </div>

  <!-- Foto gerente (derecha, centrada) -->
  <div class="flex-shrink-0 mb-6 md:mb-0 order-1 md:order-2 flex justify-center w-full md:w-auto">
    <img src="{{ asset('/hero/perfil.jpg') }}" alt="Gerente Administrativo" class="w-40 h-40 object-cover rounded-full border-4 border-blue-600" />
  </div>
</section>



<section class="py-10 bg-white mt-[10px]">

  <h2 class="text-center text-5xl font-bold mb-10">Services</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 lg:px-24">
    @php
    $services = [
    ['title' => 'All-Hand Car Wash', 'imgSrc' => 'PrincServ/1.png'],
    ['title' => 'Exterior Detailing', 'imgSrc' => 'PrincServ/2.png'],
    ['title' => 'Interior Detailing', 'imgSrc' => 'PrincServ/3.png'],
    ['title' => 'Paint Protection Film', 'imgSrc' => 'PrincServ/4.png'],
    ['title' => 'Ceramic Coatings', 'imgSrc' => 'PrincServ/5.png'],
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
  document.addEventListener("DOMContentLoaded", function() {
    const targets = document.querySelectorAll(".animated-section");

    if (targets.length > 0) {
      const observer = new IntersectionObserver(
        function(entries) {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.remove("opacity-0");
              entry.target.classList.add("animate-fade-down");
            }
          });
        }, {
          threshold: 0.1
        }
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