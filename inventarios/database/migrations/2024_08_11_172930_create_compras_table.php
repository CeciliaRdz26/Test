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
        if (!Schema::hasTable('compras')) {
            Schema::create('compras', function (Blueprint $table) {
                $table->id('id_compra');
                //$table->unsignedBigInteger('id_proveedor');
                $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedores');
                $table->date('fecha_compra');
                $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
