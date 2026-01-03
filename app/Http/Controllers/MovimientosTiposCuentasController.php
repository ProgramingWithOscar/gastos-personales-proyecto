<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CrudTrait;
use App\Models\MovimientosTiposCuentasModel;

class MovimientosTiposCuentasController extends Controller
{
    // IMPORTANTE : Definir las rules (formRequest) para validaciones
    
    use CrudTrait;

    protected $model = MovimientosTiposCuentasModel::class;


}