<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Documenti', function(Blueprint $table)
		{
			$table->integer('Id_Documento')->unsigned()->primary();
			$table->longText('Tipo')->nullable();
			$table->integer('Id_Amministratore')->unsigned()->index('Id_Amministratore');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Documenti');
	}

}
