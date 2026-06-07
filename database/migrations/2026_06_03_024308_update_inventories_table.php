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
        Schema::table('inventories', function (Blueprint $table) {

            // Eliminar cantidad
            $table->dropColumn('cantidad');

            // Hacer único el número de serie
            $table->unique('numero_serie');

            // Agregar estatus
            $table->enum('estatus', [
                'disponible',
                'vendido',
                'apartado',
                'garantia',
                'baja'
            ])->default('disponible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {

            // Eliminar índice único
            $table->dropUnique(['numero_serie']);

            // Eliminar estatus
            $table->dropColumn('estatus');

            // Restaurar cantidad
            $table->integer('cantidad')->default(0);
        });
    }
};