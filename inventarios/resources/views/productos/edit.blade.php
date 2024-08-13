@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Editar Producto</h1>
    <form method="POST" action="{{ route('productos.update', $producto->id_producto) }}">

        @csrf
        @method('PUT')
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Nombre</label>
                <input type="text" name="nombre" value="{{ $producto->nombre }}" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Categoría</label>
                <select name="categoria_id" id="categoria_id" class="w-full p-2 border rounded" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}" {{ $categoria->id_categoria == $producto->categoria_id ? 'selected' : '' }}>{{ $categoria->nombre_categoria }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700">Precio de Venta</label>
                <input type="number" name="precio_venta" step="0.01" value="{{ $producto->precio_venta }}" class="w-full p-2 border rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Precio de Compra</label>
                <input type="number" name="precio_compra" step="0.01" value="{{ $producto->precio_compra }}" class="w-full p-2 border rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Fecha de Compra</label>
                <input type="date" name="fecha_compra" value="{{ $producto->fecha_compra }}" class="w-full p-2 border rounded">
            </div>
            <div>
                <label class="block text-gray-700">Cantidad</label>
                <input type="number" name="cantidad" min="0" value="{{ $producto->cantidad }}" class="w-full p-2 border rounded">
            </div>
            <div>
                <label class="block text-gray-700">Color</label>
                <input type="text" name="color" value="{{ $producto->color }}" class="w-full p-2 border rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Descripción Corta</label>
                <input type="text" name="descripcion_corta" value="{{ $producto->descripcion_corta }}" class="w-full p-2 border rounded" required>
            </div>
            <div>
                <label class="block text-gray-700">Descripción Larga</label>
                <textarea name="descripcion_larga" class="w-full p-1 border rounded" required>{{ $producto->descripcion_larga }}</textarea>
            </div>
            <div>
                <label class="block text-gray-700">Estatus</label>
                <select name="estatus" id="estatus" class="w-full p-2 border rounded" required>
                    <option value="Activo" {{ $producto->estatus == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ $producto->estatus == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
        </div>
    </form>
</div>
@endsection
