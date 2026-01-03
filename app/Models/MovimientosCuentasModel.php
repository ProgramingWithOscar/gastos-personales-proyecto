<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientosCuentasModel extends Model
{

    public $table = 'movimientos_cuentas';
    
    public $fillable = [
        'nombre',
        'descripcion',
        'tipo_cuenta_id',
        'estado'
    ];

}

