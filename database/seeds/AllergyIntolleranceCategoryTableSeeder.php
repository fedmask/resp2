<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\AllergyIntolleranceCategory;

class AllergyIntolleranceCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/AllergyIntolleranceCategory.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            AllergyIntolleranceCategory::create(array(
                'code' => $obj->code
            ));
        }
    }
}
