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
        Schema::create('proyecto_cotizacion_comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_cotizacion_id')
                ->constrained('proyecto_cotizaciones')
                ->cascadeOnDelete();

            $table->foreignId('user_id')->constrained('users');
            $table->text('comentario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_cotizacion_comentarios');
    }
};
