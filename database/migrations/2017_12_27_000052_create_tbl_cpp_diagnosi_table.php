<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCppDiagnosiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_cpp_diagnosi';

    /**
     * Run the migrations.
     * @table tbl_cpp_diagnosi
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_diagnosi');
            $table->string('diagnosi_stato', 15);
            $table->integer('id_cpp')->unsigned();
            $table->text('careprovider');

            $table->index(["id_cpp"], 'fk_tbl_cpp_diagnosi_tbl_care_provider1_idx');


            $table->foreign('id_cpp', 'fk_tbl_cpp_diagnosi_tbl_care_provider1_idx')
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
