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
			$table->string('id_farmaco', 8)->primary();
			$table->string('id_categoria_farmaco', 6)->index('fk_tbl_farmaci_tbl_farmaci_categorie1_idx');
			$table->string('farmaco_nome', 50);
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
