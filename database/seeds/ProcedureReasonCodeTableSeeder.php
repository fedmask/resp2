<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ProcedureReasonCode;

class ProcedureReasonCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ProcedureReasonCode.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ProcedureReasonCode::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}
