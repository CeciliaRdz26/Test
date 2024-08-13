<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\CompraProducto;
use App\Models\Proveedor;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::all();
        $proveedor = Proveedor::all();
        $producto = Producto::all();
        return view('compras.index', compact('compras', 'proveedor', 'producto'));
    }

    public function store(Request $request){
        $compra = new Compra();
        $compra->id_proveedor = $request->id_proveedor;
        $compra->fecha_compra = $request->fecha_compra;
        $compra->save();

        $productos = explode(",", $request->productos);
        $cantidades = explode(",", $request->cantidades);


        for ($i=0; $i < count($productos); $i++) { 
            $compraProducto = new CompraProducto();
            $dataProducto = Producto::find($productos[$i]);

            $dataProducto->update([
                'cantidad' => $dataProducto->cantidad + $cantidades[$i],
            ]);

            $compraProducto->id_compra = $compra->id_compra;
            $compraProducto->id_producto = $productos[$i];
            $compraProducto->cantidad = $cantidades[$i];
            $compraProducto->precio_venta = Producto::find($productos[$i])->precio_venta;
            $compraProducto->subtotal = $cantidades[$i] * Producto::find($productos[$i])->precio_venta;
            $compraProducto->iva = $compraProducto->subtotal * 0.16;
            $compraProducto->total = $compraProducto->subtotal + $compraProducto->iva;
            $compraProducto->save();
        }

        return redirect()->route('compras.index');
    }

    public function edit($id){
        $compras = Compra::find($id);
        $proveedor = Proveedor::all();
        $productos = Producto::all();
        return view('compras.edit', compact('compras', 'proveedor', 'productos'));
    }

    public function update(Request $request, $id){
        $cotizacion = Compra::find($id);

        $cotizacion->update([
            'id_cliente' => $request->id_cliente,
            'fecha_cot' => $request->fecha_cot,
            'vigencia' => $request->vigencia,
            'comentarios' => $request->comentarios
        ]);

        $totalCampos = $request['total_campos'];
        $compraproducto = CompraProducto::where('id_compra', $id)->get();

        foreach ($compraproducto as $comprasProducto) {

            $comprasProducto->update([
                'cantidad' => $request['cantidad-id-'.$comprasProducto->id],
            ]);

        }

        if($totalCampos){
            for ($i=0; $i < $totalCampos; $i++) {
                $compraNewProducto = new CompraProducto();
                $compraNewProducto->id_compra = $id;
                $compraNewProducto->id_producto = $request['producto-'.$i+1];
                $compraNewProducto->precio_venta = Producto::find($request['producto-'.$i+1])->precio_venta;
                $compraNewProducto->cantidad = $request['cantidad-'.$i+1];
                $compraNewProducto->subtotal = $request['cantidad-'.$i+1] * Producto::find($request['producto-'.$i+1])->precio_venta;
                $compraNewProducto->iva = $compraNewProducto->subtotal * 0.16;
                $compraNewProducto->total = $compraNewProducto->subtotal + $compraNewProducto->iva;
                $compraNewProducto->save();
            }
        }
        
        return redirect()->route('compras.index')->with('success', 'Compra actualizada con éxito');
    }

    public function destroy($id){
        $compra = Compra::find($id);

        $compraProducto = CompraProducto::where('id_compra', $id)->get();

        foreach ($compraProducto as $comprasProducto) {
            $comprasProducto->delete();
        }

        $compra->delete();

        return redirect()->route('compras.index');
    }

}
