<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblPazientiContattiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_pazienti_contatti', function(Blueprint $table)
		{
			$table->increments('id_contatto');
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_contatti_pazienti_tbl_pazienti1_idx');
			$table->smallInteger('id_contatto_tipologia')->index('fk_tbl_contatti_pazienti_tbl_tipologie_contatti1_idx');
			$table->string('contatto_nominativo', 45)->nullable();
			$table->string('contatto_telefono', 15)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_pazienti_contatti');
	}

}
