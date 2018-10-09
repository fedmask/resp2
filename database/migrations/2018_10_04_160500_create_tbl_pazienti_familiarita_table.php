<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblPazientiFamiliaritaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_pazienti_familiarita', function(Blueprint $table)
		{
			$table->increments('id_familiarita');
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_pazienti_familiarita_tbl_pazienti1_idx');
			$table->integer('id_parente')->unsigned()->index('fk_tbl_pazienti_familiarita_tbl_utenti1_idx');
			$table->string('relazione', 10)->index('relazione');
			$table->string('familiarita_grado_parentela', 25)->nullable();
			$table->date('familiarita_aggiornamento_data');
			$table->boolean('familiarita_conferma')->default(0);
			
			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_pazienti_familiarita');
	}

}
