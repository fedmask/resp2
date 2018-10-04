<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatientContactTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('PatientContact', function(Blueprint $table)
		{
			$table->integer('Id_Patient')->unsigned()->nullable()->index('Id_Patient');
			$table->char('Relationship', 3)->index('Relationship');
			$table->char('Name', 30);
			$table->char('Surname', 30);
			$table->string('Telephone', 15)->nullable();
			$table->string('Mail', 50)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('PatientContact');
	}

}
