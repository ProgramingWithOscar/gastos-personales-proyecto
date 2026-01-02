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
        Schema::create('movimientos_categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable()->comment("Nombre del categoría");
            $table->string('descripcion')->nullable()->comment("Descripción del categoría");
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_categorias');

    }
};
