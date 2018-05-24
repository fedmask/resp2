<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCppPazienteTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_cpp_paziente';

    /**
     * Run the migrations.
     * @table tbl_cpp_paziente
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_cpp')->unique();
            $table->integer('id_paziente')->unsigned();
            $table->smallInteger('assegnazione_confidenzialita');

            $table->index(["id_paziente"], 'fk_tbl_medici_assegnati_tbl_pazienti1_idx');

            $table->index(["assegnazione_confidenzialita"], 'fk_tbl_medici_assegnati_tbl_livelli_confidenzialita1_idx');

            $table->index(["id_cpp"], 'fk_tbl_medici_assegnati_tbl_medici1_idx');


            $table->foreign('id_cpp', 'fk_tbl_medici_assegnati_tbl_medici1_idx')
                ->references('id_cpp')->on('tbl_care_provider')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_paziente', 'fk_tbl_medici_assegnati_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('assegnazione_confidenzialita', 'fk_tbl_medici_assegnati_tbl_livelli_confidenzialita1_idx')
                ->references('id_livello_confidenzialita')->on('tbl_livelli_confidenzialita')
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
