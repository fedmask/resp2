<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateATCSottogruppoChimicoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ATC_Sottogruppo_Chimico', function(Blueprint $table)
		{
			$table->char('Codice_ATC', 7)->primary();
			$table->char('Codice_Sottogruppo_CTF', 2)->nullable();
			$table->timestamps();
			$table->string('Descrizione', 45)->nullable();
			$table->char('ID_Sottogruppo_CTF', 5)->nullable()->index('FOREIGN_SottogruppoC_SottogruppoCTF_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ATC_Sottogruppo_Chimico');
	}

}
