<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->integer('year')->nullable();
            $table->bigInteger('price');
            $table->string('color')->nullable();
            $table->string('transmission');
            $table->string('fuel')->nullable();
            $table->string('engine_capacity')->nullable();
            $table->string('passenger_capacity')->nullable();
            $table->integer('mileage')->nullable();
            $table->string('condition')->default('Baru');
            $table->text('description')->nullable();
            $table->text('image')->nullable(); // Foto Utama
            $table->json('gallery')->nullable(); // Foto Galeri (Array)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};