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
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100);
            $table->string('RUC', 20)->unique();
            $table->string('telefono',20);
            $table->string('email', 100);
            $table->string('direccion', 100);
            $table->string('Industria', 100);
            $table->string('representante_legal');
            $table->date('fecha_fundacion');
            $table->string('moneda', 3)->default('USD')->comment('Código ISO de la moneda: USD, MXN, EUR, etc.');
            $table->text('descripcion_de_la_empresa');
            $table->string('imagen')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};
