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
			$table->string('codice_loinc', 10)->primary();
			$table->string('loinc_classe', 100);
			$table->string('loinc_componente', 100);
			$table->string('loinc_proprieta', 10);
			$table->string('loinc_temporizzazione', 10);
			$table->string('loinc_sistema', 50);
			$table->string('loinc_scala', 5);
			$table->string('loinc_metodo', 25);
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
