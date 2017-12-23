<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblContattiPazientiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_contatti_pazienti', function(Blueprint $table)
		{
			$table->integer('id_contatto', true);
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_contatti_pazienti_tbl_pazienti1_idx');
			$table->smallInteger('id_contatto_tipologia')->index('fk_tbl_contatti_pazienti_tbl_tipologie_contatti1_idx');
			$table->string('contatto_nominativo', 45);
			$table->string('contatto_telefono', 15);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_contatti_pazienti');
	}

}
