<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ConditionSeverity;

class ConditionSeverityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ConditionSeverity.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ConditionSeverity::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}
