<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TypesUsersTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(TownTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(PatientsTableSeeder::class);
    }
}
