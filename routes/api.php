<?php

use App\Http\Controllers\MovimientosGastosController;
use App\Http\Controllers\MovimientosIngresosController;
use Illuminate\Support\Facades\Route;

Route::prefix('movimientos')->group(function () {

    Route::apiResource('gastos', MovimientosGastosController::class);
    Route::apiResource('ingresos', MovimientosIngresosController::class);

});
