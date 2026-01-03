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
        Schema::create('movimientos_tipos_cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment("Nombre del tipo de cuenta");
            $table->string('descripcion')->nullable()->comment("Descripcion del tipo de cuenta");
            $table->boolean('estado')->comment("Estado del tipo de cuenta")->default(true);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_tipos_cuentas');

    }
};
