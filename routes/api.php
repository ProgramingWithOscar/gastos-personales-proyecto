<?php

use App\Http\Controllers\MovimientosCategoriasController;
use App\Http\Controllers\MovimientosCompaniasController;
use App\Http\Controllers\MovimientosCuentasController;
use App\Http\Controllers\MovimientosGastosController;
use App\Http\Controllers\MovimientosIngresosController;
use App\Http\Controllers\MovimientosTiposCuentasController;
use Illuminate\Support\Facades\Route;

Route::prefix('movimientos')->group(function () {

    Route::apiResource('gastos', MovimientosGastosController::class);
    Route::apiResource('ingresos', MovimientosIngresosController::class);
    Route::apiResource('categorias', MovimientosCategoriasController::class);
    Route::apiResource('companias', MovimientosCompaniasController::class);
    Route::apiResource('cuentas', MovimientosCuentasController::class);
    Route::apiResource('tipos-cuentas', MovimientosTiposCuentasController::class);
});
