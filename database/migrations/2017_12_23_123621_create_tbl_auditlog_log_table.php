<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblAuditlogLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_auditlog_log', function(Blueprint $table)
		{
			$table->integer('id_audit', true);
			$table->string('audit_nome', 100);
			$table->string('audit_ip', 39);
			$table->integer('id_visitato')->unsigned()->index('fk_tbl_auditlog_log_tbl_utenti2_idx');
			$table->integer('id_visitante')->unsigned()->index('fk_tbl_auditlog_log_tbl_utenti1_idx');
			$table->date('audit_data');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_auditlog_log');
	}

}
