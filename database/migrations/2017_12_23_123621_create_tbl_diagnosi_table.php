<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblDiagnosiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_diagnosi', function(Blueprint $table)
		{
			$table->integer('id_diagnosi', true);
			$table->integer('id_paziente')->index('fk_tbl_diagnosi_tbl_pazienti1_idx');
			$table->smallInteger('diagnosi_confidenzialita')->index('fk_tbl_diagnosi_tbl_livelli_confidenzialita1_idx');
			$table->date('diagnosi_inserimento_data');
			$table->date('diagnosi_aggiornamento_data');
			$table->text('diagnosi_patologia', 65535);
			$table->boolean('diagnosi_stato');
			$table->date('diagnosi_guarigione_data');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_diagnosi');
	}

}
