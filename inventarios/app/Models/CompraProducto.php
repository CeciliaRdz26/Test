<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraProducto extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'compras_productos';

    protected $fillable = [
        'id_compra',
        'id_producto',
        'cantidad',
        'precio_venta',
        'subtotal',
        'iva',
        'total',
        'estatus',
    ];

    public function compra()
    {
        return $this->belongsTo(Producto::class, 'id_compra');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
