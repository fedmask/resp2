<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblComuniTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_comuni', function(Blueprint $table)
		{
			$table->foreign('id_comune_nazione', 'tbl_comuni_ibfk_1')->references('id_nazione')->on('tbl_nazioni')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_comuni', function(Blueprint $table)
		{
			$table->dropForeign('tbl_comuni_ibfk_1');
		});
	}

}
