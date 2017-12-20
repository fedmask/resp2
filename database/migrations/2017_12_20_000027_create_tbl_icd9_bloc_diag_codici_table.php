<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblIcd9BlocDiagCodiciTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_icd9_bloc_diag_codici';

    /**
     * Run the migrations.
     * @table tbl_icd9_bloc_diag_codici
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('codice_blocco');
            $table->string('codice_gruppo', 1);
            $table->text('blocco_cod_descrizione');

            $table->index(["codice_gruppo"], 'fk_tbl_icd9_bloc_diag_codici_tbl_icd9_grup_diag_codici1_idx');


            $table->foreign('codice_gruppo', 'fk_tbl_icd9_bloc_diag_codici_tbl_icd9_grup_diag_codici1_idx')
                ->references('codice')->on('tbl_icd9_grup_diag_codici')
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
