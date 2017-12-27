<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblContattiPazientiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_contatti_pazienti';

    /**
     * Run the migrations.
     * @table tbl_contatti_pazienti
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_contatto');
            $table->integer('id_paziente')->unsigned();
            $table->smallInteger('id_contatto_tipologia');
            $table->string('contatto_nominativo', 45);
            $table->string('contatto_telefono', 15);

            $table->index(["id_contatto_tipologia"], 'fk_tbl_contatti_pazienti_tbl_tipologie_contatti1_idx');

            $table->index(["id_paziente"], 'fk_tbl_contatti_pazienti_tbl_pazienti1_idx');


            $table->foreign('id_paziente', 'fk_tbl_contatti_pazienti_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_contatto_tipologia', 'fk_tbl_contatti_pazienti_tbl_tipologie_contatti1_idx')
                ->references('id_tipologia_centro_contatto')->on('tbl_tipologie_contatti')
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
