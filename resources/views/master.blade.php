<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col min-h-screen">

<!-- Navbar -->
<nav class="bg-blue-600 shadow-lg">
    @if(auth()->guard('web')->check())
        <p class="text-white ml-4">Bienvenido, {{ auth()->guard('web')->user()->name }}!</p>
  
    @endif
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <div class="text-white text-2xl font-bold flex items-center space-x-2">
            <!-- Añadiendo estilo al nombre de "Administrador" -->
            <span class="text-3xl font-semibold uppercase tracking-wide">Administrador</span>
        </div>
     
        @if(auth()->guard('web')->check())
            <div id="logout-container" class="hidden md:flex space-x-6 flex space-x-6 items-center">
                <a href="{{ route('usuarios.index') }}" class="text-white hover:text-blue-300 transition {{ request()->routeIs('usuarios.index') ? 'text-blue-300 font-semibold' : '' }}">Usuarios</a>
                <a href="{{ route('dashboard.index') }}" class="text-white hover:text-blue-300 transition {{ request()->routeIs('dashboard.index') ? 'text-blue-300 font-semibold' : '' }}">Citas</a>
                <!-- Este es el botón de Cerrar sesión -->
                <button onclick="cerrarSesion()" id="logout-btn" class="text-white hover:text-blue-300 transition">
                    Cerrar sesión
                </button>
            </div>
        @endif
    </div>
</nav>


<!-- Main Content -->
<div class="flex-grow">
    @yield('content')
</div>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="text-center md:text-left">
                <h3 class="text-2xl font-bold mb-2">Agendar Citas</h3>
                <p class="text-gray-400">La mejor plataforma para Agendar citas</p>
            </div>
        </div>
        <div class="flex flex-col md:flex-row justify-between items-center border-t border-gray-700 pt-6">
            <p class="text-gray-400 text-sm text-center md:text-left">© 2025 Agendar citas. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="../js/ajaxInterceptor.js"></script>
@stack('scripts')
<script>
function cerrarSesion(){
    $.ajax({
        url: 'web-logout',
        type: 'POST',
        success: function() {
            console.log("Cierre de sesión exitoso");
            window.location.href = '/login'; 
        },
        error: function() {
            alert('Error al cerrar sesión');
        }
    });
}
</script>

</body>
</html>
