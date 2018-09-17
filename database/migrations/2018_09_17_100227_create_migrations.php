<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	
	
	public function up()
	{
		
		//$file = File::get("database/data/RESP_v2.sql");
		$file = realpath('database/data/RESP_v2.sql');
		DB::unprepared( file_get_contents($file) );
	}
	
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop('RESP');
    }
}
