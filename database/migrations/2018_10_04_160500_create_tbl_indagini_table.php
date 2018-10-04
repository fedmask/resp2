<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblIndaginiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_indagini', function(Blueprint $table)
		{
			$table->increments('id_indagine');
			$table->integer('id_centro_indagine')->unsigned()->nullable()->index('fk_tbl_indagini_tbl_centri_indagini1_idx');
			$table->integer('id_diagnosi')->unsigned()->nullable()->index('id_diagnosi');
			$table->integer('id_paziente')->unsigned()->index('id_paziente');
			$table->integer('id_cpp')->unsigned()->nullable()->index('id_cpp');
			$table->text('careprovider', 65535)->nullable();
			$table->date('indagine_data');
			$table->date('indagine_aggiornamento');
			$table->string('indagine_stato', 12)->nullable();
			$table->text('indagine_tipologia', 65535)->nullable();
			$table->text('indagine_motivo', 65535)->nullable();
			$table->text('indagine_referto', 65535)->nullable();
			$table->text('indagine_allegato', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_indagini');
	}

}
