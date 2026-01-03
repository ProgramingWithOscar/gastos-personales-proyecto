<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MovimientosCompaniasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $companias = [
            [
                'nombre' => 'Éxito',
                'descripcion' => 'Supermercado',
            ],
            [
                'nombre' => 'Carulla',
                'descripcion' => 'Supermercado',
            ],
            [
                'nombre' => 'Falabella',
                'descripcion' => 'Tienda por departamentos',
            ],
            [
                'nombre' => 'Netflix',
                'descripcion' => 'Servicio de streaming',
            ],
            [
                'nombre' => 'Claro',
                'descripcion' => 'Servicio de telecomunicaciones',
            ],
            [
                'nombre' => 'EPM',
                'descripcion' => 'Servicios públicos',
            ],
            [
                'nombre' => 'Rappi',
                'descripcion' => 'Servicio de domicilios',
            ],
            [
                'nombre' => 'Uber',
                'descripcion' => 'Servicio de transporte',
            ],
            [
                'nombre' => 'Amazon',
                'descripcion' => 'Tienda online',
            ],
            [
                'nombre' => 'Farmacia',
                'descripcion' => 'Medicamentos y salud',
            ],
        ];

        DB::table('movimientos_companias')->insert($companias);
    }
}