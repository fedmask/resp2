<?php

use Illuminate\Database\Seeder;
use App\Models\CodificheFHIR\ProviderRole;

class ProviderRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/ProviderRole.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            ProviderRole::create(array(
                'code' => $obj->code,
                'display' => $obj->display
            ));
        }
    }
}
