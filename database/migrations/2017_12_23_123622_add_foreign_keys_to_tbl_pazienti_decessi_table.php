<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblPazientiDecessiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_pazienti_decessi', function(Blueprint $table)
		{
			$table->foreign('id_paziente', 'FOREIGN_PAZIENTE')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_pazienti_decessi', function(Blueprint $table)
		{
			$table->dropForeign('FOREIGN_PAZIENTE');
		});
	}

}
