<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCentriContattiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_centri_contatti';

    /**
     * Run the migrations.
     * @table tbl_centri_contatti
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_contatto');
            $table->integer('id_centro');
            $table->smallInteger('id_modalita_contatto');
            $table->string('contatto_valore', 100);

            $table->index(["id_centro"], 'fk_tbl_centri_contatti_tbl_centri_indagini1_idx');

            $table->index(["id_modalita_contatto"], 'fk_tbl_centri_contatti_tbl_modalita_contatti1_idx');


            $table->foreign('id_centro', 'fk_tbl_centri_contatti_tbl_centri_indagini1_idx')
                ->references('id_centro')->on('tbl_centri_indagini')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_modalita_contatto', 'fk_tbl_centri_contatti_tbl_modalita_contatti1_idx')
                ->references('id_modalita')->on('tbl_modalita_contatti')
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
