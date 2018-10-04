<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFarmaciAssuntiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('farmaci_assunti', function(Blueprint $table)
		{
			$table->foreign('id_paziente', 'farmaci_assunti_ibfk_1')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_farmaco', 'farmaci_assunti_ibfk_2')->references('Code')->on('MedicationCode')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('status', 'farmaci_assunti_ibfk_3')->references('Code')->on('MedicationStatus')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('form', 'farmaci_assunti_ibfk_4')->references('Code')->on('MedicationForm')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('farmaci_assunti', function(Blueprint $table)
		{
			$table->dropForeign('farmaci_assunti_ibfk_1');
			$table->dropForeign('farmaci_assunti_ibfk_2');
			$table->dropForeign('farmaci_assunti_ibfk_3');
			$table->dropForeign('farmaci_assunti_ibfk_4');
		});
	}

}
