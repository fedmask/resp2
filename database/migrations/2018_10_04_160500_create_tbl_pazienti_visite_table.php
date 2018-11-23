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
			$table->integer('id_paziente')->unsigned()->index('id_paziente');
			$table->string('status')->index('status');
			$table->string('class')->index('class');
			$table->date('start_period');
			$table->date('end_period');
			$table->string('reason')->index('reason');
			$table->integer('id_cpp')->unsigned()->index('id_cpp');
			$table->date('visita_data');
			$table->longText('visita_motivazione')->nullable();
			$table->longText('visita_osservazioni')->nullable();
			$table->longText('visita_conclusioni')->nullable();
			$table->longText('stato_visita')->nullable();
			$table->integer('codice_priorita')->unsigned();
			$table->longtext('tipo_richiesta')->nullable();
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
