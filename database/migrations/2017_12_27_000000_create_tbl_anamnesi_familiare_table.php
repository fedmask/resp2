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
            $table->increments('id_anamnesi_familiare');
            $table->string('status',10)->nullable(false);
            $table->string('notDoneReason',10);
            $table->string('codice_relazione',15)->nullable(false);
            $table->integer('id_paziente');
            $table->integer('id_anamnesi_log');
            $table->text('anamnesi_contenuto');
            $table->string('genere',8)->nullable(false);
            
            $table->date('data_nascita')->nullable(false);
            $table->integer('età')->nullable(false);
            $table->boolean('decesso');
            $table->integer('età_decesso');
            $table->date('data_decesso');
            $table->integer('condizione')->unsigned();
            
           
           
            
            
            
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
