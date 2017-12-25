<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblVaccinazioneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_vaccinazione', function(Blueprint $table)
		{
			$table->integer('id_vaccinazione')->primary();
			$table->integer('id_vaccino')->index('fk_tbl_vaccinazione_tbl_vaccini1_idx');
			$table->integer('id_paziente')->index('fk_tbl_vaccinazione_tbl_pazienti1_idx');
			$table->integer('id_cpp')->index('fk_tbl_vaccinazione_tbl_care_provider1_idx');
			$table->smallInteger('vaccinazione_confidenzialita')->index('fk_tbl_vaccinazione_tbl_livelli_confidenzialita1_idx');
			$table->date('vaccinazione_data');
			$table->string('vaccinazione_aggiornamento', 45);
			$table->string('vaccinazione_reazioni', 45);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_vaccinazione');
	}

}
