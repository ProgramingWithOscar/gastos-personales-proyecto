<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientos_finanzas_ingresos', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha')->nullable()->comment("Fecha del movimiento");
            $table->string('descripcion')->nullable()->comment("Descripción del movimiento");
            $table->unsignedSmallInteger('categoria_id')->comment("Categoría del gasto");
            $table->unsignedSmallInteger('cuenta_id')->comment("Cuenta del movimiento");
            $table->decimal("monto")->comment("Monto del movimiento");
            $table->unsignedSmallInteger('compañia_id')->nullable()->comment("Compañia del movimiento, es decir,la entidad a la cual se le hará el pago");
            $table->enum('periocidad', ['mensual', 'diario', 'semestral', 'trimestral', 'anual'])->nullable()->comment("Cuenta del movimiento");
            $table->rememberToken();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_finanzas_ingresos');

    }
};
