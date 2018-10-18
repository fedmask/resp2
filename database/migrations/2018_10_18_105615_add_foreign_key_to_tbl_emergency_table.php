<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToTblEmergencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_emergency', function (Blueprint $table) {
            $table->foreign('id_utente', 'tbl_emergency_ibfk_1')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('emer_lingua', 'tbl_emergency_ibfk_2')->references('Code')->on('Languages')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('emer_sesso', 'tbl_emergency_ibfk_3')->references('Code')->on('Gender')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_emergency', function (Blueprint $table) {
            $table->dropForeign('tbl_emergency_ibfk_1');
            $table->dropForeign('tbl_emergency_ibfk_2');
            $table->dropForeign('tbl_emergency_ibfk_3');
        });
    }
}
