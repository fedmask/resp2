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
			$table->foreign('assegnazione_confidenzialita', 'fk_tbl_medici_assegnati_tbl_livelli_confidenzialita1_idx')->references('id_livello_confidenzialita')->on('tbl_livelli_confidenzialita')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_cpp', 'tbl_cpp_paziente_ibfk_1')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('id_paziente', 'tbl_cpp_paziente_ibfk_2')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
			$table->dropForeign('fk_tbl_medici_assegnati_tbl_livelli_confidenzialita1_idx');
			$table->dropForeign('tbl_cpp_paziente_ibfk_1');
			$table->dropForeign('tbl_cpp_paziente_ibfk_2');
		});
	}

}
