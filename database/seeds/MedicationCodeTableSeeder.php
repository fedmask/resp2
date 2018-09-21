<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\MedicationCode;

class MedicationCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/MedicationCode.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            MedicationCode::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}
