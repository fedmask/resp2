<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCppTipologieTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_cpp_tipologie';

    /**
     * Run the migrations.
     * @table tbl_cpp_tipologie
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallInteger('id_tipologia');
            $table->string('tipologia_nome', 100);
			
			$table->index(["id_tipologia"], 'FOREIGN_TIPOLOGIA_idx');

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
