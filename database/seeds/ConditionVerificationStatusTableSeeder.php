<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ConditionVerificationStatus;

class ConditionVerificationStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ConditionVerificationStatus.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ConditionVerificationStatus::create(array(
                'code' => $obj->code
            ));
        }
    }
}
