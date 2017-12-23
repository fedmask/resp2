<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblCppDiagnosiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_cpp_diagnosi', function(Blueprint $table)
		{
			$table->foreign('id_cpp', 'fk_tbl_cpp_diagnosi_tbl_care_provider')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_diagnosi', 'fk_tbl_cpp_diagnosi_tbl_diagnosi')->references('id_diagnosi')->on('tbl_diagnosi')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_cpp_diagnosi', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_cpp_diagnosi_tbl_care_provider');
			$table->dropForeign('fk_tbl_cpp_diagnosi_tbl_diagnosi');
		});
	}

}
