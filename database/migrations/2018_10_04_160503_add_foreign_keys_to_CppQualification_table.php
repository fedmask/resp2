<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCppQualificationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('CppQualification', function(Blueprint $table)
		{
			$table->foreign('Code', 'CppQualification_ibfk_1')->references('Code')->on('QualificationCode')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_cpp', 'CppQualification_ibfk_2')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('CppQualification', function(Blueprint $table)
		{
			$table->dropForeign('CppQualification_ibfk_1');
			$table->dropForeign('CppQualification_ibfk_2');
		});
	}

}
