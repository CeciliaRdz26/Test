@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Editar vendedor</h1>
    <form method="POST" action="{{ route('vendedor.update', $persona) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">Tipo</label>
            <input type="text" name="nombre" value="{{ $persona->nombre }}" class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tipo</label>
            <input type="text" name="correo" value="{{ $persona->correo }}" class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tipo</label>
            <input type="text" name="telefono" value="{{ $persona->telefono }}" class="w-full p-2 border rounded" required>
        </div>
        <div class="flex justify-end mt-4">
            <a href="{{ route('vendedor.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancelar</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
        </div>
    </form>
</div>
@endsection
