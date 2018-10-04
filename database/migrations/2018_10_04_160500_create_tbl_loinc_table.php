<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblLoincTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_loinc', function(Blueprint $table)
		{
			$table->string('codice_loinc', 10)->nullable()->index('fk_tbl_loinc_tbl_loinc1_idx');
			$table->string('loinc_classe', 100)->nullable();
			$table->string('loinc_componente', 100)->nullable();
			$table->string('loinc_proprieta', 10)->nullable();
			$table->string('loinc_temporizzazione', 10)->nullable();
			$table->string('loinc_sistema', 50)->nullable();
			$table->string('loinc_scala', 5)->nullable();
			$table->string('loinc_metodo', 25)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_loinc');
	}

}
