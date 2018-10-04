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
			$table->smallInteger('id_stato_matrimoniale')->index('fk_tbl_stati_matrimoniali_tbl_pazienti_idx');
			$table->string('stato_matrimoniale_nome', 45)->nullable();
			$table->string('stato_matrimoniale_descrizione', 100)->nullable();
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
