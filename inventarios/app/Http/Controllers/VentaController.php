<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Vendedor;
use App\Models\VentaProducto;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Muestra una lista de todas las ventas con detalles de productos, categorías y clientes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtiene todas las ventas con relaciones pre-cargadas de producto, categoría y cliente
        $ventas = Venta::with(['producto', 'categoria', 'cliente'])->get();
        
        // Obtiene todos los productos, categorías y clientes disponibles para mostrar en la vista
        $vendedores = Vendedor::all();
        $productos = Producto::all();
        $categorias = Categoria::all();
        $clientes = Cliente::all();
        $pagos = Pago::all();
        
        // Retorna la vista 'ventas.index' con datos de ventas, productos, categorías y clientes
        return view('ventas.index', compact('vendedores','ventas', 'productos', 'categorias', 'clientes', 'pagos'));
    }

    /**
     * Almacena una nueva venta en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $productos = explode(",", $request->productos);
        $cantidades = explode(",", $request->cantidades);
        $subtotal = 0;

        for ($i=0; $i < count($productos); $i++) { 
            $subtotal += Producto::find($productos[$i])->precio_venta * $cantidades[$i];
        }

        $venta = new Venta();
        $venta->categoria_id = $request->categoria_id;
        $venta->cliente_id = $request->cliente_id;
        $venta->pago_id = $request->pago_id;
        $venta->vendedor_id = $request->vendedor_id;
        $venta->fecha_venta = $request->fecha_venta;
        $venta->subtotal = $subtotal;
        $venta->iva = 1.16;
        $venta->total = $subtotal*1.16;
        $venta->save();

        for ($i=0; $i < count($productos); $i++) { 
            $cotizacionProducto = new VentaProducto();
            $cotizacionProducto->id_venta = $venta->id_venta;
            $cotizacionProducto->id_producto = $productos[$i];
            $cotizacionProducto->precio_venta = Producto::find($productos[$i])->precio_venta;

            Producto::where('id_producto', $productos[$i])->update([
                'cantidad' => Producto::find($productos[$i])->cantidad - $cantidades[$i],
            ]);

            $cotizacionProducto->cantidad = $cantidades[$i];
            $cotizacionProducto->save();
        }

        // Redirige de vuelta a la página de listado de ventas con un mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Venta creada exitosamente.');
    }

    /**
     * Muestra los datos de una venta específica para su edición.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        // Busca la venta por su ID y carga los datos de productos, categorías y clientes
        $venta = Venta::find($id);
        $vendedores = Vendedor::all();
        $productos = Producto::all();
        $categorias = Categoria::all();
        $clientes = Cliente::all();
        $pagos = Pago::all();

        // Retorna una respuesta JSON con los datos de la venta y las listas de productos, categorías y clientes
        //return response()->json(compact('venta', 'productos', 'categorias', 'clientes', 'pagos'));
        return view('ventas.edit', compact('vendedores','venta', 'productos', 'categorias', 'clientes', 'pagos'));
    }

    /**
     * Actualiza una venta existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Valida los datos recibidos del formulario de actualización de venta
        
        $venta = Venta::find($id);
        $ventaProducto = VentaProducto::where('id_venta', $id)->get();
        $subtotal = 0;
        $totalCampos = $request->totalCampos;

        foreach($ventaProducto as $item){
            $subtotal += $item->precio_venta * $request['cantidad-id-'.$item->id_producto];
            $item->update([
                'cantidad' => $request['cantidad-id-'.$item->id_producto],
            ]);
        }

        if($totalCampos){
            for ($i=0; $i < $totalCampos; $i++) {
                $ventaProductoNew = new VentaProducto();
                $ventaProductoNew->id_venta = $id;
                $ventaProductoNew->id_producto = $request['producto-'.$i+1];
                $ventaProductoNew->precio_venta = Producto::find($request['producto-'.$i+1])->precio_venta;
                $ventaProductoNew->cantidad = $request['cantidad-'.$i+1];
                $ventaProductoNew->save();
                $subtotal += Producto::find($request['producto-'.$i+1])->precio_venta * $request['cantidad-'.$i+1];
            }
        }

        $venta->update([
            'categoria_id' => $request->id_categoria,
            'cliente_id' => $request->id_cliente,
            'pago_id' => $request->id_pago,
            'vendedor_id' => $request->id_vendedor,
            'fecha_venta' => $request->fecha,
            'subtotal' => $subtotal,
            'iva' => 1.16,
            'total' => $subtotal*1.16
        ]);

        
        // Redirige de vuelta a la página de listado de ventas con un mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
    }

    /**
     * Elimina una venta específica de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Busca la venta por su ID y la elimina de la base de datos
        $venta = Venta::find($id);
        
        $ventaProducto = VentaProducto::where('id_venta', $id)->get();

        foreach ($ventaProducto as $producto) {
            $producto->delete();
        }

        $venta->delete();

        // Redirige de vuelta a la página de listado de ventas con un mensaje de éxito
        return redirect()->route('ventas.index')
            ->with('success', 'Venta eliminada exitosamente.');
    }
}

