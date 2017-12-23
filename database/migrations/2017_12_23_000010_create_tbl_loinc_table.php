<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLoincTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_loinc';

    /**
     * Run the migrations.
     * @table tbl_loinc
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('codice_loinc');
            $table->string('loinc_classe', 100);
            $table->string('loinc_componente', 100);
            $table->string('loinc_proprieta', 10);
            $table->string('loinc_temporizzazione', 10);
            $table->string('loinc_sistema', 50);
            $table->string('loinc_scala', 5);
            $table->string('loinc_metodo', 25);
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
