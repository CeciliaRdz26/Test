<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required',
        ]);

        Categoria::create($request->all());
        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_categoria' => 'required',
            'estatus' => 'required',
        ]);

        
        Categoria::where('id_categoria', $id)->update([
            'nombre_categoria' => $request->nombre_categoria, 'estatus' => $request->estatus
        ]);
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy($id)
    {
        Categoria::where('id_categoria', $id)->update(['estatus' => 'Inactivo']);
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente');
    }
}
