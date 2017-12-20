<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblComuniTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_comuni';

    /**
     * Run the migrations.
     * @table tbl_comuni
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_comune');
            $table->integer('id_comune_nazione');
            $table->string('comune_nominativo', 45);
            $table->char('comune_cap', 5);

            $table->index(["id_comune_nazione"], 'FOREIGN_NAZIONE_idx');


            $table->foreign('id_comune_nazione', 'FOREIGN_NAZIONE_idx')
                ->references('id_nazione')->on('tbl_nazioni')
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
