<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ImmunizationVaccineCode;

class ImmunizationVaccineCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ImmunizationVaccineCode.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ImmunizationVaccineCode::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}
