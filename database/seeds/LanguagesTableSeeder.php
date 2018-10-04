<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\Language;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/languages.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Language::create(array(

                'Code' => $obj->code,
                'Display' => $obj->display

            ));
        }
    }
}
