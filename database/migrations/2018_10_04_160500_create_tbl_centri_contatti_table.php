<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblCentriContattiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_centri_contatti', function(Blueprint $table)
		{
			$table->increments('id_contatto');
			$table->integer('id_centro')->unsigned()->index('fk_tbl_centri_contatti_tbl_centri_indagini1_idx');
			$table->smallInteger('id_modalita_contatto')->index('fk_tbl_centri_contatti_tbl_modalita_contatti1_idx');
			$table->longText('contatto_valore')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_centri_contatti');
	}

}
