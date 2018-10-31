<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTrattamentiCPTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Trattamenti_CP', function(Blueprint $table)
		{
			$table->integer('Id_Trattamento')->unsigned()->primary();
			$table->string('Nome_T')->unique();
			$table->string('Finalita_T');
			$table->string('Modalita_T');
			$table->string('Informativa');
			$table->string('Incaricati');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Trattamenti_CP');
	}

}
