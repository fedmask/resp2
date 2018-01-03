<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblUtentiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_utenti';

    /**
     * Run the migrations.
     * @table tbl_utenti
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_utente')->unsigned();
            $table->char('id_tipologia', 3);
            $table->string('utente_nome', 50);
            $table->string('utente_password', 130);
            $table->tinyInteger('utente_stato');
            $table->date('utente_scadenza');
            $table->string('utente_email', 100);
            $table->string('utente_token_accesso', 60)->nullable();
            $table->tinyInteger('utente_dati_condivisione')->default(0);
            
            $table->index(["id_tipologia"], 'fk_tbl_utenti_ruoli_idx');

            $table->unique(["utente_email"], 'utente_email_UNIQUE');


            $table->foreign('id_tipologia', 'fk_tbl_utenti_tipologia_idx')
                ->references('id_tipologia')->on('tbl_utenti_tipologie')
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
