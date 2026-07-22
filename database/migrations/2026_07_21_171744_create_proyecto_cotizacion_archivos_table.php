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
        Schema::create('proyecto_cotizacion_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_cotizacion_id')
                ->constrained('proyecto_cotizaciones')
                ->cascadeOnDelete();

            $table->string('archivo');
            $table->string('nombre_original');
            $table->string('mime_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_cotizacion_archivos');
    }
};
