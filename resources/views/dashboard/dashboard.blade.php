@extends('master')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Lista de Citas</h2>

    <!-- Filtros -->
    <form method="GET" action="{{ route('dashboard.index') }}" class="mb-6 flex space-x-4">
        <div class="flex space-x-2">
            <label for="user_name" class="text-gray-700">Buscar por Nombre</label>
            <input type="text" id="user_name" name="user_name" value="{{ request('user_name') }}" class="px-4 py-2 border rounded" placeholder="Nombre del paciente">
        </div>
        <div class="flex space-x-2">
            <label for="status" class="text-gray-700">Estado</label>
            <select id="status" name="status" class="px-4 py-2 border rounded">
                <option value="">Seleccionar Estado</option>
                @foreach ($appointmentStatuses as $status)
                    <option value="{{ $status->value }}" @if(request('status') == $status->value) selected @endif>
                        {{ $status->value }}
                    </option>
                @endforeach
            </select>
        </div>


        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Buscar</button>
    </form>

    <table class="min-w-full table-auto">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="px-4 py-2 text-center">#</th>
                <th class="px-4 py-2 text-center">Fecha</th>
                <th class="px-4 py-2 text-center">Hora</th>
                <th class="px-4 py-2 text-center">Paciente</th>
                <th class="px-4 py-2 text-center">Status</th>
                <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="tableBody" class="bg-white">
            @if(count($appointments) > 0)
                @foreach($appointments as $appointment)
                    <tr>
                        <td class="px-4 py-2 text-center">{{ $appointment->id }}</td>
                        <td class="px-4 py-2 text-center">{{ $appointment->date }}</td>
                        <td class="px-4 py-2 text-center">{{ $appointment->time }}</td>
                        <td class="px-4 py-2 text-center">{{ $appointment->user->name }}</td>
                        <td class="px-4 py-2 text-center">
                            <select id="status-{{ $appointment->id }}" name="status" onchange="updateStatus({{ $appointment->id }})">
                                @foreach ($appointmentStatuses as $status)
                                    <option value="{{ $status->value }}" @if ($appointment->status == $status->value) selected @endif>
                                        {{ $status->value }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center space-x-4">
                                <button class="text-orange-600 hover:text-orange-800 hover:bg-orange-100 focus:outline-none p-2 rounded-full shadow-md transition duration-300 ease-in-out transform hover:scale-105" onclick="openModal({{ $appointment->id }}, '{{ $appointment->date }}', '{{ $appointment->time }}')">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="text-white bg-red-600 hover:bg-red-800 focus:outline-none p-2 rounded-full shadow-md transition duration-300 ease-in-out transform hover:scale-105" onclick="deleteRow({{ $appointment->id }})">
                                    <i class="fas fa-trash"></i> 
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="px-4 py-2 text-center text-gray-500">No hay citas disponibles</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $appointments->links() }} <!-- Paginación con números -->
    </div>

</div>

<!-- Modal de edición -->
<div id="editModal" class="fixed inset-0 flex justify-center items-center bg-gray-500 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Actualizar Cita</h3>
        
        <form id="editAppointmentForm">
            <input type="hidden" id="appointmentId" name="appointmentId">
            
            <div class="mb-4">
                <label for="newDate" class="block text-gray-700">Fecha</label>
                <input type="text" id="newDate" name="newDate" class="px-4 py-2 border rounded w-full" readonly />
            </div>
            
            <div class="mb-4">
                <label for="newTime" class="block text-gray-700">Hora</label>
                <input type="time" id="newTime" name="newTime" class="px-4 py-2 border rounded w-full" required />
            </div>
            
            <div class="flex justify-end space-x-4">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
       
        $('#newDate').datepicker({
            dateFormat: 'yy-mm-dd', 
        });

      
        function openModal(appointmentId, currentDate, currentTime) {
           
            $('#appointmentId').val(appointmentId);
            $('#newDate').val(currentDate);
            $('#newTime').val(currentTime);

         
            $('#editModal').removeClass('hidden');
        }

    
        function closeModal() {
            $('#editModal').addClass('hidden');
        }

    
        $('#editAppointmentForm').on('submit', function(event) {
            event.preventDefault();
            
            var appointmentId = $('#appointmentId').val();
            var newDate = $('#newDate').val();
            var newTime = $('#newTime').val();

            $.ajax({
                url: 'update/' + appointmentId,
                type: 'PATCH',
                data: {
                    date: newDate,
                    time: newTime,
                },
                success: function(response) {
                    toastr.success("Cita actualizada exitosamente", "Éxito", {
                        "positionClass": "toast-bottom-right",
                        "timeOut": 1000,
                        "closeButton": true,
                        "progressBar": true,
                    });
                    location.reload(); 
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar la cita:', error);
                    alert('Hubo un error al actualizar la cita');
                }
            });

            closeModal(); 
        });
        
       
        window.openModal = openModal;
        window.closeModal = closeModal;
    });

   
    function updateStatus(appointmentId) {
        var status = $('#status-' + appointmentId).val();
        $.ajax({
            url:  appointmentId + `/status`, 
            type: 'PATCH', 
            data: {
                status: status, 
            },
            success: function(response) {
                console.log('Estado actualizado:', response);
                toastr.success("Cita Actualizada", "Éxito", {
                    "positionClass": "toast-bottom-right", 
                    "timeOut": 1000, 
                    "closeButton": true, 
                    "progressBar": true, 
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar el estado:', error);
                alert('Hubo un error al actualizar el estado');
            }
        });
    }

    
    function deleteRow(id) {
        if (confirm('¿Seguro que deseas eliminar esta cita?')) {
            $.ajax({
                url: 'delete/' + id ,
                type: 'DELETE',
                success: function(response) {
                    toastr.success("Cita Eliminada", "Éxito", {
                        "positionClass": "toast-bottom-right", 
                        "timeOut": 1000, 
                        "closeButton": true, 
                        "progressBar": true, 
                    });
                    location.reload();  
                },
                error: function(xhr, status, error) {
                    console.error('Error al eliminar la cita:', error);
                    alert('Hubo un error al eliminar la cita.');
                }
            });
        }
    }
</script>
@endpush
