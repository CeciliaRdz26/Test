<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Models\Producto;
use App\Models\CotizacionProducto;
use GuzzleHttp\Client;

class CotizacionController extends Controller
{
    // Muestra todos las cotizaciones
    public function index()
    {
        $cotizacion = Cotizacion::all();
        $cliente = Cliente::all();
        $producto = Producto::all();
        return view('cotizaciones.index', compact('cotizacion', 'cliente', 'producto'));
    }

    // Muestra el formulario para crear una nueva cotización
    public function create()
    {
        return view('cotizaciones.create');
    }

    // Almacena una nueva cotización en la base de datos
    public function store(Request $request)
    {
        // Crear una nueva cotización
        $cotizacion = new Cotizacion();
        $cotizacion->id_cliente = $request->id_cliente;
        $cotizacion->fecha_cot = $request->fecha_cot;
        $cotizacion->vigencia = $request->vigencia;
        $cotizacion->comentarios = $request->comentario;
        $cotizacion->save();

        /*  
            'subtotal' => $subtotal,
            'iva' => 1.16,
            'total' => $subtotal*1.16
        */

        // Separar los productos y cantidades en arreglos
        $productos = explode(",", $request->productos);
        $cantidades = explode(",", $request->cantidades);

        // Crear un nuevo registro en la tabla cotizacion_producto por cada producto en la cotización
        for ($i=0; $i < count($productos); $i++) { 
            $cotizacionProducto = new CotizacionProducto();
            $cotizacionProducto->id_cotizacion = $cotizacion->id_cotizaciones;
            $cotizacionProducto->id_producto = $productos[$i];
            $cotizacionProducto->precio_venta = Producto::find($productos[$i])->precio_venta;
            $cotizacionProducto->cantidad = $cantidades[$i];
            $cotizacionProducto->subtotal = $cantidades[$i] * Producto::find($productos[$i])->precio_venta;
            $cotizacionProducto->iva = $cotizacionProducto->subtotal * 0.16;
            $cotizacionProducto->total = $cotizacionProducto->subtotal + $cotizacionProducto->iva;
            $cotizacionProducto->save();
        }

        return redirect()->route('cotizaciones.index');
    }

    // Muestra los detalles de una cotización específica
    public function show(Cotizacion $cotizacion)
    {
        return view('cotizaciones.index', compact('cotizacion'));
    }

    // Muestra el formulario para editar una cotización
    public function edit($id)
    {
        $cotizacion = Cotizacion::find($id);
        $clientes = Cliente::all();
        $productos = Producto::all();

        return view('cotizaciones.edit', compact('productos', 'cotizacion', 'clientes'));
    }

    // Actualiza los datos de una cotización en la base de datos
    public function update(Request $request, $id)
    {
        
        $cotizacion = Cotizacion::find($id);

        $cotizacion->update([
            'id_cliente' => $request->id_cliente,
            'fecha_cot' => $request->fecha_cot,
            'vigencia' => $request->vigencia,
            'comentarios' => $request->comentarios
        ]);

        $totalCampos = $request['total_campos'];
        $cotizacionproducto = CotizacionProducto::where('id_cotizacion', $id)->get();

        foreach ($cotizacionproducto as $cotizacionProduc) {

            $cotizacionProduc->update([
                'cantidad' => $request['cantidad-id-'.$cotizacionProduc->id],
            ]);

        }

        if($totalCampos){
            for ($i=0; $i < $totalCampos; $i++) {
                $cotizacionNewProducto = new CotizacionProducto();
                $cotizacionNewProducto->id_cotizacion = $id;
                $cotizacionNewProducto->id_producto = $request['producto-'.$i+1];
                $cotizacionNewProducto->precio_venta = Producto::find($request['producto-'.$i+1])->precio_venta;
                $cotizacionNewProducto->cantidad = $request['cantidad-'.$i+1];
                $cotizacionNewProducto->subtotal = $request['cantidad-'.$i+1] * Producto::find($request['producto-'.$i+1])->precio_venta;
                $cotizacionNewProducto->iva = $cotizacionNewProducto->subtotal * 0.16;
                $cotizacionNewProducto->total = $cotizacionNewProducto->subtotal + $cotizacionNewProducto->iva;
                $cotizacionNewProducto->save();
            }
        }
        
        return redirect()->route('cotizaciones.index')->with('success', 'Cotización actualizada con éxito');
    }

    // Elimina una cotización de la base de datos
    public function destroy($id)
    {
        $cotizacion = Cotizacion::find($id);

        $cotizacionProducto = CotizacionProducto::where('id_cotizacion', $id)->get();

        foreach ($cotizacionProducto as $cotizacionProduc) {
            $cotizacionProduc->delete();
        }

        $cotizacion->delete();

        return redirect()->route('cotizaciones.index')
                        ->with('success', 'Cotización eliminada con éxito');
    }
}
