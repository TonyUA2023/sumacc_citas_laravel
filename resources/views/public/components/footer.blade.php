<footer class="bg-gradient-to-br from-gray-900 to-gray-800 text-white py-12">
  <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-12">
    <!-- Company Information Section -->
    <div class="transform transition duration-300 hover:translate-y-[-5px]">
      <h3 class="text-2xl font-bold mb-4 text-white border-b border-blue-500 pb-2 inline-block">Wayra Deep Down Detail</h3>
      <p class="text-gray-300 mt-4 leading-relaxed">We offer home car washing and detailing services to give you convenience and a like-new car without leaving home.</p>
    </div>

    <!-- Quick Links Section -->
    <div class="transform transition duration-300 hover:translate-y-[-5px]">
      <h4 class="text-xl font-semibold mb-4 text-white border-b border-blue-500 pb-2 inline-block">Quick Links</h4>
      <ul class="mt-4">
        <li class="mb-3 transition duration-300 ease-in-out transform hover:translate-x-2">
          <a href="#home" class="text-gray-300 hover:text-white flex items-center">
            <span class="w-1 h-1 bg-blue-500 rounded-full mr-2"></span>Home
          </a>
        </li>
        <li class="mb-3 transition duration-300 ease-in-out transform hover:translate-x-2">
          <a href="{{ url('/detailing-services') }}" class="text-gray-300 hover:text-white flex items-center">
            <span class="w-1 h-1 bg-blue-500 rounded-full mr-2"></span>Detailing Services
          </a>
        </li>
        <li class="mb-3 transition duration-300 ease-in-out transform hover:translate-x-2">
          <a href="{{ url('/car-wash') }}" class="text-gray-300 hover:text-white flex items-center">
            <span class="w-1 h-1 bg-blue-500 rounded-full mr-2"></span>Car Wash
          </a>
        </li>
        <li class="mb-3 transition duration-300 ease-in-out transform hover:translate-x-2">
          <a href="{{ url('/products') }}" class="text-gray-300 hover:text-white flex items-center">
            <span class="w-1 h-1 bg-blue-500 rounded-full mr-2"></span>Products
          </a>
        </li>
      </ul>
    </div>

    <!-- Contact Section -->
    <div class="transform transition duration-300 hover:translate-y-[-5px]">
      <h4 class="text-xl font-semibold mb-4 text-white border-b border-blue-500 pb-2 inline-block">Contact Us</h4>
      <div class="mt-4">
        <p class="text-gray-300 mb-4 transition duration-300 hover:text-white flex items-center">
          <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
          </svg>
          <a href="tel:+1234567890" class="hover:underline transition duration-300">+1 (425) 350 - 6740</a>
        </p>
        <p class="text-gray-300 mb-4 transition duration-300 hover:text-white flex items-center">
          <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
          </svg>
          <a href="mailto:customer@wayra.com" class="hover:underline transition duration-300">customer@wayra.com</a>
        </p>

        <!-- Social Media -->
        <div class="mt-6">
          <h5 class="text-sm font-semibold text-gray-300 mb-3">FOLLOW US</h5>
          <div class="flex space-x-5">
            <a href="https://wa.link/h463vd" target="_blank" class="bg-gray-700 p-2 rounded-full transition duration-300 hover:bg-green-600 hover:scale-110 transform">
              <img src="{{ asset('SocialNetsIcon/whatssapp.png') }}" alt="WhatsApp" class="w-6 h-6" />
            </a>
            <a href="https://www.facebook.com/profile.php?id=61566085425354" target="_blank" class="bg-gray-700 p-2 rounded-full transition duration-300 hover:bg-blue-600 hover:scale-110 transform">
              <img src="{{ asset('SocialNetsIcon/facebook-colores.svg') }}" alt="Facebook" class="w-6 h-6" />
            </a>
            <a href="https://www.instagram.com/wayraplace2024/" target="_blank" class="bg-gray-700 p-2 rounded-full transition duration-300 hover:bg-pink-600 hover:scale-110 transform">
              <img src="{{ asset('SocialNetsIcon/instagram.png') }}" alt="Instagram" class="w-6 h-6" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Divider and Copyright -->
  <div class="border-t border-gray-700 mt-10 pt-6">
    <p class="text-center text-gray-400 text-sm">&copy; 2024 WAYRA Deep Down Detail. All rights reserved. <span class="block sm:inline-block mt-2 sm:mt-0 sm:ml-2">Developed by <a href="#" class="text-blue-400 hover:underline font-medium">Jstack Digital Solutions</a></span></p>
  </div>
</footer>