<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photos', function (Blueprint $table) {

            // Creamos la llave foranea con la table de equipos (1:N).
            $table->unsignedBigInteger('id_equipment')->nullable();
            $table->foreign('id_equipment')->references('id')->on('equipment')->onDelete('cascade');

            // Creamos la llave foranea con la table de contenedores (1:N).
            $table->unsignedBigInteger('id_container')->nullable();
            $table->foreign('id_container')->references('id')->on('containers')->onDelete('cascade');

            // Creamos la llave foranea con la table de unidades (1:N).
            $table->unsignedBigInteger('id_unit')->nullable();
            $table->foreign('id_unit')->references('id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn('id_equipment');
            $table->dropColumn('id_container');
            $table->dropColumn('id_unit');
        });
    }
}
