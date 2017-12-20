<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblDiagnosiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_diagnosi';

    /**
     * Run the migrations.
     * @table tbl_diagnosi
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_diagnosi');
            $table->string('id_paziente', 45);
            $table->smallInteger('diagnosi_confidenzialita');
            $table->date('diagnosi_inserimento_data');
            $table->date('diagnosi_aggiornamento_data');
            $table->text('diagnosi_patologia');
            $table->tinyInteger('diagnosi_stato');
            $table->date('diagnosi_guarigione_data');

            $table->index(["diagnosi_confidenzialita"], 'fk_tbl_diagnosi_tbl_livelli_confidenzialita1_idx');

            $table->index(["id_paziente"], 'fk_tbl_diagnosi_tbl_pazienti1_idx');


            $table->foreign('id_paziente', 'fk_tbl_diagnosi_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('diagnosi_confidenzialita', 'fk_tbl_diagnosi_tbl_livelli_confidenzialita1_idx')
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
