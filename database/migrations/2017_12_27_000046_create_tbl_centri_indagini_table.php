<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCentriIndaginiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_centri_indagini';

    /**
     * Run the migrations.
     * @table tbl_centri_indagini
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_centro')->unsigned();
            $table->smallInteger('id_tipologia');
            $table->integer('id_comune')->unsigned();
            $table->integer('id_ccp_persona')->unsigned();
            $table->string('centro_nome', 80);
            $table->string('centro_indirizzo', 100);
            $table->string('centro_mail', 50);
            $table->tinyInteger('centro_resp');

            $table->index(["id_ccp_persona"], 'fk_tbl_centri_indagini_tbl_cpp_persona1_idx');

            $table->index(["id_comune"], 'fk_tbl_centri_indagini_tbl_comuni1_idx');

            $table->index(["id_tipologia"], 'fk_tbl_centri_indagini_tbl_centri_tipologie1_idx');


            $table->foreign('id_tipologia', 'fk_tbl_centri_indagini_tbl_centri_tipologie1_idx')
                ->references('id_centro_tipologia')->on('tbl_centri_tipologie')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_comune', 'fk_tbl_centri_indagini_tbl_comuni1_idx')
                ->references('id_comune')->on('tbl_comuni')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_ccp_persona', 'fk_tbl_centri_indagini_tbl_cpp_persona1_idx')
                ->references('id_persona')->on('tbl_cpp_persona')
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
