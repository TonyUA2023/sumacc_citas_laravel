<section class="bg-black py-16 px-5 md:px-20" id="location">
  <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-10">
    <!-- Columna Izquierda: Mapa -->
    <div class="w-full h-96 lg:h-full rounded-xl overflow-hidden shadow-lg relative">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2255.038382074832!2d-122.340385985739!3d47.61701715472671!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5490154a2ac5c6b3%3A0xdb4d17fe27a0a61a!2s720%20Blanchard%20St%2C%20Seattle%2C%20WA%2098121%2C%20EE.%20UU.!5e1!3m2!1ses!2spe!4v1727753411864!5m2!1ses!2spe"
        width="800"
        height="600"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        class="w-full h-full"
      ></iframe>

      <!-- Cuadro de texto sobre el mapa -->
      <div class="absolute top-28 left-5 bg-white bg-opacity-80 p-4 rounded shadow-lg">
        <h4 class="text-lg font-bold text-black">Hours of Operation</h4>
        <p class="text-black">Monday: 8.00 am - 5.00pm</p>
        <p class="text-black">Tuesday: 8.00 am - 5.00pm</p>
        <p class="text-black">Wednesday: 8.00 am - 5.00pm</p>
        <p class="text-black">Thursday: 8.00 am - 5.00pm</p>
        <p class="text-black">Friday: 8.00 am - 5.00pm</p>
        <p class="text-black">Saturday: 8.00 am - 5.00pm</p>
        <p class="text-black">Sunday: 8.00 am - 5.00pm</p>
      </div>
    </div>

    <!-- Columna Derecha: Contacto y Formulario -->
    <div class="bg-gray-900 p-8 rounded-xl shadow-lg">
      <!-- Información de contacto -->
      <h3 class="text-3xl font-bold text-white">Contact Us</h3>
      <p class="mt-2 text-lg text-gray-400">We are here to help you!</p>

      <div class="mt-5 space-y-4">
        <p class="flex items-center text-lg text-gray-300">
          <svg class="w-6 h-6 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 8l7.89 5.26c.52.35 1.18.35 1.7 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z"></path>
          </svg>
          customer@wayraplace.com
        </p>
        <p class="flex items-center text-lg text-gray-300">
          <svg class="w-6 h-6 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 10l1.05-1.05c.27-.27.62-.42.98-.46L12 8l7.97-1.51c.36-.04.7.08.98.34L21 10M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
          </svg>
          +1 (425) 350 - 6740
        </p>

        <!-- Redes sociales -->
        <div class="flex space-x-4 mt-4">
          <a href="https://www.facebook.com/profile.php?id=61566085425354" target="_blank" class="text-blue-600 hover:text-blue-800">
            <img src="{{ asset('SocialNetsIcon/facebook-colores.svg') }}" alt="Facebook icon" class="w-6 h-6" />
          </a>
          <a href="https://www.instagram.com/" target="_blank" class="text-pink-500 hover:text-pink-700">
            <img src="{{ asset('SocialNetsIcon/instagram.png') }}" alt="Instagram icon" class="w-6 h-6" />
          </a>
          <a href="https://wa.link/h463vd" target="_blank" class="text-green-500 hover:text-green-700">
            <img src="{{ asset('SocialNetsIcon/whatssapp.png') }}" alt="WhatsApp icon" class="w-6 h-6" />
          </a>
          <a href="https://www.tiktok.com/@wayra263" target="_blank" class="text-pink-500 hover:text-pink-700">
            <img src="{{ asset('SocialNetsIcon/tiktok.png') }}" alt="TikTok icon" class="w-6 h-6" />
          </a>
        </div>
      </div>

      <!-- Formulario de contacto -->
      <form class="mt-10 space-y-4">
        <label for="name" class="block text-lg text-gray-300 font-semibold">Name:</label>
        <input id="name" type="text"
          class="w-full border-2 border-gray-600 bg-gray-800 text-white rounded-lg p-3 focus:border-blue-500 focus:outline-none"
          placeholder="Write your name to send us a message" />

        <a href="https://wa.link/h463vd"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg w-full hover:bg-blue-700 transition block text-center">Send to WhatsApp</a>
      </form>
    </div>
  </div>
</section>