<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblFamiliaritaDecessiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_familiarita_decessi', function(Blueprint $table)
		{
			$table->integer('id_paziente')->primary();
			$table->date('familiare_data_decesso');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_familiarita_decessi');
	}

}
