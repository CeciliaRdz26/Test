<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    /*  
            'subtotal' => $subtotal,
            'iva' => 1.16,
            'total' => $subtotal*1.16
    */

     public function up(): void
    {
        Schema::create('cotizacionproducto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cotizacion')->constrained('cotizaciones', 'id_cotizaciones')->onDelete('cascade');
            $table->foreignId('id_producto')->constrained('productos', 'id_producto')->onDelete('cascade');
            $table->double('precio_venta');
            $table->integer('cantidad');
            $table->double('subtotal');
            $table->double('iva');
            $table->double('total');
            $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacionproducto');
    }
};
