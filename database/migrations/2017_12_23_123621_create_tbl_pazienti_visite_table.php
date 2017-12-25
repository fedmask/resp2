<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblPazientiVisiteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_pazienti_visite', function(Blueprint $table)
		{
			$table->string('id_visita', 45)->primary();
			$table->integer('id_cpp')->index('fk_tbl_pazienti_visite_tbl_medici1_idx');
			$table->integer('id_paziente')->index('fk_tbl_pazienti_visite_tbl_pazienti1_idx');
			$table->date('visita_data');
			$table->string('visita_motivazione', 100);
			$table->text('visita_osservazioni', 65535);
			$table->text('visita_conclusioni', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_pazienti_visite');
	}

}
