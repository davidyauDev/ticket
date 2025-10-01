<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('call_logs', function (Blueprint $table) {
            // Elimina la clave foránea existente (ajusta el nombre si es diferente)
            $table->dropForeign(['tecnico_id']);
            // Crea la nueva clave foránea apuntando a tecnicos
            $table->foreign('tecnico_id')->references('id')->on('tecnicos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('call_logs', function (Blueprint $table) {
            $table->dropForeign(['tecnico_id']);
            // Restaura la relación con users
            $table->foreign('tecnico_id')->references('id')->on('users')->onDelete('set null');
        });
    }
};
