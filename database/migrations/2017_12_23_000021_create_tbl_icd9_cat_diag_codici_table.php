<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblIcd9CatDiagCodiciTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_icd9_cat_diag_codici';

    /**
     * Run the migrations.
     * @table tbl_icd9_cat_diag_codici
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('codice_categoria');
            $table->string('codice_blocco', 4);
            $table->string('categoria_cod_descrizione', 120);

            $table->index(["codice_blocco"], 'fk_tbl_icd9_cat_diag_codici_tbl_icd9_grup_diag_codici1_idx');


            $table->foreign('codice_blocco', 'fk_tbl_icd9_cat_diag_codici_tbl_icd9_grup_diag_codici1_idx')
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
