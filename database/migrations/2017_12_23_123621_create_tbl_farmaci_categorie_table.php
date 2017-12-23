<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblFarmaciCategorieTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_farmaci_categorie', function(Blueprint $table)
		{
			$table->string('id_categoria', 6)->primary();
			$table->string('categoria_descrizione', 120);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_farmaci_categorie');
	}

}
