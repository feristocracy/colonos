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
        Schema::create('proyecto_nota_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_nota_id')->constrained('proyecto_notas')->cascadeOnDelete();
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
        Schema::dropIfExists('proyecto_nota_archivos');
    }
};
