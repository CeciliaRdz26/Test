@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Editar tipo de pagos</h1>
    <form method="POST" action="{{ route('formasdepago.update', $tipo_pago) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">Tipo</label>
            <input type="text" name="tipo" value="{{ $tipo_pago->tipo }}" class="w-full p-2 border rounded" required>
        </div>
        <div class="flex justify-end mt-4">
            <a href="{{ route('formasdepago.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancelar</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
        </div>
    </form>
</div>
@endsection
