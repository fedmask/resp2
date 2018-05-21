<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblIDPTOrganiTable extends Migration
{
	//Table Name
	public $set_schema_table = 'tbl_ICD9_IDPT_Organi';
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->char('id_IDPT_Organo', 2)->unique();
            $table->string('descrizione', 20);
            $table->engine = 'InnoDB';
            $table->primary('id_IDPT_Organo');
        });
    }
    


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_ICD9_IDPT_Organi');
    }
}
