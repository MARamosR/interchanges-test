<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment', function (Blueprint $table) {

            //Llave foranea para relacion 1 a 1 con el modelo "Proveedor".
            $table->unsignedBigInteger('id_proveedor')->nullable();
            $table->foreign('id_proveedor')->references('id')->on('providers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn('id_proveedor');
            $table->dropColumn('id_contenedor');
        });
    }
}
