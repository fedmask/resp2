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
			$table->increments('id_visita');
			$table->integer('id_cpp')->unsigned()->index('id_cpp');
			$table->integer('id_paziente')->unsigned()->index('id_paziente');
			$table->date('visita_data');
			$table->string('visita_motivazione', 100)->nullable();
			$table->text('visita_osservazioni', 65535)->nullable();
			$table->text('visita_conclusioni', 65535)->nullable();
			$table->text('stato_visita', 65535)->nullable();
			$table->integer('codice_priorit')->unsigned();
			$table->text('tipo_richiesta', 65535)->nullable();
			$table->text('status', 65535)->nullable();
			$table->date('richiesta_visita_inizio')->nullable();
			$table->date('richiesta_visita_fine')->nullable();
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
