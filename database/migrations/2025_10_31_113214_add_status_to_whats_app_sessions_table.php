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
        Schema::table('whats_app_sessions', function (Blueprint $table) {
            $table->string('status')->default('inactive'); // inactive, active, disconnected
            $table->timestamp('last_connected_at')->nullable();
            $table->boolean('is_current')->default(false); // Para marcar la sesión actual activa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whats_app_sessions', function (Blueprint $table) {
            $table->dropColumn(['status', 'last_connected_at', 'is_current']);
        });
    }
};
