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
        Schema::create('proyecto_cotizacion_conceptos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('proyecto_id')->constrained('proyectos')->cascadeOnDelete();
    $table->foreignId('creado_por')->constrained('users');
    $table->string('nombre');
    $table->text('descripcion')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_cotizacion_conceptos');
    }
};
