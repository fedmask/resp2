<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAllergyIntolleranceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('AllergyIntollerance', function(Blueprint $table)
		{
			$table->increments('id_AI');
			$table->string('clinicalStatus', 10)->index('clinicalStatus');
			$table->string('verificationStatus', 20)->index('verificationStatus');
			$table->string('tipo', 15)->index('tipo');
			$table->string('category', 15)->index('category');
			$table->string('criticality', 20)->index('criticality');
			$table->integer('id_paziente')->unsigned()->index('id_paziente');
			$table->date('assertedDate');
			$table->integer('recorder')->unsigned()->index('recorder');
			$table->date('lastOccurance');
			$table->date('note');
			$table->string('code', 10)->index('code');
			$table->smallInteger('confidenza')->index('confidenza');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('AllergyIntollerance');
	}

}
