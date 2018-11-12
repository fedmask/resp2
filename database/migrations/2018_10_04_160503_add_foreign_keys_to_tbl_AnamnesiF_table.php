<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblAnamnesiFTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_AnamnesiF', function(Blueprint $table)
		{
			$table->foreign('id_parente', 'FOREIGN_Anamnesi_Parente_I1')->references('id_parente')->on('tbl_Parente')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_paziente', 'FOREIGN_Anamnesi_Parente_I2')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('status', 'tbl_AnamnesiF_ibfk_1')->references('Code')->on('FamilyMemberHistoryStatus')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_AnamnesiF', function(Blueprint $table)
		{
			$table->dropForeign('FOREIGN_Anamnesi_Parente_I1');
			$table->dropForeign('FOREIGN_Anamnesi_Parente_I2');
			$table->dropForeign('tbl_AnamnesiF_ibfk_1');
		});
	}

}
