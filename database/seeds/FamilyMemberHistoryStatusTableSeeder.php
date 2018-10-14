<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\FamilyMemberHistoryStatus;

class FamilyMemberHistoryStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/FamilyMemberHistoryStatus.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            FamilyMemberHistoryStatus::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}
