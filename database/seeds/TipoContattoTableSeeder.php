<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\TipoContatto;

class TipoContattoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/TipoContatto.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            TipoContatto::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }
}
