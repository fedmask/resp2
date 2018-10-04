<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDispositivoImpiantabileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('DispositivoImpiantabile', function(Blueprint $table)
		{
			$table->foreign('stato', 'DispositivoImpiantabile_ibfk_1')->references('Code')->on('DeviceStatus')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_dispositivo', 'DispositivoImpiantabile_ibfk_2')->references('id_dispositivo')->on('DispositivoMedico')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_paziente', 'DispositivoImpiantabile_ibfk_3')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_cpp', 'DispositivoImpiantabile_ibfk_4')->references('id_cpp')->on('tbl_care_provider')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('DispositivoImpiantabile', function(Blueprint $table)
		{
			$table->dropForeign('DispositivoImpiantabile_ibfk_1');
			$table->dropForeign('DispositivoImpiantabile_ibfk_2');
			$table->dropForeign('DispositivoImpiantabile_ibfk_3');
			$table->dropForeign('DispositivoImpiantabile_ibfk_4');
		});
	}

}
