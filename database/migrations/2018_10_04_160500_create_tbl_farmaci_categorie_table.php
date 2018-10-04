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
			$table->string('id_categoria', 6)->nullable()->index('fk_tbl_farmaci_categorie_tbl_farmaci_idx');
			$table->string('categoria_descrizione', 120)->nullable();
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
