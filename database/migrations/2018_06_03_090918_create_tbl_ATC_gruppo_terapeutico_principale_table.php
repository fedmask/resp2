<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblATCGruppoTerapeuticoPrincipaleTable extends Migration
{
    public $set_schema_table = 'tbl_ATC_gruppo_terapeutico_prin';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable ( $this->set_schema_table ))
            return;
            Schema::create($this->set_schema_table, function (Blueprint $table) {
                $table->engine = 'MyISAM';
                $table->char('codice_gtp',3)->nullable(false);
                $table->char('codice_gap',1)->nullable(false);
                $table->integer('codice_gruppo_tp',2)->nullable(false);
                $table->string('descrizione',45)->nullable(false);
                $table->primary(['codice_gtp', 'codice_gap']);
               
                
                
                
                
                $table->foreign('codice_gap', 'fk_tbl_gruppo_terapeutico_idx')
                ->references('codice_gap')->on('tbl_ATC_gruppo_anatomico_principale');
                
                
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
