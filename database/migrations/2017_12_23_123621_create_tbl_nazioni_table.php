<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblNazioniTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    if (!Schema::hasTable('tbl_nazioni')) {
	        
    		Schema::create('tbl_nazioni', function(Blueprint $table)
    		{
    			$table->integer('id_nazione')->primary();
    			$table->string('nazione_nominativo', 45);
    			$table->string('nazione_prefisso_telefonico', 4);
    		});
	    }
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_nazioni');
	}

}
