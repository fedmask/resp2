<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\AllergyIntolleranceCriticality;

class AllergyIntolleranceCriticalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/AllergyIntolleranceCriticality.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            AllergyIntolleranceCriticality::create(array(
                'code' => $obj->code
            ));
        }
    }
}
