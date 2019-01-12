<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHbMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hb_meters', function (Blueprint $table) {
            $table->increments('id_hbmeter');
            $table->integer('id_utente')->unsigned()->index('FOREIGN_UTENTE_idx')->onDelete('cascade');
            $table->string('analisi_giorno');
            $table->float('analisi_valore');
            $table->float('analisi_laboratorio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hb_meters');
    }
}
