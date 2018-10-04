<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateATCSottogruppoTerapeuticoFTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ATC_Sottogruppo_Terapeutico_F', function(Blueprint $table)
		{
			$table->char('id_sottogruppoTF', 4)->primary();
			$table->char('Codice_Gruppo_Teraputico', 1)->nullable();
			$table->timestamps();
			$table->string('Descrizione', 45)->nullable();
			$table->char('ID_Gruppo_Terapeutico', 3)->nullable()->index('FOREIGN_SottogruppoT_GruppoT_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ATC_Sottogruppo_Terapeutico_F');
	}

}
