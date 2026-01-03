<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CrudTrait;
use App\Models\MovimientosGastosModel;

class MovimientosGastosController extends Controller
{
   
    // IMPORTANTE : Definir las rules (formRequest) para validaciones
    
    use CrudTrait;

    protected $model = MovimientosGastosModel::class;

    public function index()
    {
        $gastos = MovimientosGastosModel::with(['categoria', 'cuenta'])->get();

        return response()->json([
            'data' => $gastos
        ]);
    }

}