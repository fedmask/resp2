<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCareProviderTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'tbl_care_provider';

    /**
     * Run the migrations.
     * @table tbl_care_provider
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_cpp');
            $table->integer('id_utente')->unsigned();
            $table->string('cpp_nome', 45);
            $table->string('cpp_cognome', 45);
            $table->date('cpp_nascita_data');
            $table->char('cpp_codfiscale', 16);
            $table->char('cpp_sesso', 1);
            $table->string('cpp_n_iscrizione', 7);
            $table->string('cpp_localita_iscrizione', 50);
            $table ->string('specializzation',45);

            $table->index(["id_utente"], 'FOREIGN_CPP_UTENTE_idx');

            $table->unique(["cpp_codfiscale"], 'cpp_codfiscale_UNIQUE');
            
            $table->foreign('id_utente', 'FOREIGN_CPP_UTENTE_idx')
                ->references('id_utente')->on('tbl_utenti')
                ->onDelete('no action')
                ->onUpdate('no action');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
