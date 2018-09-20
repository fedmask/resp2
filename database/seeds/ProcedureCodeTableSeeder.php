<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ProcedureCode;

class ProcedureCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ProcedureCode.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ProcedureCode::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}
