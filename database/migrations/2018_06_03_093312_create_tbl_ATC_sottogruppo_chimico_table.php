<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblATCSottogruppoChimicoTable extends Migration
{
    
    public $set_schema_table = 'tbl_ATC_sottogruppo_chimico';
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
            $table->char('codice_SC',7)->nullable(false);
            $table->char('codice_sctf',5)->nullable(false);
            $table->char('SC',2)->nullable(false);
            $table->string('descrizione',45)->nullable(false);
            $table->primary(['codice_SC', 'codice_sctf']);
            
            
            
            $table->foreign('codice_sctf', 'fk_tbl_SCFT_SC_idx')
            ->references('codice_sctf')->on('tbl_ATC_sottogruppo_ctf')
            ->onDelete('no action')
            ->ouUpdate('no action');
        
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
