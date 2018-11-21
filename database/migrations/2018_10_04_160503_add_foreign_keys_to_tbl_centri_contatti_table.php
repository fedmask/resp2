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
			$table->foreign('id_centro', 'fk_tbl_centri_contatti_tbl_centri_indagini1_idx')->references('id_centro')->on('tbl_centri_indagini')->onUpdate('NO ACTION')->onDelete('cascade');
			$table->foreign('id_modalita_contatto', 'fk_tbl_centri_contatti_tbl_modalita_contatti1_idx')->references('id_modalita')->on('tbl_modalita_contatti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
			$table->dropForeign('fk_tbl_centri_contatti_tbl_centri_indagini1_idx');
			$table->dropForeign('fk_tbl_centri_contatti_tbl_modalita_contatti1_idx');
		});
	}

}
