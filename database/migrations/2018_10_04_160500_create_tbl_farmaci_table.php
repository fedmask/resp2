<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblFarmaciTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_farmaci', function(Blueprint $table)
		{
			$table->string('id_farmaco', 8)->nullable()->index('fk_tbl_farmaci_tbl_farmaci_vietati_idx');
			$table->string('id_categoria_farmaco', 6)->nullable()->index('fk_tbl_farmaci_tbl_farmaci_categorie1_idx');
			$table->longText('farmaco_nome')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_farmaci');
	}

}
