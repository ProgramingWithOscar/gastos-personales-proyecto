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
        Schema::create('movimientos_companias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable()->comment("Nombre del compañía");
            $table->string('descripcion')->nullable()->comment("Descripción del compañía");
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_companias');

    }
};
