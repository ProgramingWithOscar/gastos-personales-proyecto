<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientosCompaniasModel extends Model
{

    public $table = 'movimientos_companias';
    
    public $fillable = [
        'nombre',
        'descripcion'
    ];

}

