<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateTblVaccinazioniReactionTable extends Migration {
	public $set_schema_table = 'tbl_vaccinazioni_reaction';
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable ( $this->set_schema_table ))
			return;
		Schema::create ( $this->set_schema_table, function (Blueprint $table) {
			$table->increments ( 'id_vacc_reaction' );
			$table->timestamps ();
			$table->integer ( 'id_vaccinazione' )->unsigned ();
			$table->date ( 'date' );
			$table->integer ( 'id_centro' )->unsigned ();
			$table->boolean ( 'reported' )->default ( true );
			
			$table->foreign ( 'id_centro', 'fk_tbl_centri_indagini_tbl_reazioni' )->references ( 'id_centro' )->on ( 'tbl_centri_indagini' )->onDelete ( 'no action' )->onUpdate ( 'no action' );
			$table->foreign ( 'id_vaccinazione', 'fk_tbl_reazioni_tbl_vaccinazione' )->references ( 'id_vaccinazione' )->on ( 'tbl_vaccinazioni_reaction' )->onDelete ( 'no action' )->onUpdate ( 'no action' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( $this->set_schema_table );
	}
}
