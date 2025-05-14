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
            // Relaciones principales
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users'); // Quien hizo la acción
            // Movimiento entre áreas (pueden ser null si no aplica)
            $table->foreignId('from_area_id')->nullable()->constrained('areas');
            $table->foreignId('to_area_id')->nullable()->constrained('areas');
            $table->foreignId('asignado_a')->nullable()->constrained('users');// Estado en el que quedó el ticket después de esta acción
            $table->foreignId('estado_id')->constrained('estados')->index();
            $table->string('accion')->nullable(); // Ejemplo: 'asignado', 'comentado', etc.
            $table->boolean('is_current')->default(true); // Marca si este historial es el más reciente
            $table->text('comentario')->nullable(); // Comentarios o detalles del movimiento
            $table->timestamp('started_at')->nullable(); // cuándo comenzó esta etapa (por defecto created_at)
            $table->timestamp('ended_at')->nullable(); // cuándo terminó (cuando se marca is_current = false)
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
