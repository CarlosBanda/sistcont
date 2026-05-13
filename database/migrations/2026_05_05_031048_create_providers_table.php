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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name_comercial');
            $table->string('rfc')->unique();
            $table->string('razon_social');
            $table->string('status')->default('ACTIVO');
            $table->string('cp');
            $table->string('ciudad');
            $table->string('num_ext');
            $table->string('municipio');
            $table->string('colonia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
