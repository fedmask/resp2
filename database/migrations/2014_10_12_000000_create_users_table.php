<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        /*
         * Andrebbe evitato solo l'ip come chiave in quanto se più accessi falliscono dallo stesso ip
         * Eseguiti da più terminali il blocco sarebbe quasi immediato. Valutare l'idea di migliorarlo
         */
        //TODO: Ricordati di mettere dei valori di default per alcune tabelle (es: utente_stato = 0)
        Schema::create('tbl_accessi', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('ip', 39);
            $table->tinyInteger('accesso_contatore');
            $table->dateTime('accesso_data');
            
            $table->primary('ip');
        });
            
        Schema::create('tbl_utenti_tipologie', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id_tipologia');
            $table->string('tipologia_descrizione', 100);
        });
                
        Schema::create('tbl_utenti', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_utente');
            $table->unsignedTinyInteger('utente_tipologia');
            $table->string('utente_nome', 50);
            $table->string('utente_password', 130);
            $table->tinyInteger('utente_stato')->default(0);
            $table->date('utente_scadenza');
            $table->string('utente_email', 100);
            
            $table->foreign('utente_tipologia')->references('id_tipologia')->on('tbl_utenti_tipologie');
         });            
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        if (Schema::hasTable('tbl_utenti')) {
            
            Schema::table('tbl_utenti', function ($table) {
                $table->dropForeign(['utente_tipologia']);
            });
            
            Schema::drop('tbl_utenti');
        }
        
        if (Schema::hasTable('tbl_accessi')) {
            Schema::drop('tbl_accessi');
        }
        
        if (Schema::hasTable('tbl_utenti_tipologie')) {
            Schema::drop('tbl_utenti_tipologie');
        }
       
    }
}
