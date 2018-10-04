<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblCppSpecializationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_cpp_specialization', function(Blueprint $table)
		{
			$table->foreign('id_specialization', 'FOREIGN_Specialization_Cpp_idx')->references('id_spec')->on('tbl_specialization')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_cpp', 'tbl_cpp_specialization_ibfk_1')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_cpp_specialization', function(Blueprint $table)
		{
			$table->dropForeign('FOREIGN_Specialization_Cpp_idx');
			$table->dropForeign('tbl_cpp_specialization_ibfk_1');
		});
	}

}
