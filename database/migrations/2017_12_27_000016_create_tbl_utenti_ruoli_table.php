<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblUtentiRuoliTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_utenti_tipologie';

    /**
     * Run the migrations.
     * @table tbl_utenti_ruoli
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
           $table->engine = 'InnoDB';
           $table->char('id_tipologia', 3);
           $table->string('tipologia_descrizione', 100);
           $table->string('tipologia_nome', 30);
           
           $table->index(["id_tipologia"], 'fk_tbl_tipologia_idx');
           
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
