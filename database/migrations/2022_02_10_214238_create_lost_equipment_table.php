<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLostEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lost_equipment', function (Blueprint $table) {
            $table->id();   
            $table->unsignedBigInteger('id_route')->nullable();
            $table->foreign('id_route')->references('id')->on('routes')->onDelete('cascade');
            $table->unsignedBigInteger('id_equipment')->nullable();
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
        Schema::dropIfExists('lost_equipment');
    }
}
