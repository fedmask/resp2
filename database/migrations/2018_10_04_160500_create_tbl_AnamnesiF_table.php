<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblAnamnesiFTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_AnamnesiF', function(Blueprint $table)
		{
			$table->increments('id_anamnesiF');
			$table->text('descrizione', 65535)->nullable();
			$table->integer('id_paziente')->unsigned()->index('FOREIGN_Anamnesi_Parente_I2');
			$table->integer('id_parente')->unsigned()->index('FOREIGN_Anamnesi_Parente_I1');
			$table->string('status', 20)->nullable()->index('status');
			$table->string('notDoneReason', 10)->nullable();
			$table->text('note', 65535)->nullable();
			$table->date('data');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_AnamnesiF');
	}

}
