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
			$table->increments('id_cpp');
			$table->integer('id_utente')->unsigned()->index('id_utente');
			$table->longText('cpp_nome')->nullable();
			$table->longText('cpp_cognome')->nullable();
			$table->date('cpp_nascita_data');
			$table->char('cpp_codfiscale', 16)->nullable()->unique('cpp_codfiscale_UNIQUE');
			$table->char('cpp_sesso', 10)->index('cpp_sesso');
			$table->longText('cpp_n_iscrizione')->nullable();
			$table->string('cpp_localita_iscrizione', 50)->nullable();
			$table->string('specializzation', 45)->nullable();
			$table->string('cpp_lingua', 10)->nullable()->index('cpp_lingua');
			$table->boolean('active')->nullable()->default(0);
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
