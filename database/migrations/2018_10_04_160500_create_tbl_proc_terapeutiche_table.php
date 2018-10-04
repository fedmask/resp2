<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblProcTerapeuticheTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_proc_terapeutiche', function(Blueprint $table)
		{
			$table->increments('id_Procedure_Terapeutiche');
			$table->string('descrizione', 45)->nullable();
			$table->date('Data_Esecuzione');
			$table->integer('Paziente')->unsigned()->index('Paziente');
			$table->integer('Diagnosi')->unsigned()->index('Diagnosi');
			$table->integer('CareProvider')->unsigned()->index('fk_tb_cpp_tb_procedure_treapeutiche');
			$table->string('Codice_icd9', 7)->nullable()->index('fk_tb_icd9_tb_procedure_treapeutiche');
			$table->string('Status', 20)->nullable()->index('fk_tb_proc_status');
			$table->string('code', 10)->nullable()->index('code');
			$table->string('reasonCode', 10)->nullable()->index('reasonCode');
			$table->string('bodySite', 10)->nullable()->index('bodySite');
			$table->string('followUp', 10)->nullable()->index('followUp');
			$table->string('notDoneReason', 20)->index('notDoneReason');
			$table->string('complication', 20)->index('complication');
			$table->integer('Category')->unsigned()->index('fk_tb_proc_category');
			$table->integer('outCome')->unsigned()->index('fk_tb_proc_outcome');
			$table->text('note', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_proc_terapeutiche');
	}

}
