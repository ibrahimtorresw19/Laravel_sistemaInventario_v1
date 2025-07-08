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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
             $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('codigo_barras')->nullable()->unique();
            $table->string('codigo_interno')->unique();
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->integer('stock')->default(0);
            $table->integer('stock_minimo')->default(0);
            $table->foreignId('categoria_id')->constrained()->onDelete('restrict');
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('restrict');
            $table->string('unidad_medida');
            $table->boolean('activo')->default(true);
            $table->string('imagen')->nullable();
          $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('fecha_ultima_venta')->nullable();
            $table->date('fecha_caducidad')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
