<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblCareProviderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_care_provider', function(Blueprint $table)
		{
			$table->foreign('id_utente', 'tbl_care_provider_ibfk_1')->references('id_utente')->on('tbl_utenti')->onUpdate('NO ACTION')->onDelete('cascade');
			$table->foreign('cpp_lingua', 'tbl_care_provider_ibfk_2')->references('Code')->on('Languages')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('cpp_sesso', 'tbl_care_provider_ibfk_3')->references('Code')->on('Gender')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_care_provider', function(Blueprint $table)
		{
			$table->dropForeign('tbl_care_provider_ibfk_1');
			$table->dropForeign('tbl_care_provider_ibfk_2');
			$table->dropForeign('tbl_care_provider_ibfk_3');
		});
	}

}
