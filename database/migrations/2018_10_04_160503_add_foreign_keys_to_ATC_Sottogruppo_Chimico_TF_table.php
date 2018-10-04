<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToATCSottogruppoChimicoTFTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ATC_Sottogruppo_Chimico_TF', function(Blueprint $table)
		{
			$table->foreign('ID_Sottogruppo_Terapeutico', 'FOREIGN_SottogruppoCFT_SottogruppoTF_idx')->references('id_sottogruppoTF')->on('ATC_Sottogruppo_Terapeutico_F')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ATC_Sottogruppo_Chimico_TF', function(Blueprint $table)
		{
			$table->dropForeign('FOREIGN_SottogruppoCFT_SottogruppoTF_idx');
		});
	}

}
