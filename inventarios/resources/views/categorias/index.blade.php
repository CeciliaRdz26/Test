@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Categorías</h1>
    <div class="mb-4">
        <button onclick="document.getElementById('modal').classList.remove('hidden')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar Categoría</button>
    </div>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Nombre</th>
                <th class="py-2 px-4 border-b">Estatus</th>
                <th class="py-2 px-4 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $categoria)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $categoria->nombre_categoria }}</td>
                    <td class="py-2 px-4 border-b">{{ $categoria->estatus }}</td>
                    <th class="py-2 px-4 border-b">
                        <button onclick="editCategoria({{ $categoria }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Editar</button>
                        <form id="button-borrar-{{ $categoria->id_categoria }}" action="{{ route('categorias.destroy', $categoria->id_categoria) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmar({{ $categoria->id_categoria }}, '{{ $categoria->nombre_categoria }}')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Eliminar</button>
                        </form>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center overflow-auto hidden">
        <div class="bg-white p-2 rounded-lg shadow-lg max-h-full max-w-md w-full">
            <h2 id="modal-title" class="text-xl font-bold mb-4">Agregar Categoría</h2>
            <form id="categoria-form" method="POST" action="{{ route('categorias.store') }}">
                @csrf
                <input type="hidden" id="method" name="_method" value="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" id="nombre_categoria" name="nombre_categoria" class="w-full p-2 border rounded" required>
                </div>
                <div id="div-estatus" style="display: none" class="mb-4">
                    <label class="block text-gray-700">Estatus</label>
                    <select id="estatus" name="estatus" class="w-full p-2 border rounded">
                        <option value="Activo" selected>Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function confirmar(id, categoria) {
        Swal.fire({
            title: 'Confirmacion!',
            text: '¿Estas seguro de eliminar el categoria ['+categoria+']?',
            icon: 'warning',
            confirmButtonText: 'Aceptar',
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('button-borrar-' + id).submit()
            }
        });
    }

    function editCategoria(categoria) {
        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modal-title').innerText = 'Editar Categoría';
        document.getElementById('div-estatus').style.display = 'block';
        document.getElementById('nombre_categoria').value = categoria.nombre_categoria;
        document.getElementById('categoria-form').action = '/categorias/' + categoria.id_categoria;
        document.getElementById('method').value = 'PUT';
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('modal-title').innerText = 'Agregar Categoría';
        document.getElementById('nombre_categoria').value = '';
        document.getElementById('div-estatus').style.display = 'none';
        document.getElementById('categoria-form').action = '{{ route('categorias.store') }}';
        document.getElementById('method').value = 'POST';
    }
</script>
@endsection
