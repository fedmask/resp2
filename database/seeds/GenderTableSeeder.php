<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\Gender;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/Gender.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Gender::create(array(
                'code' => $obj->code
            ));
        }
    }
}
