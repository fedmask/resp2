<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblLoincValoriTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_loinc_valori', function(Blueprint $table)
		{
			$table->integer('id_esclab', true);
			$table->string('id_codice', 10)->index('fk_tbl_loinc_valori_tbl_loinc1_idx');
			$table->string('valore_normale', 120);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_loinc_valori');
	}

}
