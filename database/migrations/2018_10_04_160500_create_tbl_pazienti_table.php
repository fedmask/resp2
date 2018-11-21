<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblPazientiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_pazienti', function(Blueprint $table)
		{
			$table->increments('id_paziente');
			$table->integer('id_utente')->unsigned()->index('FOREIGN_UTENTE_idx')->onDelete('cascade');
			$table->string('id_stato_matrimoniale', 5)->index('id_stato_matrimoniale');
			$table->longText('paziente_nome')->nullable();
			$table->longText('paziente_cognome')->nullable();
			$table->date('paziente_nascita');
			$table->char('paziente_codfiscale', 16)->nullable()->unique('paziente_codfiscale_UNIQUE');
			$table->char('paziente_sesso', 10)->index('paziente_sesso');
			$table->longText('paziente_gruppo')->nullable();
			$table->longText('paziente_rh')->nullable();
			$table->boolean('paziente_donatore_organi')->nullable();
			$table->string('paziente_lingua', 5)->index('paziente_lingua');
		});
	}
	

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_pazienti');
	}

}
