<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCppPersonaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_cpp_persona';

    /**
     * Run the migrations.
     * @table tbl_cpp_persona
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_persona');
            $table->integer('id_utente')->unsigned();
            $table->integer('id_comune')->unsigned();
            $table->string('persona_nome', 45);
            $table->string('persona_cognome', 45);
            $table->string('persona_telefono', 45);
            $table->string('persona_fax', 45);
            $table->string('persona_reperibilita', 45);
            $table->tinyInteger('persona_attivo');

            $table->index(["id_comune"], 'fk_tbl_cpp_persona_tbl_comuni1_idx');

            $table->index(["id_utente"], 'fk_tbl_cpp_persona_tbl_utenti1_idx');


            $table->foreign('id_comune', 'fk_tbl_cpp_persona_tbl_comuni1_idx')
                ->references('id_comune')->on('tbl_comuni')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_utente', 'fk_tbl_cpp_persona_tbl_utenti1_idx')
                ->references('id_utente')->on('tbl_utenti')
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
