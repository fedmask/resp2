<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\AllergyIntolleranceType;

class AllergyIntolleranceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/AllergyIntolleranceType.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            AllergyIntolleranceType::create(array(
                'code' => $obj->code
            ));
        }
    }
}
