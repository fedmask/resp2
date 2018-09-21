<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\StatiMatrimoniali;

class StatiMatrimonialiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/MaritalStatus.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            StatiMatrimoniali::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}
