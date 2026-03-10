<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('colonos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('direccion');
            $table->string('correo')->nullable();
            $table->string('telefono', 30)->nullable();
            $table->boolean('al_corriente')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colonos');
    }
};
