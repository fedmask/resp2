<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEsamiObiettiviTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_esami_obiettivi';

    /**
     * Run the migrations.
     * @table tbl_esami_obiettivi
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_esame_obiettivo');
            $table->integer('id_paziente');
            $table->string('codice_risposta_loinc', 10);
            $table->integer('id_diagnosi');
            $table->date('esame_data');
            $table->date('esame_aggiornamento');
            $table->string('esame_stato', 15);
            $table->string('esame_risultato', 15);

            $table->index(["codice_risposta_loinc"], 'fk_tbl_esami_obiettivi_tbl_loinc_risposte1_idx');

            $table->index(["id_paziente"], 'fk_tbl_esami_obiettivi_tbl_pazienti1_idx');


            $table->foreign('id_paziente', 'fk_tbl_esami_obiettivi_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('codice_risposta_loinc', 'fk_tbl_esami_obiettivi_tbl_loinc_risposte1_idx')
                ->references('codice_risposta')->on('tbl_loinc_risposte')
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
