<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCppSpecializationTable extends Migration
{
    public $set_schema_table = 'tbl_cpp_specialization';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->increments('id_cpp_specialization');
            $table->integer('id_specialization')->unsigned();
            $table->integer('id_cpp')->unsigned();
            
            $table->foreign('id_cpp', 'FOREIGN_CPP_Specialization_idx')
            ->references('id_cpp')->on('tbl_care_provider')
            ->onDelete('no action')
            ->onUpdate('no action');
            
            $table->foreign('id_specialization', 'FOREIGN_Specialization_Cpp_idx')
            ->references('id_spec')->on('tbl_specialization')
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
