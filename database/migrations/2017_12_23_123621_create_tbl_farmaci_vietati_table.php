<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblFarmaciVietatiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_farmaci_vietati', function(Blueprint $table)
		{
			$table->integer('id_farmaco_vietato', true);
			$table->integer('id_paziente')->unsigned()->index('fk_tbl_farmaci_vietati_tbl_pazienti1_idx');
			$table->string('id_farmaco', 8)->index('fk_tbl_farmaci_vietati_tbl_farmaci1_idx');
			$table->text('farmaco_vietato_motivazione', 65535);
			$table->smallInteger('farmaco_vietato_confidenzialita')->index('fk_tbl_farmaci_vietati_tbl_livelli_confidenzialita1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_farmaci_vietati');
	}

}
