<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblVaccinazioneTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_vaccinazione';

    /**
     * Run the migrations.
     * @table tbl_vaccinazione
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_vaccinazione');
            $table->integer('id_vaccino');
            $table->integer('id_paziente');
            $table->integer('id_cpp');
            $table->integer('vaccinazione_confidenzialita');
            $table->date('vaccinazione_data');
            $table->string('vaccinazione_aggiornamento', 45);
            $table->string('vaccinazione_reazioni', 45);

            $table->index(["vaccinazione_confidenzialita"], 'fk_tbl_vaccinazione_tbl_livelli_confidenzialita1_idx');

            $table->index(["id_vaccino"], 'fk_tbl_vaccinazione_tbl_vaccini1_idx');

            $table->index(["id_cpp"], 'fk_tbl_vaccinazione_tbl_care_provider1_idx');

            $table->index(["id_paziente"], 'fk_tbl_vaccinazione_tbl_pazienti1_idx');


            $table->foreign('id_vaccino', 'fk_tbl_vaccinazione_tbl_vaccini1_idx')
                ->references('id_vaccino')->on('tbl_vaccini')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_paziente', 'fk_tbl_vaccinazione_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_cpp', 'fk_tbl_vaccinazione_tbl_care_provider1_idx')
                ->references('id_cpp')->on('tbl_care_provider')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('vaccinazione_confidenzialita', 'fk_tbl_vaccinazione_tbl_livelli_confidenzialita1_idx')
                ->references('id_livello_confidenzialita')->on('tbl_livelli_confidenzialita')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
