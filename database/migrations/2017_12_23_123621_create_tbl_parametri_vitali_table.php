<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblParametriVitaliTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_parametri_vitali', function(Blueprint $table)
		{
			$table->integer('id_parametro_vitale')->primary();
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_parametri_vitali_tbl_pazienti1_idx');
			$table->integer('id_audit_log')->index('fk_tbl_parametri_vitali_tbl_auditlog_log1_idx');
			$table->smallInteger('parametro_altezza');
			$table->smallInteger('parametro_peso');
			$table->smallInteger('parametro_pressione_minima');
			$table->smallInteger('parametro_pressione_massima');
			$table->smallInteger('parametro_frequenza_cardiaca');
			$table->boolean('parametro_dolore');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_parametri_vitali');
	}

}
