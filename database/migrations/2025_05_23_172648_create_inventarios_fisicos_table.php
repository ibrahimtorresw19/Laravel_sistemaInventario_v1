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
        Schema::create('inventarios_fisicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('observaciones')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->enum('estado', ['planificado', 'en_progreso', 'completado', 'cancelado'])->default('planificado');
             $table->string('encargado');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
             $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios_fisicos');
    }
};
