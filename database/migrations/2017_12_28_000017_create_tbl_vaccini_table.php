<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateTblVacciniTable extends Migration {
	/**
	 * Schema table name to migrate
	 *
	 * @var string
	 */
	public $set_schema_table = 'tbl_vaccini';
	
	/**
	 * Run the migrations.
	 * @table tbl_vaccini
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable ( $this->set_schema_table ))
			return;
		Schema::create ( $this->set_schema_table, function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments ( 'id_vaccino' )->unsigned ();
			$table->integer('id_vaccinazione')->unsigned();
			$table->string ( 'vaccino_codice', 7 );
			$table->text ( 'vaccino_descrizione' );
			$table->text ( 'vaccino_nome' );
			$table->integer ( 'vaccino_durata' );
			$table->string ( 'vaccino_manufactured', 45 );
			$table->date ( 'vaccino_expirationDate' );
			
			
			$table->foreign('id_vaccinazione', 'fk_tbl_vaccino_tbl_vaccinazione1_idx')
			->references('id_vaccinazione')->on('tbl_vaccinazione')
			->onDelete('no action')
			->onUpdate('no action');
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
