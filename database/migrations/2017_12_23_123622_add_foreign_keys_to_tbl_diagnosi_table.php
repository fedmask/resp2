<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblDiagnosiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_diagnosi', function(Blueprint $table)
		{
			$table->foreign('diagnosi_confidenzialita', 'fk_tbl_diagnosi_tbl_livelli_confidenzialita')->references('id_livello_confidenzialita')->on('tbl_livelli_confidenzialita')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_paziente', 'fk_tbl_diagnosi_tbl_pazienti1')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_diagnosi', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_diagnosi_tbl_livelli_confidenzialita');
			$table->dropForeign('fk_tbl_diagnosi_tbl_pazienti1');
		});
	}

}
