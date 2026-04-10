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
        Schema::create('movimientos_financieros', function (Blueprint $table) {
            $table->id();

            $table->enum('tipo', ['ingreso', 'egreso']);
            $table->date('fecha');
            $table->decimal('monto', 12, 2);

            $table->string('categoria')->nullable();
            $table->string('concepto');
            $table->text('comentarios')->nullable();

            $table->string('comprobante_path')->nullable();

            $table->enum('origen', ['manual', 'pago_colono'])->default('manual');

            $table->unsignedBigInteger('pago_id')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['fecha', 'tipo']);
            $table->index('origen');
            $table->index('pago_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_financieros');
    }
};
