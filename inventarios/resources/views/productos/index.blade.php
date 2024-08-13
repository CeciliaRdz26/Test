@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Productos</h1>
    <div class="mb-4">
        <button onclick="document.getElementById('modal').classList.remove('hidden')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar Producto</button>
    </div>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Nombre</th>
                <th class="py-2 px-4 border-b">Categoría</th>
                <th class="py-2 px-4 border-b">Precio de Venta</th>
                <th class="py-2 px-4 border-b">Precio de Compra</th>
                <th class="py-2 px-4 border-b">Cantidad</th>
                <th class="py-2 px-4 border-b">Fecha de Compra</th>
                <th class="py-2 px-4 border-b">Color</th>
                <th class="py-2 px-4 border-b">Descripción Corta</th>
                <th class="py-2 px-4 border-b">Descripción Larga</th>
                <th class="py-2 px-4 border-b">Estatus</th>
                <th class="py-2 px-4 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $producto->nombre }}</td>
                    <td class="py-2 px-4 border-b">{{ $producto->categoria->nombre_categoria }}</td>
                    <td class="py-2 px-4 border-b">{{ $producto->precio_venta }}</td>
                    <td class="py-2 px-4 border-b">{{ $producto->precio_compra }}</td>
                    <td class="py-2 px-4 border-b">{{ $producto->cantidad }}</td>
                    <td class="py-2 px-4 border-b">{{ $producto->fecha_compra }}</td>
                    <td class="py-2 px-4 border-b">{{ $producto->color }}</td>
                    <td class="py-2 px-4 border-b">{{ $producto->descripcion_corta }}</td>
                    <td class="py-2 px-4 border-b">{{ $producto->descripcion_larga }}</td>
                    <td class="py-2 px-4 border-b">{{ $producto->estatus }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('productos.edit', $producto->id_producto) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Editar</a>
                        <form id="button-borrar-{{ $producto->id_producto }}" method="POST" action="{{ route('productos.destroy', $producto->id_producto) }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmar({{ $producto->id_producto }}, '{{ $producto->nombre }}')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

<!-- Modal -->
<div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center overflow-auto hidden">
    <div class="bg-white p-2 rounded-lg shadow-lg max-h-full max-w-md w-full">
        <h2 class="text-xl font-bold mb-4">Agregar Producto</h2>
        <form method="POST" action="{{ route('productos.store') }}">
            @csrf
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" name="nombre" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Categoría</label>
                    <select name="categoria_id" id="categoria_id" class="w-full p-2 border rounded" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Precio de Venta</label>
                    <input type="number" name="precio_venta" step="0.01" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Cantidad</label>
                    <input type="number" name="cantidad" min="0" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Precio de Compra</label>
                    <input type="number" name="precio_compra" step="0.01" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Fecha de Compra</label>
                    <input type="date" name="fecha_compra" class="w-full p-2 border rounded">
                </div>

                <div>
                    <label class="block text-gray-700">Color</label>
                    <input type="text" name="color" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Descripción Corta</label>
                    <input type="text" name="descripcion_corta" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Descripción Larga</label>
                    <textarea name="descripcion_larga" class="w-full p-1 border rounded" required></textarea>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="button" onclick="document.getElementById('modal').classList.add('hidden')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancelar</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
            </div>
        </form>
    </div>
</div>

    <script>
        function confirmar(id, producto) {
            Swal.fire({
                title: 'Confirmacion!',
                text: '¿Estas seguro de eliminar el producto ['+producto+']?',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('button-borrar-' + id).submit()
                }
            });
        }
    </script>

</div>

@endsection
