<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPazientiFamiliaritaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_pazienti_familiarita';

    /**
     * Run the migrations.
     * @table tbl_pazienti_familiarita
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_familiarita');
            $table->integer('id_paziente');
            $table->integer('id_parente');
            $table->string('familiarita_grado_parentela', 25);
            $table->date('familiarita_aggiornamento_data');
            $table->tinyInteger('familiarita_conferma')->default('0');

            $table->index(["id_parente"], 'fk_tbl_pazienti_familiarita_tbl_utenti1_idx');

            $table->index(["id_paziente"], 'fk_tbl_pazienti_familiarita_tbl_pazienti1_idx');


            $table->foreign('id_paziente', 'fk_tbl_pazienti_familiarita_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_parente', 'fk_tbl_pazienti_familiarita_tbl_utenti1_idx')
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
