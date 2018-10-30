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
			$table->longText('Name');
			$table->longText('Surname');
			$table->longText('Telephone')->nullable();
			$table->longText('Mail')->nullable();
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
