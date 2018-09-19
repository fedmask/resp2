<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\QualificationCode;

class QualificationCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/QualificationCode.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            QualificationCode::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}
