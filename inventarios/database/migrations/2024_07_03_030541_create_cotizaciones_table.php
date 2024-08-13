<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cotizaciones')) {
            Schema::create('cotizaciones', function (Blueprint $table) {
                $table->id('id_cotizaciones');
                $table->foreignId('id_cliente')->constrained('clientes', 'id_cliente')->onDelete('cascade');
                $table->date('fecha_cot');
                $table->date('vigencia');
                $table->text('comentarios')->nullable();
                $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizaciones');
    }
};
