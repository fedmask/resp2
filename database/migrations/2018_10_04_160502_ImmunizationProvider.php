<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImmunizationProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ImmunizationProvider', function(Blueprint $table)
        {
            $table->integer('id_cpp')->unsigned()->index('id_cpp');
            $table->string('role')->index('role');
            $table->integer('id_vaccinazione')->unsigned()->index('id_vaccinazione');
            
            $table->foreign('id_cpp', 'ImmunizationProvider_ibfk_1')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('role', 'ImmunizationProvider_ibfk_2')->references('Code')->on('ProviderRole')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('id_vaccinazione', 'ImmunizationProvider_ibfk_3')->references('id_vaccinazione')->on('tbl_vaccinazione')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ImmunizationProvider');
    }
}
