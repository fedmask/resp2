<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblAuditlogLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_auditlog_log', function(Blueprint $table)
		{
			$table->foreign('id_visitante', 'fk_tbl_auditlog_log_tbl_utenti1_idx')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('cascade');
			$table->foreign('id_visitato', 'fk_tbl_auditlog_log_tbl_utenti2_idx')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_auditlog_log', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_auditlog_log_tbl_utenti1_idx');
			$table->dropForeign('fk_tbl_auditlog_log_tbl_utenti2_idx');
		});
	}

}
