<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblCentriIndaginiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_centri_indagini', function(Blueprint $table)
		{
			$table->foreign('id_tipologia', 'fk_tbl_centri_indagini_tbl_centri_tipologie1_idx')->references('id_centro_tipologia')->on('tbl_centri_tipologie')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_comune', 'fk_tbl_centri_indagini_tbl_comuni1_idx')->references('id_comune')->on('tbl_comuni')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_ccp_persona', 'fk_tbl_centri_indagini_tbl_cpp_persona1_idx')->references('id_persona')->on('tbl_cpp_persona')->onUpdate('NO ACTION')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_centri_indagini', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_centri_indagini_tbl_centri_tipologie1_idx');
			$table->dropForeign('fk_tbl_centri_indagini_tbl_comuni1_idx');
			$table->dropForeign('fk_tbl_centri_indagini_tbl_cpp_persona1_idx');
		});
	}

}
