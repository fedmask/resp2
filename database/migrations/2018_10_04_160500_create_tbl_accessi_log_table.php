<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblAccessiLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_accessi_log', function(Blueprint $table)
		{
			$table->increments('accesso_ip')->comment('IPV4 & IPV6
');
			$table->boolean('accesso_contatore')->default(0);
			$table->dateTime('accesso_data');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_accessi_log');
	}

}
