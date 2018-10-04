<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCppQualificationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('CppQualification', function(Blueprint $table)
		{
			$table->integer('id_cpp')->unsigned()->nullable()->index('id_cpp');
			$table->char('Code', 10)->index('Code');
			$table->date('Start_Period');
			$table->date('End_Period');
			$table->string('Issuer', 30);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('CppQualification');
	}

}
