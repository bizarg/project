<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => bcrypt('gEjU1D'),
            'email' => 'admin@admin',
            'api_key' => 'gEjU1D',
            'sex' => 'male',
         ]);
    }
}
