<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('body_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('body_types')->insert(array_map(fn ($name) => [
            'name' => $name,
            'created_at' => now(),
            'updated_at' => now(),
        ], ['Sedan', 'SUV', 'Off-road', 'MPV', 'Hatchback', 'Coupe']));
    }

    public function down(): void
    {
        Schema::dropIfExists('body_types');
    }
};
