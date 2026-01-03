<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientosTiposCuentasModel extends Model
{

    public $table = 'movimientos_tipos_cuentas';
    
    public $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

}

