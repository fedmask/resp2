<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblOperazioniLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_operazioni_log', function(Blueprint $table)
		{
			$table->increments('id_operazione');
			$table->integer('id_audit_log')->unsigned()->index('fk_tbl_operazioni_log_tbl_auditlog_log1_idx');
			$table->char('operazione_codice', 2)->nullable()->index('fk_tbl_operazioni_log_tbl_codici_operazioni1_idx');
			$table->time('operazione_orario');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_operazioni_log');
	}

}
