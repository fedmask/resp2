<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblStatiMatrimonialiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_stati_matrimoniali';

    /**
     * Run the migrations.
     * @table tbl_stati_matrimoniali
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallInteger('id_stato_matrimoniale');
            $table->string('stato_matrimoniale_nome', 45);
            $table->string('stato_matrimoniale_descrizione', 100);
			
			$table->index(["id_stato_matrimoniale"], 'fk_tbl_stati_matrimoniali_tbl_pazienti_idx');

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
