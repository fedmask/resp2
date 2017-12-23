<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblFarmaciVietatiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_farmaci_vietati', function(Blueprint $table)
		{
			$table->foreign('id_farmaco', 'fk_tbl_farmaci_vietati_tbl_farmaci')->references('id_farmaco')->on('tbl_farmaci')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('farmaco_vietato_confidenzialita', 'fk_tbl_farmaci_vietati_tbl_livelli_confidenzialita')->references('id_livello_confidenzialita')->on('tbl_livelli_confidenzialita')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_paziente', 'fk_tbl_farmaci_vietati_tbl_pazienti')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_farmaci_vietati', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_farmaci_vietati_tbl_farmaci');
			$table->dropForeign('fk_tbl_farmaci_vietati_tbl_livelli_confidenzialita');
			$table->dropForeign('fk_tbl_farmaci_vietati_tbl_pazienti');
		});
	}

}
