<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblGruppoAnatomicoPTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_Gruppo_Anatomico_P', function(Blueprint $table)
		{
			$table->char('ID_Gruppo_Anatomico', 1)->primary();
			$table->timestamps();
			$table->string('Descrizione', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_Gruppo_Anatomico_P');
	}

}
