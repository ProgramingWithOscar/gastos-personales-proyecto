<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MovimientosCategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            // Gastos básicos
            ['nombre' => 'Alimentación', 'descripcion' => 'Supermercado, restaurantes, comida'],
            ['nombre' => 'Vivienda', 'descripcion' => 'Alquiler, hipoteca, mantenimiento'],
            ['nombre' => 'Servicios', 'descripcion' => 'Luz, agua, gas, internet, teléfono'],
            ['nombre' => 'Transporte', 'descripcion' => 'Gasolina, transporte público, taxi, Uber'],
            
            // Gastos personales
            ['nombre' => 'Salud', 'descripcion' => 'Médico, medicinas, seguro médico'],
            ['nombre' => 'Educación', 'descripcion' => 'Cursos, libros, matrícula'],
            ['nombre' => 'Ropa y Calzado', 'descripcion' => 'Vestuario y accesorios'],
            ['nombre' => 'Cuidado Personal', 'descripcion' => 'Peluquería, cosméticos, higiene'],
            
            // Entretenimiento
            ['nombre' => 'Entretenimiento', 'descripcion' => 'Cine, streaming, videojuegos, hobbies'],
            ['nombre' => 'Deportes', 'descripcion' => 'Gimnasio, actividades deportivas'],
            ['nombre' => 'Viajes', 'descripcion' => 'Vacaciones, turismo, hoteles'],
            
            // Tecnología
            ['nombre' => 'Tecnología', 'descripcion' => 'Dispositivos electrónicos, software, apps'],
            ['nombre' => 'Suscripciones', 'descripcion' => 'Netflix, Spotify, servicios online'],
            
            // Gastos varios
            ['nombre' => 'Mascotas', 'descripcion' => 'Alimento, veterinario, accesorios'],
            ['nombre' => 'Regalos', 'descripcion' => 'Cumpleaños, celebraciones'],
            ['nombre' => 'Donaciones', 'descripcion' => 'Caridad, contribuciones'],
            ['nombre' => 'Seguros', 'descripcion' => 'Seguro de vida, auto, hogar'],
            ['nombre' => 'Impuestos', 'descripcion' => 'Declaraciones, multas, tasas'],
            
            // Otros
            ['nombre' => 'Inversiones', 'descripcion' => 'Acciones, fondos, ahorros'],
            ['nombre' => 'Deudas', 'descripcion' => 'Préstamos, tarjetas de crédito'],
            ['nombre' => 'Otros', 'descripcion' => 'Gastos no categorizados'],
        ];

        $now = Carbon::now();

        foreach ($categorias as $categoria) {
            DB::table('movimientos_categorias')->insert([
                'nombre' => $categoria['nombre'],
                'descripcion' => $categoria['descripcion'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}