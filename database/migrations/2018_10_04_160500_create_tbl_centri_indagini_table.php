<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblCentriIndaginiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_centri_indagini', function(Blueprint $table)
		{
			$table->increments('id_centro');
			$table->smallInteger('id_tipologia')->index('fk_tbl_centri_indagini_tbl_centri_tipologie1_idx');
			$table->integer('id_comune')->unsigned()->index('fk_tbl_centri_indagini_tbl_comuni1_idx');
			$table->integer('id_ccp_persona')->unsigned()->index('fk_tbl_centri_indagini_tbl_cpp_persona1_idx');
			$table->string('centro_nome', 80)->nullable();
			$table->string('centro_indirizzo', 100)->nullable();
			$table->string('centro_mail', 50)->nullable();
			$table->boolean('centro_resp');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_centri_indagini');
	}

}
