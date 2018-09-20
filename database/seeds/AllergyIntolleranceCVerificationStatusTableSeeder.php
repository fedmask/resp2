<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\AllergyIntolleranceVerificationStatus;

class AllergyIntolleranceCVerificationStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/AllergyIntolleranceVerificationStatus.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            AllergyIntolleranceVerificationStatus::create(array(
                'code' => $obj->code
            ));
        }
    }
}
