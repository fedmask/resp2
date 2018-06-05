<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyCondictionTable extends Migration
{
    
    public $set_schema_table = 'tbl_family_condiction';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('Codice_ICD9', 5)->nullable(false);
            $table->string('outCome', 45)->nullable(false);
            $table->integer('id_anamnesi_familiare')->nullable(false);
            $table->boolean('onSetAge')->default(true);
            $table->integer('onSetAgeRange_low');
            $table->integer('onSetAgeRange_hight');
            $table->integer('onSetAgeUnit');
            $table->integer('onSetAgeValue');
            $table->timestamps();
            
            $table->foreign('Codice_ICD9', 'FOREIGN_Icd9')
            ->references('Codice_ICD9')->on('Tbl_ICD9_ICPT')
            ->onDelete('no action')
            ->onUpdate('no action');
            
    
            
        });
        
        
            Schema::table ( 'tbl_anamnesi_familiare', function (Blueprint $table) {
                
                DB::statement ( 'ALTER TABLE tbl_anamnesi_familiare ADD FOREIGN KEY (condizione) REFERENCES tbl_family_condiction(id);' );
            } );
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
