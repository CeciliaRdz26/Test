@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Editar Categoría</h1>
    <form method="POST" action="{{ route('categorias.update', $categoria) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">Nombre</label>
            <input type="text" name="nombre_categoria" value="{{ $categoria->nombre_categoria }}" class="w-full p-2 border rounded" required>
        </div>
        <div class="flex justify-end mt-4">
            <a href="{{ route('categorias.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancelar</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
        </div>
    </form>
</div>
@endsection
