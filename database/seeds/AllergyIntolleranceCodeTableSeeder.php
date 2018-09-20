<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\AllergyIntolleranceCode;

class AllergyIntolleranceCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/AllergyIntolleranceCode.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            AllergyIntolleranceCode::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}
