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
        Schema::create('ticket_archivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_original');
            $table->string('ruta'); 
            $table->foreignId('ticket_id')->nullable()->constrained('tickets');
            $table->foreignId('ticket_historial_id')->nullable()->constrained('ticket_historial');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_archivos');
    }
};
