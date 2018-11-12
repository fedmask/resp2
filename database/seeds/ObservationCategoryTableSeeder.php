<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ObservationCategory;

class ObservationCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ObservationCategory.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ObservationCategory::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}
