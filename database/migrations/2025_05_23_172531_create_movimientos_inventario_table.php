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
        Schema::create('movimiento_de_inventario', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['entrada', 'salida', 'ajuste']);
            $table->integer('cantidad');
            $table->foreignId('producto_id')->constrained()->onDelete('restrict');
            $table->foreignId('almacen_id')->nullable()->constrained('almacenes')->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('responsable')->nullable();
            $table->text('motivo')->nullable();
            $table->date('fecha_movimiento');
            $table->dateTime('fecha_registro')->useCurrent();
            $table->timestamps();
            $table->softDeletes();

            $table->index('fecha_movimiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_de_inventario');
    }
};
