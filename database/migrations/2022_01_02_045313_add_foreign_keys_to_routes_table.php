<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            // relación una ruta tiene un operador.
            $table->unsignedBigInteger('id_operador')->unique()->nullable();
            $table->foreign('id_operador')->references('id')->on('operators')->onDelete('set null');

            // relación una ruta tiene una unidad.
            $table->unsignedBigInteger('id_unidad')->unique()->nullable();
            $table->foreign('id_unidad')->references('id')->on('units')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropColumn('id_operador');
            $table->dropColumn('id_unidad');
        });
    }
}
