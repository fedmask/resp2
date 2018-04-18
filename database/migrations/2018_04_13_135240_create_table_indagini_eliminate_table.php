<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIndaginiEliminateTable extends Migration
{
    
    public $set_schema_table = 'tbl_indagini_eliminate';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
            Schema::create($this->set_schema_table, function (Blueprint $table){
            $table->increments('id_indagine_eliminata')->unsigned();
            $table->integer('id_utente')->unsigned();
            $table->integer('id_indagine')->unsigned();
        
        
        
            $table->index(["id_indagine"], 'fk_tbl_indagini_eliminate_tbl_indagini1_idx');
            
           $table->index(["id_utente"], 'fk_tbl_indagini_eliminate_tbl_utenti1_idx');
            
            
            $table->foreign('id_utente', 'fk_tbl_indagini_eliminate_tbl_utenti1_idx')
            ->references('id_utente')->on('tbl_utenti')
            ->onDelete('no action')
            ->onUpdate('no action');
           
            
            $table->foreign('id_indagine', 'fk_tbl_indagini_eliminate_tbl_indagini1_idx')
            ->references('id_indagine')->on('tbl_indagini')
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
