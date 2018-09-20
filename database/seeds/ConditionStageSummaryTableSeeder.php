<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ConditionStageSummary;

class ConditionStageSummaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ConditionStageSummary.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ConditionStageSummary::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}
