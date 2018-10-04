<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToATCGruppoTerapeuticoPTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ATC_Gruppo_Terapeutico_P', function(Blueprint $table)
		{
			$table->foreign('ID_Gruppo_Anatomico', 'FOREIGN_GruppoT_GruppoA_idx')->references('ID_Gruppo_Anatomico')->on('tbl_Gruppo_Anatomico_P')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ATC_Gruppo_Terapeutico_P', function(Blueprint $table)
		{
			$table->dropForeign('FOREIGN_GruppoT_GruppoA_idx');
		});
	}

}
