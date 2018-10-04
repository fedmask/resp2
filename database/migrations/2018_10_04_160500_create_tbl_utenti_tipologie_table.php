<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblUtentiTipologieTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_utenti_tipologie', function(Blueprint $table)
		{
			$table->char('id_tipologia', 3)->nullable()->index('fk_tbl_tipologia_idx');
			$table->string('tipologia_descrizione', 100)->nullable();
			$table->string('tipologia_nome', 30)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_utenti_tipologie');
	}

}
