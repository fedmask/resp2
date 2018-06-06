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
            $table->integer('id_paziente');
            $table->integer('id_parente')->unsigned();
            $table->string('status',10)->nullable(false);
            $table->string('notDoneReason',10);
            $table->text('note');
            $table->date('data');
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
