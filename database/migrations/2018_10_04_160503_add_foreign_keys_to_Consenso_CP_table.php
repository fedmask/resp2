<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToConsensoCPTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Consenso_CP', function(Blueprint $table)
		{
			$table->foreign('Id_Trattamento', 'Consenso_CP_ibfk_1')->references('Id_Trattamento')->on('Trattamenti_CP')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('Id_Cpp', 'Consenso_CP_ibfk_2')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('Consenso_CP', function(Blueprint $table)
		{
			$table->dropForeign('Consenso_CP_ibfk_1');
			$table->dropForeign('Consenso_CP_ibfk_2');
		});
	}

}
