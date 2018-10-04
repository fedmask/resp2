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
			$table->increments('id_diagnosi');
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_diagnosi_tbl_pazienti1_idx');
			$table->string('verificationStatus', 20)->index('verificationStatus');
			$table->string('severity', 30)->index('severity');
			$table->string('code', 10)->index('code');
			$table->string('bodySite', 10)->index('bodySite');
			$table->string('stageSummary', 10)->index('stageSummary');
			$table->string('evidenceCode', 10)->index('evidenceCode');
			$table->smallInteger('diagnosi_confidenzialita')->index('fk_tbl_diagnosi_tbl_livelli_confidenzialita1_idx');
			$table->date('diagnosi_inserimento_data');
			$table->date('diagnosi_aggiornamento_data');
			$table->text('diagnosi_patologia', 65535)->nullable();
			$table->string('diagnosi_stato', 15)->index('diagnosi_stato');
			$table->date('diagnosi_guarigione_data');
			$table->string('note');
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
