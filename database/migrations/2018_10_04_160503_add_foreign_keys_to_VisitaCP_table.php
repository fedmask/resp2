<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
class AddForeignKeysToVisitaCPTable extends Migration {
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table ( 'VisitaCP', function (Blueprint $table) {
			$table->foreign ( 'id_cpp', 'VisitaCP_ibfk_1' )->references ( 'id_cpp' )->on ( 'tbl_care_provider' )->onUpdate ( 'NO ACTION' )->onDelete ( 'CASCADE' );
			$table->foreign ( 'id_visita', 'VisitaCP_ibfk_2' )->references ( 'id_visita' )->on ( 'tbl_pazienti_visite' )->onUpdate ( 'NO ACTION' )->onDelete ( 'NO ACTION' );
			$table->foreign ( 'tipo', 'VisitaCP_ibfk_3' )->references ( 'Code' )->on ( 'EncounterParticipantType' )->onUpdate ( 'NO ACTION' )->onDelete ( 'NO ACTION' );
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table ( 'VisitaCP', function (Blueprint $table) {
			$table->dropForeign ( 'VisitaCP_ibfk_1' );
			$table->dropForeign ( 'VisitaCP_ibfk_2' );
			$table->dropForeign ( 'VisitaCP_ibfk_3' );
		} );
	}
}
