<footer class="bg-gray-900 text-white py-10">
  <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">
    <!-- Sección de información de la Empresa -->
    <div>
      <h3 class="text-2xl font-bold mb-4">Wayra Deep Down Detail</h3>
      <p class="text-gray-400">We offer home car washing and detailing services to give you convenience and a like-new car without leaving home.</p>
    </div>

    <!-- Sección de Enlaces -->
    <div>
      <h4 class="text-xl font-semibold mb-4">Quick Links</h4>
      <ul>
        <li class="mb-2"><a href="#home" class="hover:underline text-gray-300">Home</a></li>
        <li class="mb-2"><a href="#aboutUs" class="hover:underline text-gray-300">About Us</a></li>
        <li class="mb-2"><a href="{{ url('/detailing-services') }}" class="hover:underline text-gray-300">Detailing Services</a></li>
        <li><a href="{{ url('/car-wash') }}" class="hover:underline text-gray-300">Car Wash</a></li>
        <li><a href="{{ url('/products') }}" class="hover:underline text-gray-300">Products</a></li>
        <li><a href="{{ url('/contactform') }}" class="hover:underline text-gray-300">Contact</a></li>
      </ul>
    </div>

    <!-- Sección de Contacto -->
    <div>
      <h4 class="text-xl font-semibold mb-4">Contact Us</h4>
      <p class="text-gray-400 mb-2">
        <i class="fas fa-phone-alt mr-2"></i>
        <a href="tel:+1234567890" class="hover:underline">+1 (425) 350 - 6740</a>
      </p>
      <p class="text-gray-400 mb-2">
        <i class="fas fa-envelope mr-2"></i>
        <a href="mailto:customer@sumaccdetailing.com" class="hover:underline">customer@wayra.com</a>
      </p>

      <!-- Redes Sociales -->
      <div class="mt-4 flex space-x-4">
        <a href="https://wa.link/h463vd" target="_blank" class="hover:text-green-400">
          <img src="{{ asset('SocialNetsIcon/whatssapp.png') }}" alt="WhatsApp" class="w-6 h-6" />
        </a>
        <a href="https://www.facebook.com/profile.php?id=61566085425354" target="_blank" class="hover:text-blue-600">
          <img src="{{ asset('SocialNetsIcon/facebook-colores.svg') }}" alt="Facebook" class="w-6 h-6" />
        </a>
        <a href="https://www.instagram.com/wayraplace2024/" target="_blank" class="hover:text-pink-500">
          <img src="{{ asset('SocialNetsIcon/instagram.png') }}" alt="Instagram" class="w-6 h-6" />
        </a>
      </div>
    </div>
  </div>

  <!-- Línea divisoria y Derechos Reservados -->
  <div class="border-t border-gray-700 mt-10 pt-4">
    <p class="text-center text-gray-500 text-sm">&copy; 2024 WAYRA Deep Down Detail. All rights reserved.</p>
  </div>
</footer>