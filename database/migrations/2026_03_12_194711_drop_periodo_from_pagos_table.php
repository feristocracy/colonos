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
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropForeign(['colono_id']);
            $table->dropUnique('pagos_colono_id_periodo_unique');
            $table->dropColumn('periodo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->string('periodo', 7)->after('colono_id');
            $table->unique(['colono_id', 'periodo'], 'pagos_colono_id_periodo_unique');
        });
    }
};
