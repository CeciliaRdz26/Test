<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_inventario';

    protected $fillable = [
        'producto_id',
        'categoria_id',
        'fecha_entrada',
        'fecha_venta',
        'fecha_salida',
        'motivo',
        'movimiento',
        'cantidad',
    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
