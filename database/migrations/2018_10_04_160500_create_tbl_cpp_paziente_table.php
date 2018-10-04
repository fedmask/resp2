<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblCppPazienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_cpp_paziente', function(Blueprint $table)
		{
			$table->increments('id_cpp');
			$table->integer('id_paziente')->unsigned()->index('id_paziente');
			$table->smallInteger('assegnazione_confidenzialita')->index('fk_tbl_medici_assegnati_tbl_livelli_confidenzialita1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_cpp_paziente');
	}

}
