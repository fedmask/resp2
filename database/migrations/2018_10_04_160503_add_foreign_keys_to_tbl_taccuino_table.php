<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblTaccuinoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_taccuino', function(Blueprint $table)
		{
			$table->foreign('id_paziente', 'fk_tbl_taccuino_tbl_pazienti1_idx')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_taccuino', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_taccuino_tbl_pazienti1_idx');
		});
	}

}
