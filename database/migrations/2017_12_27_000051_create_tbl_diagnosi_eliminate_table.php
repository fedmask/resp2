<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblDiagnosiEliminateTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_diagnosi_eliminate';

    /**
     * Run the migrations.
     * @table tbl_diagnosi_eliminate
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_diagnosi_eliminata');
            $table->integer('id_utente')->unsigned();
            $table->integer('id_diagnosi')->unsigned();

            $table->index(["id_diagnosi"], 'fk_tbl_diagnosi_eliminate_tbl_diagnosi1_idx');

            $table->index(["id_utente"], 'fk_tbl_diagnosi_eliminate_tbl_pazienti1_idx');


            $table->foreign('id_utente', 'fk_tbl_diagnosi_eliminate_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_diagnosi', 'fk_tbl_diagnosi_eliminate_tbl_diagnosi1_idx')
                ->references('id_diagnosi')->on('tbl_diagnosi')
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
