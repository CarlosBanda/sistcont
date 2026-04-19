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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('rfc', 13);
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('tax_regime', 5);
            $table->string('cfdi_use', 5)->nullable();
            $table->string('zip_code', 10);
            $table->text('address')->nullable();
            $table->string('colony');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('MX');
            $table->string('number_ext')->nullable();
            $table->string('number_int')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
