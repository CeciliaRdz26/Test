@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Clientes</h1>
        <div class="mb-4">
            <button onclick="document.getElementById('modal').classList.remove('hidden')"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear Cliente</button>
        </div>

        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @endif

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">No</th>
                    <th class="py-2 px-4 border-b">Nombre</th>
                    <th class="py-2 px-4 border-b">Correo</th>
                    <th class="py-2 px-4 border-b">Teléfono</th>
                    <th class="py-2 px-4 border-b">Dirección</th>
                    <th class="py-2 px-4 border-b">RFC</th>
                    <th class="py-2 px-4 border-b">Razon Social</th>
                    <th class="py-2 px-4 border-b">Codigo Postal</th>
                    <th class="py-2 px-4 border-b">Regimen Fiscal</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 border-b">{{ $cliente->nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ $cliente->correo }}</td>
                        <td class="py-2 px-4 border-b">{{ $cliente->telefono }}</td>
                        <td class="py-2 px-4 border-b">{{ $cliente->direccion }}</td>
                        <td class="py-2 px-4 border-b">{{ $cliente->rfc }}</td>
                        <td class="py-2 px-4 border-b">{{ $cliente->razon_social }}</td>
                        <td class="py-2 px-4 border-b">{{ $cliente->codigo_postal }}</td>
                        <td class="py-2 px-4 border-b">{{ $cliente->regimen_fiscal }}</td>
                        <th class="py-2 px-4 border-b">
                            <a href="{{ route('clientes.show', $cliente->id_cliente) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Ver</a>
                            <a href="{{ route('clientes.edit', $cliente->id_cliente) }}"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Editar</a>
                            <form id="button-borrar-{{ $cliente->id_cliente }}" action="{{ route('clientes.destroy', $cliente->id_cliente) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmar({{ $cliente->id_cliente }}, '{{ $cliente->nombre }}')"
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
                <h2 class="text-xl font-bold mb-4" id="modalTitle">Crear Cliente</h2>
                <form id="clienteForm" method="POST" action="{{ route('clientes.store') }}">
                    @csrf
                    <input type="hidden" name="id_cliente" id="id_cliente">
                    <div class="mb-4">
                        <label class="block text-gray-700">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Correo</label>
                        <input type="email" name="correo" id="correo" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Dirección</label>
                        <textarea name="direccion" id="direccion" class="w-full p-2 border rounded" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">RFC</label>
                        <input type="text" name="rfc" id="rfc" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Razon Social</label>
                        <input type="text" name="razon_social" id="razon_social" class="w-full p-2 border rounded"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Codigo Postal</label>
                        <input type="text" name="codigo_postal" id="codigo_postal" class="w-full p-2 border rounded"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Regimen Fiscal</label>
                        <input type="text" name="regimen_fiscal" id="regimen_fiscal" class="w-full p-2 border rounded"
                            required>
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
        function confirmar(id, cliente) {
            Swal.fire({
                title: 'Confirmacion!',
                text: '¿Estas seguro de eliminar el cliente [' + cliente + ']?',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('button-borrar-' + id).submit()
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('createNewCliente').addEventListener('click', function() {
                document.getElementById('modalTitle').innerText = 'Crear Cliente';
                document.getElementById('clienteForm').reset();
                document.getElementById('id_cliente').value = '';
                document.getElementById('modal').classList.remove('hidden');
            });

            document.querySelectorAll('.editCliente').forEach(function(button) {
                button.addEventListener('click', function() {
                    var id_cliente = this.getAttribute('data-id');
                    fetch(`{{ url('clientes') }}/${id_cliente}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('modalTitle').innerText = 'Editar Cliente';
                            document.getElementById('id_cliente').value = data.id_cliente;
                            document.getElementById('nombre').value = data.nombre;
                            document.getElementById('correo').value = data.correo;
                            document.getElementById('telefono').value = data.telefono;
                            document.getElementById('direccion').value = data.direccion;
                            document.getElementById('rfc').value = data.rfc;
                            document.getElementById('razon_social').value = data.razon_social;
                            document.getElementById('codigo_postal').value = data.codigo_postal;
                            document.getElementById('regimen_fiscal').value = data
                                .regimen_fiscal;
                            document.getElementById('modal').classList.remove('hidden');
                        });
                });
            });
        });
    </script>
@endsection
