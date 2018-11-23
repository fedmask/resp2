<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAllergyIntolleranceReactionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('AllergyIntolleranceReaction', function(Blueprint $table)
		{
			$table->integer('id_AI')->unsigned()->index('id_AI');
			$table->string('substance', 10)->index('substance');
			$table->string('manifestation', 10)->index('manifestation');
			$table->longtext('description');
			$table->date('onset');
			$table->string('severity', 10)->index('severity');
			$table->string('exposureRoute', 10)->index('exposureRoute');
			$table->longtext('note');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('AllergyIntolleranceReaction');
	}

}
