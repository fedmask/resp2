<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateATCSottogruppoChimicoTFTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ATC_Sottogruppo_Chimico_TF', function(Blueprint $table)
		{
			$table->char('id_sottogruppoCTF', 5)->primary();
			$table->char('Codice_Sottogruppo_Teraputico', 1)->nullable();
			$table->timestamps();
			$table->string('Descrizione', 45)->nullable();
			$table->char('ID_Sottogruppo_Terapeutico', 4)->nullable()->index('FOREIGN_SottogruppoCFT_SottogruppoTF_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ATC_Sottogruppo_Chimico_TF');
	}

}
