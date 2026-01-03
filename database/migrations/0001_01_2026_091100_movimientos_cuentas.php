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
        Schema::create('movimientos_cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment("Nombre de la cuenta");
            $table->string('descripcion')->nullable()->comment("Descripcion de la cuenta");
            $table->unsignedSmallInteger('tipo_cuenta_id')->comment("Tipo de cuenta");
            $table->boolean('estado')->comment("Estado de la cuenta")->default(true);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_cuentas');

    }
};
