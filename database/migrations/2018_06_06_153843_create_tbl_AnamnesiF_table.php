<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAnamnesiFTable extends Migration
{
    
    public $set_schema_table = 'tbl_AnamnesiF';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table , function (Blueprint $table) {
            $table->increments('id_anamnesiF');
            $table->string('codice', 15);
            $table->string('codice_descrizione', 25);
            $table->text('descrizione');
            $table->integer('id_paziente')->unsigned();
            $table->integer('id_parente')->unsigned();
            $table->string('status',10)->nullable(false);
            $table->string('notDoneReason',10);
            $table->text('note');
            $table->date('data');
            
            
            $table->foreign('id_parente', 'FOREIGN_Anamnesi_Parente_I1')
            ->references('id_parente')->on('tbl_Parente')
            ->onDelete('no action')
            ->onUpdate('no action');
            
            $table->foreign('id_paziente', 'FOREIGN_Anamnesi_Parente_I2')
            ->references('id_paziente')->on('tbl_anamnesi_familiare')
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
