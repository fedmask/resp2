<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToATCSottogruppoChimicoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ATC_Sottogruppo_Chimico', function(Blueprint $table)
		{
			$table->foreign('ID_Sottogruppo_CTF', 'FOREIGN_SottogruppoC_SottogruppoCTF_idx')->references('id_sottogruppoCTF')->on('ATC_Sottogruppo_Chimico_TF')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ATC_Sottogruppo_Chimico', function(Blueprint $table)
		{
			$table->dropForeign('FOREIGN_SottogruppoC_SottogruppoCTF_idx');
		});
	}

}
