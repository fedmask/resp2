<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAllergyIntolleranceReactionSeverityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('AllergyIntolleranceReactionSeverity', function(Blueprint $table)
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
		Schema::drop('AllergyIntolleranceReactionSeverity');
	}

}
