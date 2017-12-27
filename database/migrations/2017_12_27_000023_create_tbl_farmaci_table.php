<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblFarmaciTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_farmaci';

    /**
     * Run the migrations.
     * @table tbl_farmaci
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('id_farmaco', 8);
            $table->string('id_categoria_farmaco', 6);
            $table->string('farmaco_nome', 50);

			$table->index(["id_farmaco"], 'fk_tbl_farmaci_tbl_farmaci_vietati_idx');

            $table->index(["id_categoria_farmaco"], 'fk_tbl_farmaci_tbl_farmaci_categorie1_idx');


            $table->foreign('id_categoria_farmaco', 'fk_tbl_farmaci_tbl_farmaci_categorie1_idx')
                ->references('id_categoria')->on('tbl_farmaci_categorie')
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
