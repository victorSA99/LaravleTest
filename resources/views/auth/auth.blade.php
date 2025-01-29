@extends('master')


@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="bg-white shadow-lg rounded-lg flex flex-col md:flex-row w-full max-w-4xl overflow-hidden">
        <!-- Left side: Image or Logo -->
        <div class="w-full md:w-1/2 bg-blue-500 flex items-center justify-center p-6">
            <img src="assets/images/cietas.png" alt="Logo" class="w-3/4 object-cover">
        </div>

        <!-- Right side: Form -->
        <div class="w-full md:w-1/2 p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Login</h2>

            <form id="loginForm">
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input type="email" id="email" placeholder="Ingresa tu correo electrónico" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="password" placeholder="Ingresa tu contraseña" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button type="button" onclick="enviar()" class="w-full py-2 px-4 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none">
                    Login
                </button>
            </form>

            <p class="mt-4 text-sm text-gray-600 text-center">No tienes cuenta? <a href="#" class="text-blue-500 hover:underline">Crear cuenta</a></p>
        </div>
    </div>
</div>
@endsection

@pushOnce('scripts')
<script>
    
    $(document).ready(() => {
        console.log("ready");
    });

    function enviar() {
        const formData = new FormData();
        formData.append('email', $('#email').val());
        formData.append('password', $('#password').val());

        $.ajax({
            url: "{{url('web-login')}}",
            type: 'POST',
            data: formData,
      
            processData: false,
            contentType: false,
            success: (res, _, jqXHR) => {
                console.log(res)
              
                if (res) {
                    window.location.href = '/dashboard';
                } else {
                    alert('No se incio sesion');
                }
            },
            error: function(xhr, status, error) {
         
            var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "Error al inciar sesion";
console.log(error)
         
            toastr.error(errorMessage, 'Error',{"positionClass": "toast-bottom-right",
                        "timeOut": 1000,
                        "closeButton": true,
                        "progressBar": true,});
        }
        });
    }
</script>
@endPushOnce
