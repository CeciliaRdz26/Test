<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedor = Proveedor::all();
        
        return view('proveedor.index', compact('proveedor'));
    }

    public function store(Request $request)
    {

        // Valida los datos recibidos desde el formulario de creación de ventas
        $request->validate([
            'nombre' => 'required',
            'nombre_contacto' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
        ]);

        // Crea un nuevo vendedor con los datos recibidos y lo guarda en la base de datos
        Proveedor::create($request->all());

        return redirect()->route('proveedor.index')->with('success', 'Proveedor creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        // Valida los datos recibidos desde el formulario de edición de ventas
        $request->validate([
            'nombre' => 'required',
            'nombre_contacto' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
        ]);

        // Busca el vendedor por su ID y actualiza sus datos con los nuevos datos recibidos
        $proveedor = Proveedor::find($id);
        $proveedor->update($request->all());

        // Redirige de vuelta a la página de listado de ventas con un mensaje de éxito
        return redirect()->route('proveedor.index')->with('success', 'Proveedor actualizado exitosamente');
    }

    public function destroy($id)
    {
        // Busca la venta por su ID y la elimina de la base de datos
        Proveedor::find($id)->delete();

        // Redirige de vuelta a la página de listado de ventas con un mensaje de éxito
        return redirect()->route('proveedor.index')
            ->with('success', 'Proveedor eliminado exitosamente.');
    }
}
