<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblPazientiDecessiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_pazienti_decessi', function(Blueprint $table)
		{
		    $table->integer('id_paziente')->unsigned()->primary();
			$table->date('paziente_data_decesso');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_pazienti_decessi');
	}

}
