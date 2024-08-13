<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre');
            $table->foreignId('categoria_id')->constrained('categorias', 'id_categoria')->onDelete('cascade');
            $table->double('precio_venta');
            $table->double('precio_compra');
            $table->date('fecha_compra')->nullable();
            $table->integer('cantidad');
            $table->string('color');
            $table->string('descripcion_corta');
            $table->text('descripcion_larga');
            $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('productos');
        Schema::enableForeignKeyConstraints();
    }
}
