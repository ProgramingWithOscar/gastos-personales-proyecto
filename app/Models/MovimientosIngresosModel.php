<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientosIngresosModel extends Model
{

    public $table = 'movimientos_finanzas_ingresos';
    
    public $fillable = [
        'fecha',
        'descripcion',
        'categoria_id',
        'cuenta_id',
        'monto',
        'compañia_id',
        'periocidad'
    ];

}

