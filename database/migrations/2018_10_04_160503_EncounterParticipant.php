<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EncounterParticipant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EncounterParticipant', function(Blueprint $table)
        {
            $table->integer('id_visita')->unsigned()->index('id_visita');
            $table->integer('individual')->unsigned()->index('individual');
            $table->string('type')->index('type');
            $table->date('start_period');
            $table->date('end_period');
            
            $table->foreign('id_visita', 'tbl_EncounterParticipant_ibfk_1')->references('id_visita')->on('tbl_pazienti_visite')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('individual', 'tbl_EncounterParticipant_ibfk_2')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('type', 'tbl_EncounterParticipant_ibfk_3')->references('Code')->on('EncounterParticipantType')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('EncounterParticipant');
    }
}
