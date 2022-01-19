<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scales', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->string('ubicacion');
            $table->date('fecha');

            $table->unsignedBigInteger('id_ruta')->nullable();
            $table->foreign('id_ruta')->references('id')->on('routes')->onDelete('set null');
            
            $table->unsignedBigInteger('id_encargado')->nullable();
            $table->foreign('id_encargado')->references('id')->on('users')->onDelete('set null');
            
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
        Schema::dropIfExists('scales');
    }
}
