<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CrudTrait;
use App\Models\MovimientosCategoriasModel;

class MovimientosCategoriasController extends Controller
{
    // IMPORTANTE : Definir las rules (formRequest) para validaciones
    
    use CrudTrait;

    protected $model = MovimientosCategoriasModel::class;


}