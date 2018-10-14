<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFamilyMemberHistoryStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('FamilyMemberHistoryStatus', function(Blueprint $table)
		{
			$table->string('Code', 20)->primary();
			$table->string('Display', 150);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('FamilyMemberHistoryStatus');
	}

}
