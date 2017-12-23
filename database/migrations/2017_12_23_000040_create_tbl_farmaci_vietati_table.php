<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblFarmaciVietatiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_farmaci_vietati';

    /**
     * Run the migrations.
     * @table tbl_farmaci_vietati
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_farmaco_vietato');
            $table->integer('id_paziente');
            $table->string('id_farmaco', 8);
            $table->text('farmaco_vietato_motivazione');
            $table->smallInteger('farmaco_vietato_confidenzialita');

            $table->index(["id_farmaco"], 'fk_tbl_farmaci_vietati_tbl_farmaci1_idx');

            $table->index(["id_paziente"], 'fk_tbl_farmaci_vietati_tbl_pazienti1_idx');

            $table->index(["farmaco_vietato_confidenzialita"], 'fk_tbl_farmaci_vietati_tbl_livelli_confidenzialita1_idx');


            $table->foreign('id_paziente', 'fk_tbl_farmaci_vietati_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_farmaco', 'fk_tbl_farmaci_vietati_tbl_farmaci1_idx')
                ->references('id_farmaco')->on('tbl_farmaci')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('farmaco_vietato_confidenzialita', 'fk_tbl_farmaci_vietati_tbl_livelli_confidenzialita1_idx')
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
