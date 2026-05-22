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
        Schema::create('inventories', function (Blueprint $table) {

            $table->id();

            $table->foreignId('product_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('numero_serie')->nullable();

            $table->string('codigo_barras')->nullable();

            $table->integer('garantia')->default(0);

            $table->integer('cantidad')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};