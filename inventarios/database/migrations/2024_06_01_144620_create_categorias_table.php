<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTable extends Migration
{
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre_categoria');
            $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    public function down()
    {   
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('categorias');
        Schema::enableForeignKeyConstraints();
    }
}
