<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePazientiTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tbl_nazioni', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id_nazione');
            $table->string('nazione_nominativo', 45);
            $table->string('nazione_prefisso_telefonico', 5);
            
            $table->primary('id_nazione');
        });
        
        Schema::create('tbl_comuni', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id_comune');
            $table->integer('id_comune_nazione');
            $table->string('comune_nominativo', 40);
            $table->char('comune_cap', 5);
            
            $table->primary('id_comune');
            $table->foreign('id_comune_nazione')->references('id_nazione')->on('tbl_nazioni');
        });
        
        Schema::create('tbl_pazienti_contatti', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id_paziente');
            $table->integer('id_comune_residenza')->nullable();
            $table->integer('id_comune_nascita');
            $table->string('paziente_telefono', 40);
            $table->string('paziente_indirizzo', 40)->nullable();
            
            $table->primary('id_paziente');
            $table->foreign('id_comune_residenza')->references('id_comune')->on('tbl_comuni');
            $table->foreign('id_comune_nascita')->references('id_comune')->on('tbl_comuni');
        });
        
        Schema::create('tbl_pazienti', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_paziente');
            $table->integer('id_utente')->unsigned();
            $table->integer('id_paziente_contatti');
            $table->string('paziente_nome', 45);
            $table->string('paziente_cognome', 45);
            $table->date('paziente_nascita');
            $table->char('paziente_codfiscale', 16);
            $table->char('paziente_sesso', 1);
            $table->string('paziente_gruppo', 3);
            $table->char('paziente_rh', 3);
            $table->tinyInteger('paziente_donatore_organi');
            $table->string('paziente_stato_matrimoniale', 30);
            
            $table->foreign('id_utente')->references('id_utente')->on('tbl_utenti');
            $table->foreign('id_paziente_contatti')->references('id_paziente')->on('tbl_pazienti_contatti');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if (Schema::hasTable('tbl_comuni')) {
            
            Schema::table('tbl_comuni', function ($table) {
                $table->dropForeign(['id_comune_nazione']);
            });
        }
        
        if (Schema::hasTable('tbl_pazienti_contatti')) {
            
            Schema::table('tbl_pazienti_contatti', function ($table) {
                $table->dropForeign(['id_comune_residenza']);
                $table->dropForeign(['id_comune_nascita']);
            });
   
        }
        
        if (Schema::hasTable('tbl_pazienti')) {
            
            Schema::table('tbl_pazienti', function ($table) {
                $table->dropForeign(['id_utente']);
                $table->dropForeign(['id_paziente_contatti']);
            });  
        }

        Schema::drop('tbl_pazienti');
        Schema::drop('tbl_pazienti_contatti');
        Schema::drop('tbl_nazioni');
        Schema::drop('tbl_comuni');
    }
}
