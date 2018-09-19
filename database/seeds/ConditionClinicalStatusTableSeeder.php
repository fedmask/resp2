<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ConditionClinicalStatus;

class ConditionClinicalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ConditionClinicalStatus.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ConditionClinicalStatus::create(array(
                'code' => $obj->code
            ));
        }
    }
}
