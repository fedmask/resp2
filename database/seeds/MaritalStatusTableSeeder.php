<?php

use Illuminate\Database\Seeder;

use App\Models\CodificheFHIR\MaritalStatus;


class MaritalStatusTableSeeder extends Seeder
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
            MaritalStatus::create(array(
                'code' => $obj->code,
                'text' => $obj->display
            ));
        }
    }

}

