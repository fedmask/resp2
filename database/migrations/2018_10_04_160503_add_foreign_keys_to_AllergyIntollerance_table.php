<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAllergyIntolleranceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('AllergyIntollerance', function(Blueprint $table)
		{
			$table->foreign('clinicalStatus', 'AllergyIntollerance_ibfk_1')->references('Code')->on('AllergyIntolleranceClinicalStatus')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('confidenza', 'AllergyIntollerance_ibfk_10')->references('id_livello_confidenzialita')->on('tbl_livelli_confidenzialita')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('verificationStatus', 'AllergyIntollerance_ibfk_2')->references('Code')->on('AllergyIntolleranceVerificationStatus')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('tipo', 'AllergyIntollerance_ibfk_3')->references('Code')->on('AllergyIntolleranceType')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('category', 'AllergyIntollerance_ibfk_4')->references('Code')->on('AllergyIntolleranceCategory')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('criticality', 'AllergyIntollerance_ibfk_5')->references('Code')->on('AllergyIntolleranceCriticality')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_paziente', 'AllergyIntollerance_ibfk_6')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('recorder', 'AllergyIntollerance_ibfk_7')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('recorder', 'AllergyIntollerance_ibfk_8')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('code', 'AllergyIntollerance_ibfk_9')->references('Code')->on('AllergyIntolleranceCode')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('AllergyIntollerance', function(Blueprint $table)
		{
			$table->dropForeign('AllergyIntollerance_ibfk_1');
			$table->dropForeign('AllergyIntollerance_ibfk_10');
			$table->dropForeign('AllergyIntollerance_ibfk_2');
			$table->dropForeign('AllergyIntollerance_ibfk_3');
			$table->dropForeign('AllergyIntollerance_ibfk_4');
			$table->dropForeign('AllergyIntollerance_ibfk_5');
			$table->dropForeign('AllergyIntollerance_ibfk_6');
			$table->dropForeign('AllergyIntollerance_ibfk_7');
			$table->dropForeign('AllergyIntollerance_ibfk_8');
			$table->dropForeign('AllergyIntollerance_ibfk_9');
		});
	}

}
