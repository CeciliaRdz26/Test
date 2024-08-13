@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Ver Cliente</h1>
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" disabled name="nombre" value="{{ $cliente->nombre }}" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Correo</label>
                    <input type="text" disabled name="correo" value="{{ $cliente->correo }}" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Telefono</label>
                    <input type="text" disabled name="telefono" value="{{ $cliente->telefono }}" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Direccion</label>
                    <input type="text" disabled name="direccion" value="{{ $cliente->direccion }}" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">RFC</label>
                    <input type="text" disabled name="rfc" value="{{ $cliente->rfc }}" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Razon social</label>
                    <input type="text" disabled name="razon_social" value="{{ $cliente->razon_social }}" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Codigo postal</label>
                    <input type="text" disabled name="codigo_postal" value="{{ $cliente->codigo_postal }}" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-gray-700">Regimen fiscal</label>
                    <input type="text" disabled name="regimen_fiscal" value="{{ $cliente->regimen_fiscal }}" class="w-full p-2 border rounded">
                </div>
</div>
@endsection
