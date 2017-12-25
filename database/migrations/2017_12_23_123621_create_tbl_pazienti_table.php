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
	    
	    if (!Schema::hasTable('tbl_pazienti')) {
	        
    		Schema::create('tbl_pazienti', function(Blueprint $table)
    		{
    			$table->integer('id_paziente', true);
    			$table->integer('id_utente')->unsigned()->index('FOREIGN_UTENTE_idx');
    			$table->smallInteger('id_stato_matrimoniale')->index('fk_tbl_pazienti_tbl_stati_matrimoniali1_idx');
    			$table->string('paziente_nome', 45);
    			$table->string('paziente_cognome', 45);
    			$table->date('paziente_nascita');
    			$table->char('paziente_codfiscale', 16)->unique('paziente_codfiscale_UNIQUE');
    			$table->char('paziente_sesso', 1);
    			$table->boolean('paziente_gruppo');
    			$table->char('pazinte_rh', 3);
    			$table->boolean('paziente_donatore_organi');
    		});
	    }
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
