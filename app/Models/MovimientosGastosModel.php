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
        'compania_id',
        'periodicidad',
        'gasto_pago',
        'plazo_max_pago',
    ];

    public function categoria()
    {
        return $this->belongsTo(MovimientosCategoriasModel::class, 'categoria_id');
    }

    public function cuenta()
    {
        return $this->belongsTo(MovimientosCuentasModel::class, 'cuenta_id');
    }

    public function compañia()
    {
        return $this->belongsTo(MovimientosCompaniasModel::class, 'compañia_id');
    }
}