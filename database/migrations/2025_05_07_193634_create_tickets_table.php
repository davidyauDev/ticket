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

            $table->string('external_ticket_id'); // ID externo: 45130
            $table->string('number')->unique();               // Ej: "OS0039856"

            $table->string('user_id');      // Quien registró el ticket
            $table->string('status_id');                   // Estado del ticket
            $table->string('dept_id');                     // Departamento
            $table->string('sla_id');                      // SLA
            $table->string('topic_id');                    // Tema
            $table->string('source');                         // Ej: "Phone"

            $table->timestamp('est_duedate')->nullable();     // Fecha estimada de cierre
            $table->string('tkt_billeteadulterado')->nullable(); // Ej: "1403"
            $table->string('subject');                        // Ej: "CAS_LIM_0022"
            $table->string('priority');                       // Ej: "2"

            $table->timestamp('tkt_fhsolicitud')->nullable(); // Fecha de solicitud
            $table->string('falla_reportada')->nullable();    // Ej: "INSTALACION DE MAQUINA"
            $table->string('id_equipo')->nullable();          // Puede ser vacío
            $table->string('serie')->nullable();              // Puede ser null
            $table->string('activo')->nullable();             // Ej: "Desconocido"

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
