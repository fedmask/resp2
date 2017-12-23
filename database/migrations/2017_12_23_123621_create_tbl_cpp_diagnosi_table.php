<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblCppDiagnosiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_cpp_diagnosi', function(Blueprint $table)
		{
			$table->integer('id_diagnosi');
			$table->string('diagnosi_stato', 15);
			$table->integer('id_cpp')->index('fk_tbl_cpp_diagnosi_tbl_care_provider1_idx');
			$table->text('careprovider', 65535);
			$table->primary('id_diagnosi');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_cpp_diagnosi');
	}

}
