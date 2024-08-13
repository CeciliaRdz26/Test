<?php

namespace App\Http\Controllers;

use App\Models\Cliente; // Importa el modelo Cliente
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Muestra todos los clientes
    public function index()
    {
        $clientes = Cliente::all(); // Obtiene todos los clientes desde la base de datos
        return view('clientes.index', compact('clientes')); // Retorna la vista 'clientes.index' con los clientes
    }

    // Muestra el formulario para crear un nuevo cliente
    public function create()
    {
        return view('clientes.create'); // Retorna la vista 'clientes.create' para crear un nuevo cliente
    }

    // Almacena un nuevo cliente en la base de datos
    public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email',
            'telefono' => 'required',
            'direccion' => 'required',
            'rfc' => 'required',
        ]);

        // Crea un nuevo cliente con los datos del formulario
        Cliente::create($request->all());

        // Redirige a la lista de clientes con un mensaje de éxito
        return redirect()->route('clientes.index')
                        ->with('success', 'Cliente creado exitosamente.');
    }

    // Muestra los detalles de un cliente específico
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente')); // Retorna la vista 'clientes.show' con los detalles del cliente
    }

    // Muestra el formulario para editar un cliente
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente')); // Retorna la vista 'clientes.edit' para editar un cliente
    }

    // Actualiza los datos de un cliente en la base de datos
    public function update(Request $request, Cliente $cliente)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email',
            'telefono' => 'required',
            'direccion' => 'required',
            'rfc' => 'required',
            'razon_social' => 'required',
            'codigo_postal' => 'required',
            'regimen_fiscal' => 'required',
        ]);

        // Actualiza los datos del cliente con los datos del formulario
        $cliente->update($request->all());

        // Redirige a la lista de clientes con un mensaje de éxito
        return redirect()->route('clientes.index')
                        ->with('success', 'Cliente actualizado exitosamente.');
    }

    // Elimina un cliente de la base de datos
    public function destroy(Cliente $cliente)
    {
        $cliente->delete(); // Elimina el cliente

        // Redirige a la lista de clientes con un mensaje de éxito
        return redirect()->route('clientes.index')
                        ->with('success', 'Cliente eliminado exitosamente.');
    }
}
