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
			$table->increments('id_audit');
			$table->string('audit_nome', 100)->nullable();
			$table->string('audit_ip', 39)->nullable();
			$table->integer('id_visitato')->unsigned()->index('fk_tbl_auditlog_log_tbl_utenti2_idx');
			$table->integer('id_visitante')->unsigned()->index('fk_tbl_auditlog_log_tbl_utenti1_idx');
			$table->date('audit_data');
			$table->string('dispositivo', 39)->nullable();
			$table->string('ruolo', 39)->nullable();
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
