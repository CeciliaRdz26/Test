<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_cotizaciones';
    protected $table = 'cotizaciones';

    protected $fillable = [
        'id_producto',
        'id_cliente',
        'fecha_cot',
        'vigencia',
        'comentarios',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
