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
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('options')->onDelete('cascade');
            $table->string('group', 50);
            $table->string('label', 100);
            $table->string('value', 100);
            $table->timestamps();

            $table->index('group');
            $table->index('parent_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
