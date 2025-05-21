<!DOCTYPE html>
<html lang="es" class="h-full bg-gradient-to-br from-blue-400 via-gray-800 to-gray-900">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex items-center justify-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80');">

    <div class="max-w-md w-full bg-gray-900 bg-opacity-90 rounded-2xl shadow-2xl p-10 space-y-8 backdrop-blur-sm">
        <!-- Logo -->
        <div class="flex justify-center">
            <img src="/logo/logopng.png" alt="Logo Wayra" class="w-28 h-28 object-contain" />
        </div>

        <h1 class="text-4xl font-extrabold text-center text-white tracking-wide">Ingreso Administrativo</h1>

        @if($errors->any())
            <div class="bg-red-700 bg-opacity-80 text-red-100 p-3 rounded-lg border border-red-600 text-center font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-6" novalidate>
            @csrf
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">Correo Electrónico</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    required
                    autofocus
                    class="appearance-none block w-full px-4 py-3 rounded-lg border border-blue-500 bg-gray-800 text-white placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 sm:text-sm"
                    placeholder="ejemplo@correo.com"
                />
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-300 mb-2">Contraseña</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    class="appearance-none block w-full px-4 py-3 rounded-lg border border-blue-500 bg-gray-800 text-white placeholder-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 sm:text-sm"
                    placeholder="********"
                />
            </div>

            <button
                type="submit"
                class="w-full flex justify-center py-3 px-6 rounded-lg shadow-lg text-white bg-gradient-to-r from-blue-500 to-gray-700 hover:from-blue-600 hover:to-gray-800 focus:outline-none focus:ring-4 focus:ring-blue-400 font-semibold text-lg transition"
            >
                Ingresar
            </button>
        </form>

        <p class="text-center text-gray-400 text-sm mt-6 select-none">
            © {{ date('Y') }} Wayra Place. Todos los derechos reservados.
        </p>
    </div>

</body>
</html>