<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_compra';
    protected $table = 'compras';

    protected $fillable = [
        'id_proveedor',
        'fecha_compra',
        'estatus',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }
}
