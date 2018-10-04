<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblAnamnesiFamiliareTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_anamnesi_familiare', function(Blueprint $table)
		{
			$table->integer('id_paziente')->unsigned()->primary();
			$table->integer('id_anamnesi_log');
			$table->text('anamnesi_contenuto', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_anamnesi_familiare');
	}

}
