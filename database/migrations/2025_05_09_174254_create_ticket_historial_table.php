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
        Schema::create('ticket_historial', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets');
            $table->foreignId('usuario_id')->constrained('users'); // quien hizo la acción
            $table->foreignId('from_area_id')->nullable()->constrained('areas');
            $table->foreignId('to_area_id')->nullable()->constrained('areas');
            $table->foreignId('asignado_a')->nullable()->constrained('users');
            $table->foreignId('estado_id')->constrained('estados');
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_historial');
    }
};
