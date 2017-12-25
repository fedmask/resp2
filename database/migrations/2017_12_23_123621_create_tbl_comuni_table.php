<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblComuniTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('tbl_comuni', function(Blueprint $table)
    		{
    			$table->integer('id_comune')->primary();
    			$table->integer('id_comune_nazione')->index('FOREIGN_NAZIONE_idx');
    			$table->string('comune_nominativo', 45);
    			$table->char('comune_cap', 5);
    		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_comuni');
	}

}
