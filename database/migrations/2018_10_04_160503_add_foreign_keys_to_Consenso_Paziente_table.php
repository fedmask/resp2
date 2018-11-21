<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToConsensoPazienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Consenso_Paziente', function(Blueprint $table)
		{
			$table->foreign('Id_Trattamento', 'Consenso_Paziente_ibfk_1')->references('Id_Trattamento')->on('Trattamenti_Pazienti')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('Id_Paziente', 'Consenso_Paziente_ibfk_2')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('Consenso_Paziente', function(Blueprint $table)
		{
			$table->dropForeign('Consenso_Paziente_ibfk_1');
			$table->dropForeign('Consenso_Paziente_ibfk_2');
		});
	}

}
