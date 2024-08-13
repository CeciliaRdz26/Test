<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('ventas')) {
            Schema::create('ventas', function (Blueprint $table) {
                $table->id('id_venta');
                $table->foreignId('categoria_id')->constrained('categorias', 'id_categoria')->onDelete('cascade');
                $table->foreignId('cliente_id')->constrained('clientes', 'id_cliente')->onDelete('cascade');
                $table->foreignId('pago_id')->constrained('formasdepago', 'id')->onDelete('cascade');
                $table->foreignId('vendedor_id')->constrained('vendedor', 'id')->onDelete('cascade');
                $table->date('fecha_venta');
                $table->double('subtotal');
                $table->double('iva');
                $table->double('total');
                $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('ventas');
        Schema::enableForeignKeyConstraints();
    }
}
