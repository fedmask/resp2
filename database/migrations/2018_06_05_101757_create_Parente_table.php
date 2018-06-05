<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParenteTable extends Migration
{
    public $set_schema_table = 'tbl_parente';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->increments('id_parente');
            $table->char('codice_fiscale',16)->nullable(true);
            $table->string('nome',25);
            $table->string('cognome',25);
            $table->sesso('sesso',8);
            $table->date('data_nascita')->nullable(false);
            $table->integer('età')->nullable(false);
            $table->boolean('decesso');
            $table->integer('età_decesso');
            $table->date('data_decesso');
            $table->integer('condizione')->unsigned();
            $table->timestamps();
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
