<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CrudTrait;
use App\Models\MovimientosIngresosModel;
use Illuminate\Http\Request;

class MovimientosIngresosController extends Controller
{
    // IMPORTANTE : Definir las rules (formRequest) para validaciones
    
    use CrudTrait;

    protected $model = MovimientosIngresosModel::class;


}