<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FamilyMemberHistoryCondition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FamilyMemberHistoryCondition', function(Blueprint $table)
        {
            $table->integer('id_anamnesiF')->unsigned()->index('id_anamnesiF');
            $table->string('code')->index('code');
            $table->string('outcome')->index('outcome');
            $table->string('note');
            
            $table->foreign('id_anamnesiF', 'FamilyMemberHistoryCondition_ibfk_1')->references('id_anamnesiF')->on('tbl_AnamnesiF')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('code', 'FamilyMemberHistoryCondition_ibfk_2')->references('Code')->on('ConditionCode')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('outcome', 'FamilyMemberHistoryCondition_ibfk_3')->references('Code')->on('FamilyMemberHistoryConditionOutcome')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
