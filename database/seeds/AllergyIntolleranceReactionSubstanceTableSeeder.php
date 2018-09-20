<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\AllergyIntolleranceReactionSubstance;

class AllergyIntolleranceReactionSubstanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/AllergyIntolleranceReactionSubstance.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            AllergyIntolleranceReactionSubstance::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}
