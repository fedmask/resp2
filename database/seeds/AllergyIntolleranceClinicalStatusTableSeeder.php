<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\AllergyIntolleranceClinicalStatus;

class AllergyIntolleranceClinicalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/AllergyIntolleranceClinicalStatus.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            AllergyIntolleranceClinicalStatus::create(array(
                'code' => $obj->code
            ));
        }
    }
}
