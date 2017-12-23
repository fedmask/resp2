<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblRecapitiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_recapiti';

    /**
     * Run the migrations.
     * @table tbl_recapiti
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_contatto');
            $table->integer('id_utente');
            $table->integer('id_comune_residenza');
            $table->integer('id_comune_nascita');
            $table->string('contatto_telefono', 30);
            $table->string('contatto_indirizzo', 100);

            $table->index(["id_comune_nascita"], 'fk_tbl_contatti_tbl_comuni2_idx');

            $table->index(["id_utente"], 'fk_tbl_contatti_tbl_utenti1_idx');

            $table->index(["id_comune_residenza"], 'fk_tbl_contatti_tbl_comuni1_idx');


            $table->foreign('id_utente', 'fk_tbl_contatti_tbl_utenti1_idx')
                ->references('id_utente')->on('tbl_utenti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_comune_residenza', 'fk_tbl_contatti_tbl_comuni1_idx')
                ->references('id_comune')->on('tbl_comuni')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_comune_nascita', 'fk_tbl_contatti_tbl_comuni2_idx')
                ->references('id_comune')->on('tbl_comuni')
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
