<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPatientContactTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('PatientContact', function(Blueprint $table)
		{
			$table->foreign('Id_Patient', 'PatientContact_ibfk_1')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('Relationship', 'PatientContact_ibfk_2')->references('Code')->on('ContactRelationship')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('PatientContact', function(Blueprint $table)
		{
			$table->dropForeign('PatientContact_ibfk_1');
			$table->dropForeign('PatientContact_ibfk_2');
		});
	}

}
