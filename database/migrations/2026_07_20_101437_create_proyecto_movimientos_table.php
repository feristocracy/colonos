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
        Schema::create('proyecto_movimientos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->restrictOnDelete();

            $table->foreignId('registrado_por')
                ->constrained('users')
                ->restrictOnDelete();

            $table->enum('tipo', [
                'saldo_inicial',
                'entrada',
                'salida',
            ]);

            $table->decimal('monto', 15, 2);

            $table->string('concepto');
            $table->text('descripcion')->nullable();
            $table->string('comprobante')->nullable();

            $table->timestamps();

            $table->index(['proyecto_id', 'tipo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_movimientos');
    }
};
