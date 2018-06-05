<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnamnesiFTable extends Migration
{
    
    public $set_schema_table = 'tbl_famely_relationship';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->string('codice', 15)->primary();
            $table->string('codice_descrizione', 25);
            $table->text('descrizione');
            $table->integer('id_paziente');
            $table->integer('id_parente');
            $table->string('status',10)->nullable(false);
            $table->string('notDoneReason',10);
            $table->timestamps();
        });
        
        
            
            Schema::table ( 'tbl_anamnesi_familiare', function (Blueprint $table) {
                
                DB::statement ( 'ALTER TABLE tbl_anamnesi_familiare ADD FOREIGN KEY (codice_relazione) REFERENCES tbl_famely_relationship(codice);' );
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
