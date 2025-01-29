@extends('master')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Lista de Usuarios</h1>

        <!-- Botón Crear Usuario -->
        <button class="bg-green-600 text-white px-4 py-2 rounded mb-4" onclick="openCreateModal()">
            Crear Usuario
        </button>

        <!-- Filtro de búsqueda -->
        <form method="GET" action="{{ route('usuarios.index') }}" class="mb-4">
            <input type="text" name="name" placeholder="Buscar por nombre" value="{{ request()->get('name') }}" class="border p-2 rounded">
            <select name="rol" class="border p-2 rounded">
                <option value="">Seleccione Rol</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ request()->get('rol') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Buscar</button>
        </form>

        <!-- Tabla de usuarios -->
        <table class="min-w-full table-auto">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2 text-center">Nombre</th>
                    <th class="px-4 py-2 text-center">Correo</th>
                    <th class="px-4 py-2 text-center">Rol</th>
                    <th class="px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="bg-white">
                @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-2 text-center">{{ $user->name }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-center">{{ ucfirst($user->rol) }}</td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center space-x-4">
                                <!-- Botón Editar con ícono de lápiz -->
                                <button class="text-orange-600 hover:text-orange-800 hover:bg-orange-100 focus:outline-none p-2 rounded-full shadow-md"
                                        onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->rol }}')">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>

                                <!-- Botón Eliminar con ícono de bote de basura -->
                                <button class="text-white bg-red-600 hover:bg-red-800 focus:outline-none p-2 rounded-full shadow-md"
                                        onclick="deleteUser({{ $user->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal Crear Usuario -->
    <div id="createModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
            <h2 class="text-xl font-semibold mb-4">Crear Usuario</h2>
            <form id="createUserForm">
                @csrf
                <div class="mb-4">
                    <label for="createName" class="block text-gray-700">Nombre</label>
                    <input type="text" id="createName" name="name" class="border p-2 w-full rounded" required>
                </div>
                <div class="mb-4">
                    <label for="createEmail" class="block text-gray-700">Email</label>
                    <input type="email" id="createEmail" name="email" class="border p-2 w-full rounded" required>
                </div>
                <div class="mb-4">
                    <label for="createRol" class="block text-gray-700">Rol</label>
                    <select id="createRol" name="rol" class="border p-2 w-full rounded" required>
                        <option value="admin">Administrador</option>
                        <option value="user">Usuario</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="createPassword" class="block text-gray-700">Contraseña</label>
                    <input type="password" id="createPassword" name="password" class="border p-2 w-full rounded" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Crear</button>
                    <button type="button" class="ml-2 text-gray-600" onclick="closeCreateModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Usuario -->
    <div id="editModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
            <h2 class="text-xl font-semibold mb-4">Editar Usuario</h2>
            <form id="editUserForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="userId" name="userId" value="">
                <div class="mb-4">
                    <label for="editName" class="block text-gray-700">Nombre</label>
                    <input type="text" id="editName" name="name" class="border p-2 w-full rounded" required>
                </div>
                <div class="mb-4">
                    <label for="editRol" class="block text-gray-700">Rol</label>
                    <select id="editRol" name="rol" class="border p-2 w-full rounded" required>
                        <option value="admin">Administrador</option>
                        <option value="user">Usuario</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
                    <button type="button" class="ml-2 text-gray-600" onclick="closeEditModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openCreateModal() {
        event.preventDefault();  
        $('#createModal').removeClass('hidden');
    }

    function closeCreateModal() {
        $('#createModal').addClass('hidden');
    }
    $('#createUserForm').on('submit', function(event) {
        event.preventDefault();

        var name = $('#createName').val();
        var email = $('#createEmail').val();
        var rol = $('#createRol').val();
        var password = $('#createPassword').val();

        $.ajax({
            url: "{{ route('usuarios.store') }}",  // Ruta para crear el usuario
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                name: name,
                email: email,
                rol: rol,
                password: password
            },
            success: function(response) {
                toastr.success("Usuario creado exitosamente", "Éxito", {
                    "positionClass": "toast-bottom-right",
                    "timeOut": 1000,
                    "closeButton": true,
                    "progressBar": true,
                });
                location.reload();  // Recargar la página después de crear el usuario
            },
            error: function(xhr, status, error) {
                console.error('Error al crear el usuario:', error);
                alert('Hubo un error al crear el usuario');
            }
        });

        closeCreateModal();  // Cerrar el modal después de enviar el formulario
    });

    function openEditModal(userId, userName, userRol) {
        $('#userId').val(userId);
        $('#editName').val(userName);
        $('#editRol').val(userRol);
        $('#editModal').removeClass('hidden');
    }

    function closeEditModal() {
        $('#editModal').addClass('hidden');
    }

    $('#editUserForm').on('submit', function(event) {
        event.preventDefault();  

        var userId = $('#userId').val();
        var userName = $('#editName').val();
        var userRol = $('#editRol').val();

        $.ajax({
            url: '/usuarios/update/' + userId,  
            type: 'PUT',
            data: {
                name: userName,
                rol: userRol
            },
            success: function(response) {
                toastr.success("Usuario actualizado exitosamente", "Éxito", {
                    "positionClass": "toast-bottom-right",
                    "timeOut": 1000,
                    "closeButton": true,
                    "progressBar": true,
                });
                location.reload();  
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar el usuario:', error);
                alert('Hubo un error al actualizar el usuario');
            }
        });

        closeEditModal();  
    });

    function deleteUser(userId) {
        if (confirm('¿Seguro que deseas eliminar este usuario?')) {
            $.ajax({
                url: '/usuarios/delete/' + userId,  
                type: 'DELETE',
                success: function(response) {
                    toastr.success("Usuario eliminado exitosamente", "Éxito", {
                        "positionClass": "toast-bottom-right",
                        "timeOut": 1000,
                        "closeButton": true,
                        "progressBar": true,
                    });
                    location.reload();  
                },
                error: function(xhr, status, error) {
                    console.error('Error al eliminar el usuario:', error);
                    alert('Hubo un error al eliminar el usuario');
                }
            });
        }
    }
</script>
@endpush
