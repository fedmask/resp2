<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateATCGruppoAnatomicoPTable extends Migration
{
	
	public $set_schema_table = 'tbl_Gruppo_Anatomico_P';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->char('ID_Gruppo_Anatomico',1)->primary();
            $table->timestamps();
            $table->string('Descrizione',45);
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
