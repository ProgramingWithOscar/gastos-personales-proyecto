<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientosGastosModel extends Model
{

    public $table = 'movimientos_finanzas_gastos';
    
    public $fillable = [
        'fecha',
        'descripcion',
        'categoria_id',
        'cuenta_id',
        'monto',
        'compañia_id',
        'periocidad',
        'gasto_pago',
        'plazo_max_pago',
    ];

}

