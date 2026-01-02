<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientosCategoriasModel extends Model
{

    public $table = 'movimientos_categorias';
    
    public $fillable = [
        'nombre',
        'descripcion'
    ];

}

