<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblIndaginiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_indagini';

    /**
     * Run the migrations.
     * @table tbl_indagini
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_indagine');
            $table->integer('id_centro_indagine');
            $table->integer('id_diagnosi');
            $table->integer('id_paziente');
            $table->integer('id_audit_log');
            $table->integer('indagine_codice_icd');
            $table->integer('indagine_codice_loinc');
            $table->date('indagine_data');
            $table->date('indagine_aggiornamento');
            $table->string('indagine_stato', 12);
            $table->text('indagine_tipologia');
            $table->text('indagine_motivo');
            $table->text('indagine_referto');
            $table->text('indagine_allegato');

            $table->index(["indagine_codice_loinc"], 'fk_tbl_indagini_tbl_loinc1_idx');

            $table->index(["id_audit_log"], 'fk_tbl_indagini_tbl_auditlog_log1_idx');

            $table->index(["id_centro_indagine"], 'fk_tbl_indagini_tbl_centri_indagini1_idx');

            $table->index(["id_diagnosi"], 'fk_tbl_indagini_tbl_diagnosi1_idx');

            $table->index(["id_paziente"], 'fk_tbl_indagini_tbl_pazienti1_idx');

            $table->index(["indagine_codice_icd"], 'fk_tbl_indagini_tbl_icd9_esami_strumenti_codici1_idx');


            $table->foreign('id_centro_indagine', 'fk_tbl_indagini_tbl_centri_indagini1_idx')
                ->references('id_centro')->on('tbl_centri_indagini')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_diagnosi', 'fk_tbl_indagini_tbl_diagnosi1_idx')
                ->references('id_diagnosi')->on('tbl_diagnosi')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_paziente', 'fk_tbl_indagini_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_audit_log', 'fk_tbl_indagini_tbl_auditlog_log1_idx')
                ->references('id_audit')->on('tbl_auditlog_log')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('indagine_codice_icd', 'fk_tbl_indagini_tbl_icd9_esami_strumenti_codici1_idx')
                ->references('esame_codice')->on('tbl_icd9_esami_strumenti_codici')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('indagine_codice_loinc', 'fk_tbl_indagini_tbl_loinc1_idx')
                ->references('codice_loinc')->on('tbl_loinc')
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
