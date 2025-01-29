@extends('master')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Lista de Elementos</h2>

    <!-- Filtros y Buscador -->
    <div class="flex justify-between items-center mb-4">
        <!-- Buscador -->
        <input type="text" id="searchInput" placeholder="Buscar..." class="px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onkeyup="searchTable()" />

        <!-- Select para Filtrar -->
        <select id="filterSelect" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="filterTable()">
            <option value="">Filtrar por...</option>
            <option value="option1">Opción 1</option>
            <option value="option2">Opción 2</option>
            <option value="option3">Opción 3</option>
        </select>
    </div>

    <!-- Tabla de datos -->
    <table class="min-w-full table-auto">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Descripción</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody id="tableBody" class="bg-white">
            <!-- Iterar sobre los elementos pasados desde el controlador -->
            @foreach($appointments as $elemento)
                <tr>
                    <td class="px-4 py-2">{{ $elemento->id }}</td>
                    <td class="px-4 py-2">{{ $elemento->date }}</td>
                    <td class="px-4 py-2">{{ $elemento->descripcion }}</td>
                    <td class="px-4 py-2">
                        <button class="text-blue-600 hover:text-blue-800" onclick="editRow({{ $elemento->id }})">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="text-red-600 hover:text-red-800" onclick="deleteRow({{ $elemento->id }})">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script>
    // Función de búsqueda en la tabla
    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('tableBody');
        const tr = table.getElementsByTagName('tr');

        for (let i = 0; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName('td')[1]; // Asume que la columna de nombre está en la segunda posición
            if (td) {
                const textValue = td.textContent || td.innerText;
                if (textValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    // Función para filtrar por select
    function filterTable() {
        const select = document.getElementById('filterSelect');
        const filterValue = select.value;
        const table = document.getElementById('tableBody');
        const tr = table.getElementsByTagName('tr');

        for (let i = 0; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName('td')[2]; // Asume que la columna de descripción está en la tercera posición
            if (td) {
                const textValue = td.textContent || td.innerText;
                if (filterValue === "" || textValue.indexOf(filterValue) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    // Funciones para Editar y Eliminar
    function editRow(id) {
        alert('Editar fila con ID: ' + id);
        // Aquí puedes agregar la lógica para editar la fila
    }

    function deleteRow(id) {
        if (confirm('¿Seguro que deseas eliminar este elemento?')) {
            alert('Eliminar fila con ID: ' + id);
            // Aquí puedes agregar la lógica para eliminar la fila
        }
    }
</script>
@endpush
