<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Categoria;


class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::with(['producto', 'categoria'])->get();
        $productos = Producto::all();
        $categorias = Categoria::all();
        return view('inventarios.index', compact('inventarios', 'productos', 'categorias'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required',
            'categoria_id' => 'required',
            'fecha_entrada' => 'required|date',
            'fecha_salida' => 'required|date',
            'motivo'=> 'required',
            'movimiento'=> 'required',
            'cantidad' => 'required|numeric',

        ]);

        Inventario::create($request->all());

        return redirect()->route('inventarios.index')
            ->with('success', 'Creada exitosamente.');
    }

    public function edit($id)
    {
        $inventario = Inventario::find($id);
        $productos = Producto::all();
        $categorias = Categoria::all();

        return response()->json(compact('inventario', 'productos', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'producto_id' => 'required',
            'categoria_id' => 'required',
            'fecha_entrada' => 'required|date',
            'fecha_salida' => 'required|date',
            'motivo'=> 'required',
            'movimiento'=> 'required',
            'cantidad' => 'required|numeric',
        ]);

        $inventario = Inventario::find($id);
        $inventario->update($request->all());

        return redirect()->route('inventarios.index')
            ->with('success', 'Actualizada exitosamente.');
    }

    public function destroy($id)
    {
        Inventario::find($id)->delete();

        return redirect()->route('inventarios.index')
            ->with('success', 'Eliminada exitosamente.');
    }


}
