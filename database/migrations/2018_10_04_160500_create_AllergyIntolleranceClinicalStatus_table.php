<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAllergyIntolleranceClinicalStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('AllergyIntolleranceClinicalStatus', function(Blueprint $table)
		{
			$table->string('Code', 10)->primary();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('AllergyIntolleranceClinicalStatus');
	}

}
