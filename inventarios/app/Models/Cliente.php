<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cliente';
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'direccion',
        'rfc',
        'razon_social',
        'codigo_postal',
        'regimen_fiscal',
    ];
}
