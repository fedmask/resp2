<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ConditionEvidenceCode;

class ConditionEvidenceCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ConditionEvidenceCode.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ConditionEvidenceCode::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}
