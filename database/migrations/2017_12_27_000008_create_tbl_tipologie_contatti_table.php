<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTipologieContattiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_tipologie_contatti';

    /**
     * Run the migrations.
     * @table tbl_tipologie_contatti
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallInteger('id_tipologia_centro_contatto');
            $table->string('tipologia_nome', 50);
			
			$table->index(["id_tipologia_centro_contatto"], 'fk_tbl_tipologie_contatti_tbl_contatti_pazienti1_idx');

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
