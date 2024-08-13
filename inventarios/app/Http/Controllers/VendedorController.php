<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendedor;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    public function index()
    {
        $vendedor = Vendedor::all();
        
        return view('vendedor.index', compact('vendedor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
        ]);

        Vendedor::create($request->all());

        return redirect()->route('vendedor.index')->with('success', 'Vendedor creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        // Valida los datos recibidos del formulario de edición de vendedor
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
        ]);

        // Busca el vendedor por su ID y actualiza sus datos con los datos validados
        $vendedor = Vendedor::find($id);
        $vendedor->update($request->all());

        // Redirige de vuelta a la página de listado de vendedores con un mensaje de éxito
        return redirect()->route('vendedor.index')->with('success', 'Vendedor actualizado exitosamente');
    }

    public function destroy($id)
    {
        // Busca la venta por su ID y la elimina de la base de datos
        Vendedor::find($id)->delete();

        // Redirige de vuelta a la página de listado de ventas con un mensaje de éxito
        return redirect()->route('vendedor.index')
            ->with('success', 'Vendedor eliminado exitosamente.');
    }
    
}
