<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MovimientosCuentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $cuentas = [
            [
                'nombre' => 'Efectivo Principal',
                'descripcion' => 'Dinero en efectivo diario',
                'tipo_cuenta_id' => 1, // Efectivo
                'estado' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre' => 'Bancolombia Ahorros',
                'descripcion' => 'Cuenta de ahorros Bancolombia',
                'tipo_cuenta_id' => 2, // Cuenta de Ahorros
                'estado' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre' => 'Davivienda Corriente',
                'descripcion' => 'Cuenta corriente Davivienda',
                'tipo_cuenta_id' => 3, // Cuenta Corriente
                'estado' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre' => 'Visa Bancolombia',
                'descripcion' => 'Tarjeta de crédito Visa',
                'tipo_cuenta_id' => 4, // Tarjeta de Crédito
                'estado' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre' => 'Nequi',
                'descripcion' => 'Billetera digital Nequi',
                'tipo_cuenta_id' => 6, // Billetera Digital
                'estado' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('movimientos_cuentas')->insert($cuentas);
    }
}