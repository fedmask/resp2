<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblAnamnesiPtProssimaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_anamnesi_pt_prossima', function(Blueprint $table)
		{
            $table->integer('id_paziente')->unsigned();
            $table->primary('id_paziente');
			$table->integer('id_anamnesi_log');
			$table->text('anamnesi_prossima_contenuto', 65535)->nullable();
            $table->text('icd9_group_code', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_anamnesi_pt_prossima');
	}

}
