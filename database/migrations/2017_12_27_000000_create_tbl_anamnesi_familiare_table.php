<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAnamnesiFamiliareTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_anamnesi_familiare';

    /**
     * Run the migrations.
     * @table tbl_anamnesi_familiare
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id_paziente')->unsigned();
            
            $table->string('codice_relazione',15)->nullable(false);
            
            $table->integer('id_anamnesi_log');
            $table->text('anamnesi_contenuto');
            $table->primary('id_paziente');
          
            
           
           
            
            
            
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
