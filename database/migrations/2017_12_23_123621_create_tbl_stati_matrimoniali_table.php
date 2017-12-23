<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblStatiMatrimonialiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_stati_matrimoniali', function(Blueprint $table)
		{
			$table->smallInteger('id_stato_matrimoniale')->primary();
			$table->string('stato_matrimoniale_nome', 45);
			$table->string('stato_matrimoniale_descrizione', 100);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_stati_matrimoniali');
	}

}
