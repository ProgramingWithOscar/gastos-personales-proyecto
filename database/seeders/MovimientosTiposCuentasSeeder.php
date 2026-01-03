<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MovimientosTiposCuentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $tipos = [
            [
                'nombre' => 'Efectivo',
                'descripcion' => 'Dinero en efectivo',
                'estado' => true
            ],
            [
                'nombre' => 'Cuenta de Ahorros',
                'descripcion' => 'Cuenta bancaria de ahorros',
                'estado' => true
            ],
            [
                'nombre' => 'Cuenta Corriente',
                'descripcion' => 'Cuenta bancaria corriente',
                'estado' => true
            ],
            [
                'nombre' => 'Tarjeta de Crédito',
                'descripcion' => 'Tarjeta de crédito bancaria',
                'estado' => true
            ],
            [
                'nombre' => 'Tarjeta Débito',
                'descripcion' => 'Tarjeta de débito bancaria',
                'estado' => true
            ],
            [
                'nombre' => 'Billetera Digital',
                'descripcion' => 'Nequi, Daviplata, etc.',
                'estado' => true
            ],
        ];

        DB::table('movimientos_tipos_cuentas')->insert($tipos);
    }
}