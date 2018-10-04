<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToATCSottogruppoTerapeuticoFTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ATC_Sottogruppo_Terapeutico_F', function(Blueprint $table)
		{
			$table->foreign('ID_Gruppo_Terapeutico', 'FOREIGN_SottogruppoT_GruppoT_idx')->references('Codice_Gruppo_Teraputico')->on('ATC_Gruppo_Terapeutico_P')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ATC_Sottogruppo_Terapeutico_F', function(Blueprint $table)
		{
			$table->dropForeign('FOREIGN_SottogruppoT_GruppoT_idx');
		});
	}

}
