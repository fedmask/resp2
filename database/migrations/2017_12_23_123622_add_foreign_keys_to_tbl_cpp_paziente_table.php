<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblCppPazienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_cpp_paziente', function(Blueprint $table)
		{
			$table->foreign('assegnazione_confidenzialita', 'fk_tbl_medici_assegnati_tbl_livelli_confidenzialita')->references('id_livello_confidenzialita')->on('tbl_livelli_confidenzialita')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_cpp', 'fk_tbl_medici_assegnati_tbl_medici')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_paziente', 'fk_tbl_medici_assegnati_tbl_pazienti')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_cpp_paziente', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_medici_assegnati_tbl_livelli_confidenzialita');
			$table->dropForeign('fk_tbl_medici_assegnati_tbl_medici');
			$table->dropForeign('fk_tbl_medici_assegnati_tbl_pazienti');
		});
	}

}
