<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblEffettiCollateraliTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_effetti_collaterali', function(Blueprint $table)
		{
			$table->integer('id_effetto_collaterale', true);
			$table->integer('id_paziente')->index('fk_tbl_effetti_collaterali_tbl_pazienti1_idx');
			$table->integer('id_audit_log')->index('fk_tbl_effetti_collaterali_tbl_auditlog_log1_idx');
			$table->text('effetto_collaterale_descrizione', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_effetti_collaterali');
	}

}
