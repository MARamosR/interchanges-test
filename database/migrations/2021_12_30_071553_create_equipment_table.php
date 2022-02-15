<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {   
            $table->id();
            $table->text('nombre');
            $table->text('descripcion');
            $table->text('ubicacion'); //Esto se cambiara en cada escala por la ubicacion de la escala 
            $table->float('precio_unitario');
            $table->integer('activo'); // 1 = Activo (ocupado), 0 disponible para rutas y 2 = EXTRAVIADO    
            $table->text('folio');
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
        Schema::dropIfExists('equipment');
    }
}
