<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblCodiciOperazioniTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_codici_operazioni', function(Blueprint $table)
		{
			$table->char('id_codice', 2)->nullable()->index('fk_tbl_codici_operazioni_tbl_operazioni_log_idx');
			$table->string('codice_descrizione', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_codici_operazioni');
	}

}
