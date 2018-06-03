<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblATCSottogruppoCTFTable extends Migration
{
    
    
    public $set_schema_table = 'tbl_ATC_sottogruppo_ctf';
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
            $table->char('codice_sctf',5)->nullable(false);
            $table->char('codice_stf',4)->nullable(false);
            $table->char('sctf',1)->nullable(false);
            $table->string('descrizione',45)->nullable(false);
            $table->primary(['codice_sctf', 'codice_stf']);
            
            
            
            
            $table->foreign('codice_stf', 'fk_tbl_sottogruppo_tf_SCTF_idx')
            ->references('codice_stf')->on('tbl_ATC_sottogruppo_tf')
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
