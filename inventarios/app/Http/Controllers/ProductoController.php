<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Categoria;

class ProductoController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        $productos = Producto::all();
        return view('productos.index', compact('productos', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required',
            'precio_venta' => 'required|numeric',
            'precio_compra' => 'required|numeric',
            'fecha_compra' => 'nullable|date',
            'cantidad' => 'required|numeric',
            'color' => 'required',
            'descripcion_corta' => 'required',
            'descripcion_larga' => 'required',
        ]);

        Producto::create($request->all());
        return redirect()->route('productos.index');
    }
    
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();

        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required',
            'precio_venta' => 'required|numeric',
            'fecha_compra' => 'nullable|date',
            'precio_compra' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'color' => 'required',
            'descripcion_corta' => 'required',
            'descripcion_larga' => 'required',
            'estatus' => 'required',
        ]);
        
        Producto::where('id_producto', $id)->update([
            'nombre' => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'precio_venta' => $request->precio_venta,
            'fecha_compra' => $request->fecha_compra,
            'precio_compra' => $request->precio_compra,
            'cantidad' => $request->cantidad,
            'color' => $request->color,
            'descripcion_corta' => $request->descripcion_corta,
            'descripcion_larga' => $request->descripcion_larga,
            'estatus' => $request->estatus,
        ]);
        
        return redirect()->route('productos.index');
    }

    public function destroy($id)
    {
        $producto = Producto::where('id_producto', $id);
        $producto->update(['estatus' => 'Inactivo']);
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente');
    }

    public function show($id)
    {
        $producto = Producto::where('categoria_id', $id)->get();
        return $producto;
    }

}
