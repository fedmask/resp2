<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPazientiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_pazienti';

    /**
     * Run the migrations.
     * @table tbl_pazienti
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_paziente')->unsigned();
            $table->integer('id_utente')->unsigned();
            $table->smallInteger('id_stato_matrimoniale');
            $table->string('paziente_nome', 45);
            $table->string('paziente_cognome', 45);
            $table->date('paziente_nascita');
            $table->char('paziente_codfiscale', 16);
            $table->char('paziente_sesso', 1);
            $table->tinyInteger('paziente_gruppo');
            $table->char('paziente_rh', 3);
            $table->tinyInteger('paziente_donatore_organi');

            $table->index(["id_utente"], 'FOREIGN_UTENTE_idx');

            $table->index(["id_stato_matrimoniale"], 'fk_tbl_pazienti_tbl_stati_matrimoniali1_idx');

            $table->unique(["paziente_codfiscale"], 'paziente_codfiscale_UNIQUE');


            $table->foreign('id_utente', 'FOREIGN_UTENTE_idx')
                ->references('id_utente')->on('tbl_utenti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_stato_matrimoniale', 'fk_tbl_pazienti_tbl_stati_matrimoniali1_idx')
                ->references('id_stato_matrimoniale')->on('tbl_stati_matrimoniali')
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
