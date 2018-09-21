<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\AllergyIntolleranceReactionSeverity;

class AllergyIntolleranceReactionSeverityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    $json = File::get("database/data/AllergyIntolleranceReactionSeverity.json");
    $data = json_decode($json);
    foreach ($data as $obj) {
        AllergyIntolleranceReactionSeverity::create(array(
            'code' => $obj->code
        ));
    }
}
}
