<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateATCGruppoTerapeuticoPTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ATC_Gruppo_Terapeutico_P', function(Blueprint $table)
		{
			$table->char('Codice_Gruppo_Teraputico', 3)->primary();
			$table->char('Codice_GTP', 2)->nullable();
			$table->timestamps();
			$table->string('Descrizione', 45)->nullable();
			$table->char('ID_Gruppo_Anatomico', 1)->nullable()->index('FOREIGN_GruppoT_GruppoA_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ATC_Gruppo_Terapeutico_P');
	}

}
