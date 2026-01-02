<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CrudTrait;
use App\Models\MovimientosCompaniasModel;

class MovimientosCompaniasController extends Controller
{
    // IMPORTANTE : Definir las rules (formRequest) para validaciones
    
    use CrudTrait;

    protected $model = MovimientosCompaniasModel::class;


}