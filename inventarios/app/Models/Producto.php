<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_producto'; 
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'categoria_id',
        'precio_venta',
        'precio_compra',
        'cantidad',
        'color',
        'descripcion_corta',
        'descripcion_larga',
        'fecha_compra'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
