<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDispositivoMedicoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('DispositivoMedico', function(Blueprint $table)
		{
			$table->foreign('tipologia', 'DispositivoMedico_ibfk_1')->references('Code')->on('DeviceType')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('DispositivoMedico', function(Blueprint $table)
		{
			$table->dropForeign('DispositivoMedico_ibfk_1');
		});
	}

}
