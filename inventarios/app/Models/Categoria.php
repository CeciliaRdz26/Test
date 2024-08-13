<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'nombre_categoria',
    ];
    
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}
