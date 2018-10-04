<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblVaccinazioniReactionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_vaccinazioni_reaction', function(Blueprint $table)
		{
			$table->increments('id_vacc_reaction');
			$table->timestamps();
			$table->integer('id_vaccinazione')->unsigned()->index('fk_tbl_reazioni_tbl_vaccinazione');
			$table->date('date');
			$table->integer('id_centro')->unsigned()->index('fk_tbl_centri_indagini_tbl_reazioni');
			$table->boolean('reported')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_vaccinazioni_reaction');
	}

}
