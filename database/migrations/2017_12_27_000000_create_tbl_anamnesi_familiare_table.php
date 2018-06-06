<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAnamnesiFamiliareTable extends Migration
{
    
    public $set_schema_table = 'tbl_anamnesi_familiare';
    /**
     * Schema table name to migrate
     * @var string
     */
   

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
