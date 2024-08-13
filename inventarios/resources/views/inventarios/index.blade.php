@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Inventarios</h1>
        <div class="mb-4 flex justify-between">
            <button onclick="document.getElementById('modal').classList.remove('hidden')"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar Inventario</button>
            <input type="text" id="search" placeholder="Buscar por nombre de producto" class="border p-2 rounded w-1/3">
        </div>

        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @endif

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Producto</th>
                    <th class="py-2 px-4 border-b">Categoría</th>
                    <th class="py-2 px-4 border-b">Fecha de entrada</th>
                    <th class="py-2 px-4 border-b">Fecha de salida</th>
                    <th class="py-2 px-4 border-b">Motivo</th>
                    <th class="py-2 px-4 border-b">Movimiento</th>
                    <th class="py-2 px-4 border-b">Cantidad</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody id="inventarioTable">
                @foreach ($inventarios as $inventario)
                    <tr class="inventario-row">
                        <td class="py-2 px-4 border-b producto-nombre">{{ $inventario->producto->nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ $inventario->categoria->nombre_categoria }}</td>
                        <td class="py-2 px-4 border-b">{{ $inventario->fecha_entrada }}</td>
                        <td class="py-2 px-4 border-b">{{ $inventario->fecha_salida }}</td>
                        <td class="py-2 px-4 border-b">{{ $inventario->motivo }}</td>
                        <td class="py-2 px-4 border-b">{{ $inventario->movimiento }}</td>
                        <td class="py-2 px-4 border-b">{{ $inventario->cantidad }}</td>
                        <th class="py-2 px-4 border-b">
                            <a href="#"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded editInventario"
                                data-id="{{ $inventario->id_inventario }}">Editar</a>
                            <form id="button-borrar-{{ $inventario->id_inventario }}" method="POST" action="{{ route('inventarios.destroy', $inventario->id_inventario) }}"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmar({{ $inventario->id_inventario }})"
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
                <h2 class="text-xl font-bold mb-4" id="modalTitle">Agregar Inventario</h2>
                <form id="inventarioForm" method="POST" action="{{ route('inventarios.store') }}">
                    @csrf
                    <input type="hidden" id="method" name="_method" value="POST">
                    <input type="hidden" name="id_inventario" id="id_inventario">
                    <div class="mb-4">
                        <label class="block text-gray-700">Producto</label>
                        <select name="producto_id" id="producto_id" class="w-full p-2 border rounded" required>
                            <option value="">Seleccione un producto</option>
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->id_producto }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="w-full p-2 border rounded" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Fecha de entrada</label>
                        <input type="date" name="fecha_entrada" id="fecha_entrada" class="w-full p-2 border rounded"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Fecha de salida</label>
                        <input type="date" name="fecha_salida" id="fecha_salida" class="w-full p-2 border rounded"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Movimiento</label>
                        <select name="movimiento" id="movimiento" class="w-full p-2 border rounded" required>
                            <option value="Entrada">Entrada</option>
                            <option value="Salida">Salida</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Motivo</label>
                        <input type="text" name="motivo" id="motivo" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" step="0.01"
                            class="w-full p-2 border rounded" required>
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
        function confirmar(id) {
            Swal.fire({
                title: 'Confirmacion!',
                text: '¿Estas seguro de eliminar el inventario?',
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
            document.querySelectorAll('.editInventario').forEach(function(button) {
                button.addEventListener('click', function() {
                    var id_inventario = this.getAttribute('data-id');
                    var urls = `{{ url('inventarios') }}/${id_inventario}/edit`;
                    fetch(`{{ url('inventarios') }}/${id_inventario}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('modalTitle').innerText =
                                'Editar Inventario';
                            document.getElementById('inventarioForm').action = urls;
                            document.getElementById('method').value = 'PUT';
                            document.getElementById('id_inventario').value = data.inventario
                                .id_inventario;
                            document.getElementById('producto_id').value = data.inventario
                                .producto_id;
                            document.getElementById('categoria_id').value = data.inventario
                                .categoria_id;
                            document.getElementById('fecha_entrada').value = data.inventario
                                .fecha_entrada;
                            document.getElementById('fecha_salida').value = data.inventario
                                .fecha_salida;
                            document.getElementById('motivo').value = data.inventario.motivo;
                            document.getElementById('movimiento').value = data.inventario
                                .movimiento;
                            document.getElementById('cantidad').value = data.inventario
                            .cantidad;
                            document.getElementById('modal').classList.remove('hidden');
                        });
                });
            });

            document.getElementById('search').addEventListener('keyup', function() {
                var filter = this.value.toLowerCase();
                var rows = document.querySelectorAll('.inventario-row');

                rows.forEach(function(row) {
                    var productName = row.querySelector('.producto-nombre').textContent
                    .toLowerCase();
                    if (productName.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
