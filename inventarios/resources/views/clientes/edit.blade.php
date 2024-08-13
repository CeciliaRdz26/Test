@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Editar Cliente</h1>
        <form method="POST" action="{{ route('clientes.update', $cliente->id_cliente) }}">

            @csrf
            @method('PUT')
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" name="nombre" value="{{ $cliente->nombre }}" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Correo</label>
                    <input type="text" name="correo" value="{{ $cliente->correo }}" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Telefono</label>
                    <input type="text" name="telefono" value="{{ $cliente->telefono }}" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Direccion</label>
                    <input type="text" name="direccion" value="{{ $cliente->direccion }}" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">RFC</label>
                    <input type="text" name="rfc" value="{{ $cliente->rfc }}" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Razon social</label>
                    <input type="text" name="razon_social" value="{{ $cliente->razon_social }}" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Codigo postal</label>
                    <input type="text" name="codigo_postal" value="{{ $cliente->codigo_postal }}" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Regimen fiscal</label>
                    <input type="text" name="regimen_fiscal" value="{{ $cliente->regimen_fiscal }}" class="w-full p-2 border rounded" required>
                </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
            </div>
        </form>
</div>
@endsection
