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
        Schema::create('tecnicos', function (Blueprint $table) {
            $table->id();
            $table->string('staff_id')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('name');
            $table->string('email')->unique();
            $table->bigInteger('dni')->nullable();
            $table->string('direccion')->nullable();
            $table->string('phone')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tecnicos');
    }
};
