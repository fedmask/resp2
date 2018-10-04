<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblFamilyCondictionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_FamilyCondiction', function(Blueprint $table)
		{
			$table->increments('id_Condition');
			$table->string('code_fhir', 10)->index('code_fhir');
			$table->string('Codice_ICD9', 5)->nullable()->index('FOREIGN_Diagn_Condition');
			$table->string('outCome', 10)->nullable()->index('outCome');
			$table->integer('id_parente')->unsigned()->index('FOREIGN_Parente_Condition');
			$table->boolean('onSetAge')->default(1);
			$table->integer('onSetAgeRange_low');
			$table->integer('onSetAgeRange_hight');
			$table->integer('onSetAgeValue');
			$table->text('Note', 65535)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_FamilyCondiction');
	}

}
