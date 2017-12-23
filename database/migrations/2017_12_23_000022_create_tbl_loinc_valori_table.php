<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLoincValoriTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_loinc_valori';

    /**
     * Run the migrations.
     * @table tbl_loinc_valori
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_esclab');
            $table->string('id_codice', 10);
            $table->string('valore_normale', 120);

            $table->index(["id_codice"], 'fk_tbl_loinc_valori_tbl_loinc1_idx');


            $table->foreign('id_codice', 'fk_tbl_loinc_valori_tbl_loinc1_idx')
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
