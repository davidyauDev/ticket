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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('codigo'); 
            $table->string('asunto');
            $table->text('falla_reportada');
            $table->enum('tipo', ['ticket', 'consulta'])->default('ticket');

            $table->string('tecnico_dni');
            $table->string('tecnico_nombres');
            $table->string('tecnico_apellidos');

            $table->text('comentario')->nullable();
            $table->text('observacion')->nullable();

            $table->foreignId('equipo_id')->constrained('equipos');
            $table->foreignId('agencia_id')->constrained();
            $table->foreignId('area_id')->nullable()->constrained('areas');
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('estado_id')->constrained('estados');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
