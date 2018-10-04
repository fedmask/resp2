<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblCentriTipologieTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_centri_tipologie', function(Blueprint $table)
		{
			$table->foreign('code_fhir', 'tbl_centri_tipologie_ibfk_1')->references('Code')->on('OrganizationType')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_centri_tipologie', function(Blueprint $table)
		{
			$table->dropForeign('tbl_centri_tipologie_ibfk_1');
		});
	}

}
