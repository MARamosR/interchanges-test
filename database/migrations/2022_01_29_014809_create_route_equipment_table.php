<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_equipment', function (Blueprint $table) {
            // N:N with route
            $table->unsignedBigInteger('id_ruta')->nullable();
            $table->foreign('id_ruta')->references('id')->on('routes')->onDelete('set null');

            // N:N with equipment
            $table->unsignedBigInteger('id_equipo')->nullable();
            $table->foreign('id_equipo')->references('id')->on('equipment')->onDelete('set null');

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
        Schema::dropIfExists('route_equipment');
    }
}
