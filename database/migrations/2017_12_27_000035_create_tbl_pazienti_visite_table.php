<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPazientiVisiteTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_pazienti_visite';

    /**
     * Run the migrations.
     * @table tbl_pazienti_visite
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_visita');
            $table->integer('id_cpp')->unsigned();
            $table->integer('id_paziente')->unsigned();
            $table->date('visita_data');
            $table->string('visita_motivazione', 100);
            $table->text('visita_osservazioni');
            $table->text('visita_conclusioni');

            $table->index(["id_paziente"], 'fk_tbl_pazienti_visite_tbl_pazienti1_idx');

            $table->index(["id_cpp"], 'fk_tbl_pazienti_visite_tbl_medici1_idx');


            $table->foreign('id_paziente', 'fk_tbl_pazienti_visite_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_cpp', 'fk_tbl_pazienti_visite_tbl_medici1_idx')
                ->references('id_cpp')->on('tbl_care_provider')
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
