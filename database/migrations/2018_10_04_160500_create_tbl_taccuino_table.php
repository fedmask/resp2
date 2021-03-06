<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblTaccuinoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_taccuino', function(Blueprint $table)
		{
			$table->increments('id_taccuino');
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_taccuino_tbl_pazienti1_idx');
			$table->string('taccuino_descrizione', 45)->nullable();
			$table->date('taccuino_data');
			$table->binary('taccuino_report_anteriore');
			$table->binary('taccuino_report_posteriore');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_taccuino');
	}

}
