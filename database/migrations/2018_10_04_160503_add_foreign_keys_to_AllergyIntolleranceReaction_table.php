<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAllergyIntolleranceReactionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('AllergyIntolleranceReaction', function(Blueprint $table)
		{
			$table->foreign('id_AI', 'AllergyIntolleranceReaction_ibfk_1')->references('id_AI')->on('AllergyIntollerance')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('substance', 'AllergyIntolleranceReaction_ibfk_2')->references('Code')->on('AllergyIntolleranceReactionSubstance')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('manifestation', 'AllergyIntolleranceReaction_ibfk_3')->references('Code')->on('AllergyIntolleranceReactionManifestation')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('severity', 'AllergyIntolleranceReaction_ibfk_4')->references('Code')->on('AllergyIntolleranceReactionSeverity')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('exposureRoute', 'AllergyIntolleranceReaction_ibfk_5')->references('Code')->on('AllergyIntolleranceReactionExposureRoute')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('AllergyIntolleranceReaction', function(Blueprint $table)
		{
			$table->dropForeign('AllergyIntolleranceReaction_ibfk_1');
			$table->dropForeign('AllergyIntolleranceReaction_ibfk_2');
			$table->dropForeign('AllergyIntolleranceReaction_ibfk_3');
			$table->dropForeign('AllergyIntolleranceReaction_ibfk_4');
			$table->dropForeign('AllergyIntolleranceReaction_ibfk_5');
		});
	}

}
