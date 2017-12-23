<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblCentriContattiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_centri_contatti', function(Blueprint $table)
		{
			$table->foreign('id_centro', 'fk_tbl_centri_contatti_tbl_centri_indagini')->references('id_centro')->on('tbl_centri_indagini')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_modalita_contatto', 'fk_tbl_centri_contatti_tbl_modalita_contatti')->references('id_modalita')->on('tbl_modalita_contatti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_centri_contatti', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_centri_contatti_tbl_centri_indagini');
			$table->dropForeign('fk_tbl_centri_contatti_tbl_modalita_contatti');
		});
	}

}
