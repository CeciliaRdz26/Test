<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use App\Models\CompraProducto;
use App\Models\VentaProducto;
use App\Models\CotizacionProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{

    public function index(){
        return view('reportes.index');
    }

    public function showGraficaCompras()
    {
        $data = CompraProducto::join('productos', 'compras_productos.id_producto', '=', 'productos.id_producto')
                      ->select('productos.nombre', DB::raw('SUM(compras_productos.cantidad) as total_ingresos'))
                      ->groupBy('productos.nombre')
                      ->get();

        return response()->json($data);
    }

    public function showGraficaVentas()
    {
        $data = VentaProducto::join('productos', 'ventasproducto.id_producto', '=', 'productos.id_producto')
                      ->select('productos.nombre', DB::raw('SUM(ventasproducto.cantidad) as total_ingresos'))
                      ->groupBy('productos.nombre')
                      ->get();

        return response()->json($data);
    }

    public function report($id)
    {

        $pdf = app('dompdf.wrapper');

        $total = 0;
        $subtotal = 0;
        $iva = 0;

        $cotizacion = Cotizacion::find($id);
        $cotizacionProducto = CotizacionProducto::where('id_cotizacion', $cotizacion->id_cotizaciones)->get();
        $estilos = '<style>body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; display: flex; justify-content: center; } .ticket { background-color: #fff; padding: 30px; width: 600px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); } .ticket-header { text-align: center; margin-bottom: 30px; } .ticket-header h1 { margin: 0; font-size: 32px; } .ticket-header p { margin: 0; font-size: 16px; color: #666; } .ticket-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; } .ticket-table th, .ticket-table td { border: 1px solid #ccc; padding: 12px; text-align: left; font-size: 18px; } .ticket-table th { background-color: #f9f9f9; } .ticket-footer { text-align: right; } .ticket-footer p { margin: 0; font-size: 18px; }</style>';
        $cuerpo = $estilos . '<div class="ticket">';

        $cuerpo .= '<div class="ticket-header">';
        $cuerpo .= '<h1><strong>Nombre del cliente:</strong> ' . $cotizacion->cliente->nombre . ' </h1>';
        $cuerpo .= '<p><strong>Fecha de cotización:</strong> ' . $cotizacion->fecha_cot . '</p>';
        $cuerpo .= '<p><strong>Fecha de vigencia:</strong> ' . $cotizacion->vigencia . ' </p>';
        $cuerpo .= '<p><strong>Comentarios:</strong> ' . $cotizacion->comentarios . ' </p>';
        $cuerpo .= '</div>';

        $cuerpo .= '<table class="ticket-table">';
        $cuerpo .= '<thead> <tr> <th>Producto</th> <th>Cantidad</th> <th>Precio</th> <th>Total</th> </tr> </thead> <tbody>';
        foreach ($cotizacionProducto as $cotizacionProduc) {
            $cuerpo .= '<tr>';
            $cuerpo .= '<td>' . $cotizacionProduc->producto->nombre . '</td>';
            $cuerpo .= '<td>' . $cotizacionProduc->cantidad . '</td>';
            $cuerpo .= '<td>$' . $cotizacionProduc->precio_venta . '</td>';
            $cuerpo .= '<td>$' . $cotizacionProduc->precio_venta * $cotizacionProduc->cantidad . '</td>';
            $cuerpo .= '</tr>';
            $total += $cotizacionProduc->total;
            $subtotal += $cotizacionProduc->subtotal;
            $iva = $subtotal * 0.16;
        }
        $cuerpo .= '</tbody> </table>';

        $cuerpo .= '<div class="ticket-footer">';
        $cuerpo .= '<p>Subtotal: $'. $subtotal .'</p>';
        $cuerpo .= '<p>IVA(16%): $'. $iva .'</p>';
        $cuerpo .= '<p>Total: $'. $total .'</p>';
        $cuerpo .= '</div>';

        $cuerpo .= '</div>';
        $pdf->loadHTML($cuerpo);

        $nombre = "Cotización de ". $cotizacion->cliente->nombre;
        return $pdf->download( $nombre.'.pdf');
    }
}
