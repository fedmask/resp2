<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContattoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Contatto', function(Blueprint $table)
		{
		    $table->foreign('id_paziente', 'Contatto_ibfk_1')->references('id_paziente')->on('tbl_pazienti')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		    $table->foreign('relazione', 'Contatto_ibfk_4')->references('Code')->on('RelationshipType')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		    $table->foreign('sesso', 'Contatto_ibfk_3')->references('Code')->on('Gender')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('Contatto', function(Blueprint $table)
		{
			$table->dropForeign('Contatto_ibfk_1');
			$table->dropForeign('Contatto_ibfk_2');
		});
	}

}
