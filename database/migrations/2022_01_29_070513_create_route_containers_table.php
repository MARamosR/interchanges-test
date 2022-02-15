<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_containers', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ruta')->nullable();
            $table->foreign('id_ruta')->references('id')->on('routes')->onDelete('set null');

            $table->unsignedBigInteger('id_contenedor')->nullable();
            $table->foreign('id_contenedor')->references('id')->on('containers')->onDelete('set null');

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
        Schema::dropIfExists('route_containers');
    }
}
