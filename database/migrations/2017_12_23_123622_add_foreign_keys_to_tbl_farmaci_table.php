<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTblFarmaciTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tbl_farmaci', function(Blueprint $table)
		{
			$table->foreign('id_categoria_farmaco', 'fk_tbl_farmaci_tbl_farmaci_categorie')->references('id_categoria')->on('tbl_farmaci_categorie')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tbl_farmaci', function(Blueprint $table)
		{
			$table->dropForeign('fk_tbl_farmaci_tbl_farmaci_categorie');
		});
	}

}
