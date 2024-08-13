@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Vendedor</h1>
        <div class="mb-4">
            <button onclick="document.getElementById('modal').classList.remove('hidden')"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar Vendedor</button>
        </div>

        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @endif

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Nombre</th>
                    <th class="py-2 px-4 border-b">Correo</th>
                    <th class="py-2 px-4 border-b">Telefono</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendedor as $persona)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $persona->nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ $persona->correo }}</td>
                        <td class="py-2 px-4 border-b">{{ $persona->telefono }}</td>
                        <th class="py-2 px-4 border-b">
                            <a href="#"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded editVe"
                                onclick="editVendedor({{ $persona }})">Editar</a>
                            <form id="button-borrar-{{ $persona->id }}" method="POST" action="{{ route('vendedor.destroy', $persona->id) }}"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmar({{ $persona->id }}, '{{ $persona->nombre }}')"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Eliminar</button>
                            </form>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal -->
        <div id="modal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center overflow-auto hidden">
            <div class="bg-white p-4 rounded-lg shadow-lg max-h-full max-w-md w-full">
                <h2 id="modal-title" class="text-xl font-bold mb-4" id="modalTitle">Agregar Vendedor</h2>
                <form id="vendedor_form" method="POST" action="{{ route('vendedor.store') }}">
                    @csrf
                    <input type="hidden" id="method" name="_method" value="POST">
                    <div class="mb-4">
                        <label class="block text-gray-700">Nombre del vendedor</label>
                        <input type="text" name="nombre" id="nombre" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Correo del vendedor</label>
                        <input type="text" name="correo" id="correo" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Numero de telefono del vendedor</label>
                        <input type="number" name="telefono" id="telefono" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="document.getElementById('modal').classList.add('hidden')"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancelar</button>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmar(id, vendedor) {
            Swal.fire({
                title: 'Confirmacion!',
                text: '¿Estas seguro de eliminar al vendedor ['+vendedor+']?',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('button-borrar-' + id).submit()
                }
            });
        }

        function editVendedor(persona) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal-title').innerText = 'Editar vededor';
            document.getElementById('nombre').value = persona.nombre;
            document.getElementById('correo').value = persona.correo;
            document.getElementById('telefono').value = persona.telefono;

            document.getElementById('vendedor_form').action = '/vendedor/' + persona.id;
            document.getElementById('method').value = 'PUT';
        }
    </script>
@endsection
