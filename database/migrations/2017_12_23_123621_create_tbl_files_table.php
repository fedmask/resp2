<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_files', function(Blueprint $table)
		{
			$table->integer('id_file')->primary();
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_files_tbl_pazienti1_idx');
			$table->integer('id_audit_log')->index('fk_tbl_files_tbl_auditlog_log1_idx');
			$table->smallInteger('id_file_confidenzialita')->index('fk_tbl_files_tbl_livelli_confidenzialita1_idx');
			$table->string('file_nome', 60);
			$table->text('file_commento', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_files');
	}

}
