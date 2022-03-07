<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');

            // Creamos la llave foranea con la table de equipos (1:N).
            $table->unsignedBigInteger('equipment_id')->nullable();
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');

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
        Schema::dropIfExists('equipment_images');
    }
}



// // Creamos la llave foranea con la table de equipos (1:N).
// $table->unsignedBigInteger('equipment_id')->nullable();
// $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');

// // Creamos la llave foranea con la table de contenedores (1:N).
// $table->unsignedBigInteger('container_id')->nullable();
// $table->foreign('container_id')->references('id')->on('containers')->onDelete('cascade');

// // Creamos la llave foranea con la table de unidades (1:N).
// $table->unsignedBigInteger('unit_id')->nullable();
// $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');