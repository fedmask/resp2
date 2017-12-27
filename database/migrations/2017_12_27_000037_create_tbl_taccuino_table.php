<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTaccuinoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_taccuino';

    /**
     * Run the migrations.
     * @table tbl_taccuino
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_taccuino');
            $table->integer('id_paziente')->unsigned();
            $table->string('taccuino_descrizione', 45);
            $table->date('taccuino_data');
            $table->binary('taccuino_report_anteriore');
            $table->binary('taccuino_report_posteriore');

            $table->index(["id_paziente"], 'fk_tbl_taccuino_tbl_pazienti1_idx');


            $table->foreign('id_paziente', 'fk_tbl_taccuino_tbl_pazienti1_idx')
                ->references('id_paziente')->on('tbl_pazienti')
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
