<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->text('serie');
            $table->text('marca');
            $table->text('modelo');
            $table->text('placa');
            $table->text('comentario');
            $table->text('placa_mx')->nullable();
            $table->text('placa_ant')->nullable();
            $table->text('estado');
            $table->text('riel_logistico');
            $table->text('canastilla');
            $table->text('tipo_placa');
            $table->integer('status'); // 1 es que esta activo (ocupado), 0 esta inactivo (disponible para las rutas).
            $table->text('propietario');
            $table->float('ancho');
            $table->float('largo');
            $table->float('alto');
            $table->text('llanta');
            $table->text('llanta_status');
            $table->text('tipo_caja');

            //Llave foranea para relacion N a 1 con el modelo "ruta".
            // $table->unsignedBigInteger('id_ruta')->unique()->nullable();
            // $table->foreign('id_ruta')->references('id')->on('routes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('containers');
    }
}
