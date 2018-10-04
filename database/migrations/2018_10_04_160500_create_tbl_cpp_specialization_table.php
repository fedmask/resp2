<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblCppSpecializationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_cpp_specialization', function(Blueprint $table)
		{
			$table->increments('id_cpp_specialization');
			$table->integer('id_specialization')->unsigned()->index('FOREIGN_Specialization_Cpp_idx');
			$table->integer('id_cpp')->unsigned()->index('FOREIGN_CPP_Specialization_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_cpp_specialization');
	}

}
