<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_emergency', function (Blueprint $table) {
            $table->increments('id_emer');
            $table->integer('id_utente')->unsigned()->index('id_utente');
            $table->string('emer_nome', 45)->nullable();
            $table->string('emer_cognome', 45)->nullable();
            $table->date('emer_nascita_data');
            $table->char('emer_codfiscale', 16)->nullable()->unique('cpp_codfiscale_UNIQUE');
            $table->char('emer_sesso', 10)->index('cpp_sesso');
            $table->string('emer_n_iscrizione', 7)->nullable();
            $table->string('emer_localita_iscrizione', 50)->nullable();
            $table->string('specializzation', 45)->nullable();
            $table->string('emer_lingua', 10)->nullable()->index('cpp_lingua');
            $table->boolean('active')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_emergency');
    }
}
