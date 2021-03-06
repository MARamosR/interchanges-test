<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operators', function (Blueprint $table) {
            $table->id();
            $table->text('nombre');
            $table->text('apellidos');
            $table->string('telefono');
            $table->text('no_licencia');
            $table->text('tipo_licencia');
            $table->date('fecha_exp');
            $table->date('fecha_venc');
            $table->text('lugar_exp');
            $table->integer('antiguedad');
            $table->text('iave');
            $table->string('folio');
            $table->integer('status');  // 1 es que esta activo (ocupado), 0 esta inactivo (disponible para las rutas).
            $table->date('ex_medico');
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
        Schema::dropIfExists('operators');
    }
}
