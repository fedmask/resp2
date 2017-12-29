<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLoincRisposteTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_loinc_risposte';

    /**
     * Run the migrations.
     * @table tbl_loinc_risposte
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('id_codice', 10);
            $table->string('codice_risposta', 100);
            $table->string('codice_loinc', 100);
			
			$table->index(["id_codice"], 'fk_tbl_loinc_risposte1_idx');
			$table->index(["codice_risposta"], 'fk_tbl_loinc_risposte2_idx');
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
