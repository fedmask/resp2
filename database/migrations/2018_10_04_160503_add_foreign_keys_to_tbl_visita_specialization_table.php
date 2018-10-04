<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblVisitaSpecializationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_visita_specialization', function(Blueprint $table)
		{
			$table->foreign('id_specialization', 'FOREIGN_Specialization_idx')->references('id_spec')->on('tbl_specialization')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_visita', 'tbl_visita_specialization_ibfk_1')->references('id_visita')->on('tbl_pazienti_visite')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_visita_specialization', function(Blueprint $table)
		{
			$table->dropForeign('FOREIGN_Specialization_idx');
			$table->dropForeign('tbl_visita_specialization_ibfk_1');
		});
	}

}
