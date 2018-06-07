<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblFamilyCondictionTable extends Migration
{
    
    public $set_schema_table = 'tbl_FamilyCondiction';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( $this->set_schema_table, function (Blueprint $table) {
           
            $table->increments('id_Condition');
            $table->string('Codice_ICD9', 5)->nullable(false);
            $table->string('outCome', 45)->nullable(false);
            $table->integer('id_parente')->unsigned();
            $table->boolean('onSetAge')->default(true);
            $table->integer('onSetAgeRange_low');
            $table->integer('onSetAgeRange_hight');
            $table->integer('onSetAgeValue');
            $table->text('Note');
            $table->timestamps();
            
            $table->foreign('Codice_ICD9', 'FOREIGN_Diagn_Condition')
            ->references('Codice_ICD9')->on('Tbl_ICD9_ICPT')
            ->onDelete('no action')
            ->onUpdate('no action');
            
            $table->foreign('id_parente', 'FOREIGN_Parente_Condition')
            ->references('id_parente')->on('tbl_Parente')
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
