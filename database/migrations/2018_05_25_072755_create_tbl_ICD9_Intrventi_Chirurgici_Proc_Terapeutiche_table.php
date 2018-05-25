<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateTblICD9IntrventiChirurgiciProcTerapeuticheTable extends Migration {
	public $set_schema_table = 'Tbl_ICD9_ICPT';
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable ( $this->set_schema_table ))
			return;
		Schema::create ( $this->set_schema_table, function (Blueprint $table) {
			
			// $table->increments('id_ICD9_IntrventiChirurgici_ProcTerapeutiche');
			$table->string ( 'Codice_ICD9', 5 )->unique ();
			$table->char ( 'IDPT_Organo', 2 )->nullable ( false );
			$table->string ( 'IDPT_ST', 2 )->nullable ( false );
			$table->string ( 'Descizione_ICD9', 45 );
			$table->engine = 'InnoDB';
			$table->primary ( 'Codice_ICD9' );
			
			$table->foreign ( 'IDPT_Organo' )->references ( 'id_IDPT_Organo' )->on ( 'tbl_ICD9_IDPT_Organi' )->onDelete ( 'no action' )->onUpdate ( 'no action' );
			
			$table->foreign ( 'IDPT_ST' )->references('id_IDPT_ST')->on ( 'tbl_ICD9_IDPT_ST' )->onDelete ( 'no action' )->onUpdate ( 'no action' );
		} );
		//
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'Tbl_ICD9_ICPT' );
		//
	}
}
