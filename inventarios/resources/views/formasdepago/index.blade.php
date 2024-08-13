@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Formas de pago</h1>
    <div class="mb-4">
        <button onclick="document.getElementById('modal').classList.remove('hidden')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar forma de pago</button>
    </div>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <td class="py-2 px-4 border-b">Nombre</td>
                <td class="py-2 px-4 border-b">Estatus</td>
                <td class="py-2 px-4 border-b">Acciones</td>
            </tr>
        </thead>
        <tbody>
            @foreach($formasdepago as $valor)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $valor->tipo }}</td>
                    <td class="py-2 px-4 border-b">{{ $valor->estatus }}</td>
                    <td class="py-2 px-4 border-b">
                        <button onclick="editTipo({{ $valor }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Editar</button>
                        <form id="button-borrar-{{ $valor->id }}" action="{{ route('formasdepago.destroy', $valor) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmar({{ $valor->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center overflow-auto hidden">
        <div class="bg-white p-2 rounded-lg shadow-lg max-h-full max-w-md w-full">
            <h2 id="modal-title" class="text-xl font-bold mb-4">Agregar forma de pago</h2>
            <form id="pago-form" method="POST" action="{{ route('formasdepago.store') }}">
                @csrf
                <input type="hidden" id="method" name="_method" value="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">Tipo</label>
                    <input type="text" id="nombre_tipo" name="nombre_tipo" class="w-full p-2 border rounded" required>
                </div>
                <div id="estatus_div" style="display: none;" class="mb-4">
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
    function confirmar(id) {
            Swal.fire({
                title: 'Confirmacion!',
                text: '¿Estas seguro de eliminar el tipo de pago?',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('button-borrar-' + id).submit()
                }
            });
        }

    function editTipo(tipoPago) {
        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modal-title').innerText = 'Editar tipo de pago';
        document.getElementById('nombre_tipo').value = tipoPago.tipo;
        document.getElementById('estatus_div').style.display = 'block';
        document.getElementById('pago-form').action = '/formasdepago/' + tipoPago.id;
        document.getElementById('method').value = 'PUT';
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('modal-title').innerText = 'Agregar forma de pago';
        document.getElementById('nombre_tipo').value = '';
        document.getElementById('estatus_div').style.display = 'none';
        document.getElementById('pago-form').action = '{{ route('formasdepago.store') }}';
        document.getElementById('method').value = 'POST';
    }
</script>
@endsection
