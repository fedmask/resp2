<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblCareProviderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_care_provider', function(Blueprint $table)
		{
			$table->integer('id_cpp')->primary();
			$table->smallInteger('id_cpp_tipologia')->index('fk_tbl_medici_tbl_ruoli_tipologie1_idx');
			$table->integer('id_utente')->unsigned()->index('FOREIGN_UTENTE_idx');
			$table->string('cpp_nome', 45);
			$table->string('cpp_cognome', 45);
			$table->date('cpp_nascita_data');
			$table->char('cpp_codfiscale', 16)->unique('cpp_codfiscale_UNIQUE');
			$table->char('cpp_sesso', 1);
			$table->string('cpp_n_iscrizione', 7);
			$table->string('cpp_localita_iscrizione', 50);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_care_provider');
	}

}
