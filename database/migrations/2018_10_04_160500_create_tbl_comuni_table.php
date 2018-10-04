<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblComuniTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_comuni', function(Blueprint $table)
		{
			$table->increments('id_comune');
			$table->integer('id_comune_nazione')->unsigned()->index('id_comune_nazione');
			$table->string('comune_nominativo', 45)->nullable();
			$table->char('comune_cap', 5)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_comuni');
	}

}
