<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\FamilyMemberHistoryConditionOutcome;

class FamilyMemberHistoryConditionOutcomeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $json = File::get("database/data/FamilyMemberHistoryConditionOutcome.json");
    $data = json_decode($json);
    foreach ($data as $obj) {
        FamilyMemberHistoryConditionOutcome::create(array(
            'code' => $obj->code,
            'text' => $obj->display
        ));
    }
}
}
