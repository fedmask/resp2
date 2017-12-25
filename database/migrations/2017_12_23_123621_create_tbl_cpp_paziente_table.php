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
			$table->integer('id_cpp')->index('fk_tbl_medici_assegnati_tbl_medici1_idx');
			$table->integer('id_paziente')->index('fk_tbl_medici_assegnati_tbl_pazienti1_idx');
			$table->smallInteger('assegnazione_confidenzialita')->index('fk_tbl_medici_assegnati_tbl_livelli_confidenzialita1_idx');
			$table->primary(['id_cpp','id_paziente']);
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
