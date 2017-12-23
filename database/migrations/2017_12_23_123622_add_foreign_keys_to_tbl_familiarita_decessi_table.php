<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblFamiliaritaDecessiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_familiarita_decessi', function(Blueprint $table)
		{
			$table->foreign('id_paziente', 'fk_tbl_familiarita_decessi_tbl_pazienti_familiarita')->references('id_familiarita')->on('tbl_pazienti_familiarita')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_familiarita_decessi', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_familiarita_decessi_tbl_pazienti_familiarita');
		});
	}

}
