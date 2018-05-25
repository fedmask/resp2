<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblIDPTSedeTipoInterventoTable extends Migration
{
	public $set_schema_table = 'tbl_ICD9_IDPT_ST';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->set_schema_table, function (Blueprint $table) {
			$table->engine = 'InnoDB';
			
			
			$table->string('id_IDPT_ST', 2)->unique();
			$table->string ( 'descrizione_sede', 45 );
			$table->string ( 'descrizione_tipo_intervento', 45);
			$table->primary('id_IDPT_ST');
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('tbl_ICD9_IDPT_ST');
	}
	
}
