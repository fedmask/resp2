<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblAnamnesiFisiologicaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tbl_anamnesi_fisiologica', function(Blueprint $table)
		{
            $table->integer('id_paziente')->unsigned();
            $table->primary('id_paziente');
			$table->integer('id_anamnesi_log');
			$table->date('dataAggiornamento');
			$table->text('tempoParto')->nullable();
            $table->text('tipoParto')->nullable();
            $table->text('allattamento')->nullable();
            $table->text('sviluppoVegRel')->nullable();
            $table->text('noteInfanzia')->nullable();
            $table->text('livelloScol')->nullable();
            $table->text('etaMenarca')->nullable();
            $table->text('ciclo')->nullable();
            $table->text('etaMenopausa')->nullable();
            $table->text('menopausa')->nullable();
            $table->text('noteCicloMes')->nullable();
            $table->text('attivitaFisica')->nullable();
            $table->text('abitudAlim')->nullable();
            $table->text('ritmoSV')->nullable();
            $table->text('fumo')->nullable();
            $table->text('freqFumo')->nullable();
            $table->text('alcool')->nullable();
            $table->text('freqAlcool')->nullable();
            $table->text('droghe')->nullable();
            $table->text('freqDroghe')->nullable();
            $table->text('noteStileVita')->nullable();
            $table->text('alvo')->nullable();
            $table->text('minzione')->nullable();
            $table->text('noteAlvoMinz')->nullable();
            $table->text('professione')->nullable();
            $table->text('noteAttLav')->nullable();

        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tbl_anamnesi_fisiologica');
	}

}
