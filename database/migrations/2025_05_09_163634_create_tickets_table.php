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
            $table->string('external_ticket_id');
            $table->string('number')->unique();               
            $table->string('user_id');      
            $table->enum('status', ['pending', 'resolved', 'derived'])->default('pending');
            $table->string('status_id');                   
            $table->string('dept_id');                    
            $table->string('sla_id');                      
            $table->string('topic_id');                    
            $table->string('source');                         
            $table->timestamp('est_duedate')->nullable();     
            $table->string('tkt_billeteadulterado')->nullable(); 
            $table->string('subject');                        
            $table->string('priority');                       
            $table->timestamp('tkt_fhsolicitud')->nullable(); 
            $table->text('falla_reportada')->nullable();    
            $table->string('id_equipo')->nullable();          
            $table->string('serie')->nullable();             
            $table->string('activo')->nullable();
            $table->foreignId('estado_id')->constrained('estados');
            $table->foreignId('area_id')->nullable()->constrained('areas'); 
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');          
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
