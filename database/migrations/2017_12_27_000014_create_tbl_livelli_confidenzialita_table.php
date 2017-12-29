<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLivelliConfidenzialitaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_livelli_confidenzialita';

    /**
     * Run the migrations.
     * @table tbl_livelli_confidenzialita
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallInteger('id_livello_confidenzialita')->unsigend();
            $table->string('confidenzialita_descrizione', 45);
			
			 $table->index(["id_livello_confidenzialita"], 'fk_tbl_livelli_confidenzialita_tbl_diagnosi_idx');

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
